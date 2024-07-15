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
    chartConfigOption: {
      required: true,
      type: Object,
    },
    // selectedOption: {
    //   required: true,
    //   default: '24hrs',
    // },
    // dataUrl: {
    //   type: String,
    //   required: true,
    // },
    // title: {
    //   type: String,
    //   required: true,
    // },
    startDate: {
      type: String,
      required: true,
    },
    endDate: {
      type: String,
      required: true,
    },
    // xAxisLabel: {
    //   type: String,
    //   required: true,
    // },
    // yAxisLabel: {
    //   type: String,
    //   required: true,
    // },
  },
  data: () => ({
    loaded: false,
    chartdata: null,
    categoriesMap: {
      temperature: 'Temperature',
      co2: 'CO₂',
      eco2: 'eCO₂',
      humidity: 'Humidity',
      tvoc: 'Tvoc',
      pm1: 'PM1',
      pm2_5: 'PM2.5',
      pm4: 'PM4',
      pm10: 'PM10',
    },
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
          text: '',
          font: { 
            size: 18 
          },
          padding: {
            top: 5,
            bottom: 5
          }
        },
        legend: {
          display: true,
        },
      },
      scales: {
        y: {
          beginAtZero: true,
          title: {
            text: 'k',
            display: true,
          },
          
        },
        x: {
          title: {
            text: '',
            display: true,
          },
        }
      },
      responsive: true,
      maintainAspectRatio: true
    },
  }),
  async mounted() {
    this.loaded = false;
    // debugger;
    this.options.plugins.title.text = this.chartConfigOption.label;
    this.options.scales.x.title.text = this.chartConfigOption.xLabel;
    this.options.scales.y.title.text = this.chartConfigOption.yLabel;
    // this.options.plugins.title.text = this.title;
    // this.options.scales.x.title.text = this.xAxisLabel;
    // this.options.scales.y.title.text = this.yAxisLabel;
    await this.loadData();
  },
  watch: {
    chartConfigOption: {
      async handler(val){
        
        debugger;
        this.options.plugins.title.text = this.chartConfigOption.label;
        this.options.scales.x.title.text = this.chartConfigOption.xLabel;
        this.options.scales.y.title.text = this.chartConfigOption.yLabel;
        await this.loadData();
      },
      deep: true
   }
    // startDate: 'loadData',
    // endDate: 'loadData',
    // chartConfigOption: 'loadData',
    // dataUrl: 'loadData',
    // 'chartConfigOption': function () {
    //   // deep: true,
    //   // handle: () => {
    //     this.options.plugins.title.text = this.chartConfigOption.label;
    //     this.options.scales.x.title.text = this.chartConfigOption.xLabel;
    //     this.options.scales.y.title.text = this.chartConfigOption.yLabel;
    //     // await this.loadData();
    //   // }
    // }
  },
  computed: {
    // options() {
      
    // }
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
    async loadData() {
      try {
        const response = await axios.get(
          `${this.chartConfigOption.dataUrl}?start_date=${this.startDate}&end_date=${this.endDate}&last=${this.chartConfigOption.selectedOption}`
        );

        const userlist = response.data;
        const labels = _.uniqBy(userlist, 'date').map(elem => elem.date);
        const categories = _.uniqBy(userlist, 'category_name');

        let totalDataPoints = labels.map(label => {
          return _.sumBy(userlist, elem => elem.date === label ? elem.total : 0);
        });

        // let totalDataSet = {
        //   label: 'AQI',
        //   borderWidth: 1,
        //   data: totalDataPoints,
        // };

        // let dataSets = [totalDataSet];
        let dataSets = [];

        categories.forEach(category => {
          let categoryData = userlist
            .filter(item => item.category_name === category.category_name)
            .map(item => item.total);

          dataSets.push({
            label: this.categoriesMap.hasOwnProperty(category.category_name) ? this.categoriesMap[category.category_name] : category.category_name,
            data: categoryData,
            fill: true,
            tension: 0.15,
            borderColor: this.stringToColour(category.category_name, 0.8),
          });
        });

        this.chartdata = {
          labels: labels,
          datasets: dataSets,
        };
        this.loaded = true;
      } catch (error) {
        console.error(error);
      }
    },
  },
});
