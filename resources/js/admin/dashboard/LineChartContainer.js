import axios from "axios";
import * as _ from "lodash";
import LineChart from "./LineChart";

Vue.component("line-chart-container", {
  name: "line-chart-container",
  template: `
  <div>
    <template>
      <div class="container">
        <line-chart v-if="loaded && chartdata" :data="chartdata" :chartdata="chartdata" :options="options" />
      </div>
    </template>
  </div>`,
  components: { LineChart },

  props: {
    dataUrl: {
      type: String,
      require: true,
    },
    title: {
      type: String,
      require: true,
    },
    startDate: {
      type: String,
      require: true,
    },
    endDate: {
      type: String,
      require: true,
    },
  },
  data: () => ({
    loaded: false,
    chartdata: null,
    options: {
      plugins: {
        customCanvasBackgroundColor: {
          color: 'lightGreen',
        },
        colors: {
          enabled: false
        },
        title: {
          display: true,
          text: 'Custom Chart Title',
          font: { 
            // weight: 'fett', 
            size: 18 
        } ,
          padding: {
              top: 10,
              bottom: 30
          }
        },
      },
      title: {
        display: true,
        text: ""
      },
      scales: {
        y: {
          title: {
            text: 'AQI',
            display: true,
          },
          ticks: {
            beginAtZero: true,
            // stepSize: 1,
          },
          // gridLines: {
          //   display: true
          // },
          // scaleLabel: {
          //   display: true,
          //   labelString: 'Y Axis Label'
          // }
        },
        x: {
          title: {
            text: 'Hours',
            display: true,
          },
          
          // gridLines: {
          //   display: false
          // },
          // scaleLabel: {
          //   display: true,
          //   labelString: 'X Axis Label'
          // }
        }
      },
      legend: {
        display: true,
      },
      responsive: true,
      maintainAspectRatio: true
    },
  }),
  async mounted() {
    this.loaded = false;
    this.options.title = this.title;
    await this.loadData();
  },
  watch: {
    startDate: async function (newForm, oldForm) {
      this.resetState();
      await this.loadData();
    },
    endDate: async function (newForm, oldForm) {
      this.resetState();
      await this.loadData();
    },
  },
  methods: {
    hexToRgbA(hex, alpha) {
      var c;
      if (/^#([A-Fa-f0-9]{3}){1,2}$/.test(hex)) {
        c = hex.substring(1).split('');
        if (c.length == 3) {
          c = [c[0], c[0], c[1], c[1], c[2], c[2]];
        }
        c = '0x' + c.join('');
        return 'rgba(' + [(c >> 16) & 255, (c >> 8) & 255, c & 255].join(',') + `,${alpha})`;
      }
      throw new Error('Bad Hex');
    },
    stringToColour(str, alpha) {
      var hash = 0;
      for (var i = 0; i < str.length; i++) {
        hash = str.charCodeAt(i) + ((hash << 5) - hash);
      }
      var colour = '#';
      for (var i = 0; i < 3; i++) {
        var value = (hash >> (i * 10)) & 0xFF;
        colour += ('00' + value.toString(16)).substr(-2);
      }
      return this.hexToRgbA(colour, alpha);
    },
    resetState() {
      this.loaded = false;
    },
    loadData: async function () {
      try {
        const userlist = await axios.get(
          this.dataUrl +
          `?start_date=${this.startDate}&end_date=${this.endDate}`
        );

        const labels = _.uniqBy(userlist.data, (elem) => elem.date).map(elem => elem.date);
        const categories = _.uniqBy(
          userlist.data,
          (elem) => elem.category_name
        );

        let totalDataPoints = [];
        labels.forEach((label, ind) => {
          totalDataPoints.push(_.sumBy(userlist.data, (elem) => elem.date == label ? elem.total : 0));
        });

        let totalDataSet = {
          label: 'AQI',
          borderWidth: 1,
          data: totalDataPoints,
        };

        let dataSets = [totalDataSet];

        categories.forEach((category, key) => {
          let categoryData = userlist.data
            .filter((item) => item.category_name == category.category_name)
            .map((item) => item.total);

          dataSets.push({
            label: category.category_name,
            data: categoryData,
            // borderWidth: 1,
            fill: true,
            tension: 0.1,
            // fillColor: "rgba(151,187,205,0.2)",
            // strokeColor: "rgba(151,187,205,1)",
            // pointColor: "rgba(151,187,205,1)",
            // pointStrokeColor: "#fff",
            // pointHighlightFill: "#fff",
            // pointHighlightStroke: "rgba(151,187,205,1)",
            borderColor: this.stringToColour(category.category_name, 0.8),
          });
        });

        this.chartdata = {
          labels: labels,
          datasets: dataSets,
        };
        this.loaded = true;
      } catch (e) {
        console.error(e);
      }
    },
  },
});
