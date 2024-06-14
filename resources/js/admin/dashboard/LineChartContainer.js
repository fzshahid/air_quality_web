import axios from "axios";
import * as _ from "lodash";
import LineChart from "./LineChart";

Vue.component("line-chart-container", {
  name: "line-chart-container",
  template: `
  <div>
    <template>
      <div class="container">
        <line-chart v-if="loaded" :chartdata="chartdata" :options="options" />
      </div>
    </template>
  </div>`,
  components: { LineChart },

  props: {
    dataUrl: {
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
      title: {
        display: true,
        text: "Offers by Category"
      },
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true,
            stepSize: 1,
          },
          gridLines: {
            display: true
          }
        }],
        xAxes: [{
          gridLines: {
            display: false
          }
        }]
      },
      legend: {
        display: true
      },
      responsive: true,
      maintainAspectRatio: false
    },
  }),
  async mounted() {
    this.loaded = false;
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
    resetState() {
      this.loaded = false;
      // this.showError = false;
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
          label: 'Total Offers',
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
            borderWidth: 1,
          });
        });

        this.chartdata = {
          labels: labels,
          datasets: dataSets,
        };
        // this.options = null;
        this.loaded = true;
      } catch (e) {
        console.error(e);
      }
    },
  },
});
// Vue.component("line-chart-container", LineChartContainer);
// export default LineChartContainer;
// </script>