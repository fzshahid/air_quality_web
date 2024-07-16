<script>
import axios from "axios";
import BarChart from "./BarChart";
import { template } from "lodash";

const BarChartContainer = {
  name: "bar-chart-container",
  components: { BarChart },
  template: `  <div class="container">
    <bar-chart v-if="loaded" :chartdata="chartdata" :options="options" />
  </div>`,
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
        text: "Users"
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

        this.chartdata = {
          labels: Object.keys(userlist.data),
          datasets: [
            {
              label: "Active Users",
              backgroundColor: "#7a34eb",
              data: Object.values(userlist.data),
            },
          ],
        };
        // this.options = null;
        this.loaded = true;
      } catch (e) {
        console.error(e);
      }
    },
  },
};
Vue.component("bar-chart-container", BarChartContainer);
export default BarChartContainer;
</script>