import _ from 'lodash';
import { Line } from 'vue-chartjs';
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  LineElement,
  CategoryScale,
  LinearScale,
  PointElement,
  plugins,
  Colors,
  Filler
} from 'chart.js';

// Register Chart.js components
ChartJS.register(Title, Tooltip, Legend, LineElement, CategoryScale, LinearScale, PointElement, Colors, Filler);

export default {
  extends: Line,
  props: {
    chartdata: {
      type: Object,
      default: null
    },
    options: {
      type: Object,
      default: () => ({
        plugins: {
          customCanvasBackgroundColor: {
            color: 'lightGreen',
          }
        },
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true
            },
            gridLines: {
              display: false
            },
            // scaleLabel: {
            //   display: true,
            //   labelString: 'Y Axis Label'
            // }
          }],
          xAxes: [{
            gridLines: {
              display: false
            },
            // scaleLabel: {
            //   display: true,
            //   labelString: 'X Axis Label'
            // }
          }]
        },
        legend: {
          display: true
        },
        responsive: true,
        maintainAspectRatio: false
      })
    }
  },
  methods: {

  },
  mounted() {
    // const ctx = this.$refs.canvas.getContext('2d');
    // this.chartdata.datasets = this.chartdata.datasets.map(elem => {
    //   const color = this.stringToColour(elem.label, 0.5);
    //   const gradient = ctx.createLinearGradient(0, 0, 0, 450);
    //   gradient.addColorStop(0, this.stringToColour(elem.label, 0.5));
    //   gradient.addColorStop(0.5, this.stringToColour(elem.label, 0.25));
    //   gradient.addColorStop(1, this.stringToColour(elem.label, 0));
    //   elem.backgroundColor = gradient;
    //   // elem.borderColor = color;
    //   return elem;
    // });
    // this.renderChart(this.chartdata, this.options);

  },
  plugins: [
    {
      id: 'customCanvasBackgroundColor',
      beforeDraw: (chart, args, options) => {
        // const { ctx } = chart;
        // ctx.save();
        // ctx.globalCompositeOperation = 'destination-over';
        // ctx.fillStyle = options.color;
        // ctx.fillRect(0, 0, chart.width, chart.height);
        // ctx.restore();

        // this.chartdata.datasets = this.chartdata.datasets.map(elem => {
        //   const color = this.stringToColour(elem.label, 0.5);
        //   const gradient = ctx.createLinearGradient(0, 0, 0, 450);
        //   gradient.addColorStop(0, this.stringToColour(elem.label, 0.5));
        //   gradient.addColorStop(0.5, this.stringToColour(elem.label, 0.25));
        //   gradient.addColorStop(1, this.stringToColour(elem.label, 0));
        //   elem.backgroundColor = gradient;
        //   // elem.borderColor = color;
        //   return elem;
        // });
        // this.renderChart(this.chartdata, this.options);
      },
      defaults: {
        color: 'lightGreen'
      }
    }
  ]
};
