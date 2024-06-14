import _ from 'lodash'
import { Line } from 'vue-chartjs'

export default {
  extends: Line,
  props: {
    chartdata: {
      type: Object,
      default: null
    },
    options: {
      type: Object,
      default: {
        options: {

          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: true
              },
              gridLines: {
                display: false
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
        }

      }
    }
  },
  methods: {
    hexToRgbA(hex, aplha) {
      var c;
      if (/^#([A-Fa-f0-9]{3}){1,2}$/.test(hex)) {
        c = hex.substring(1).split('');
        if (c.length == 3) {
          c = [c[0], c[0], c[1], c[1], c[2], c[2]];
        }
        c = '0x' + c.join('');
        return 'rgba(' + [(c >> 16) & 255, (c >> 8) & 255, c & 255].join(',') + `,${aplha})`;
      }
      throw new Error('Bad Hex');
    },
    stringToColour(str, aplha) {
      var hash = 0;
      for (var i = 0; i < str.length; i++) {
        hash = str.charCodeAt(i) + ((hash << 5) - hash);
      }
      var colour = '#';
      for (var i = 0; i < 3; i++) {
        // var value = (hash >> (i * 8));
        var value = (hash >> (i * 10)) & 0xFF;
        colour += ('00' + value.toString(16)).substr(-2);
      }
      return this.hexToRgbA(colour, aplha);
    }
  },
  mounted() {
    this.chartdata.datasets = this.chartdata.datasets.map(elem => {

      const color = this.stringToColour(elem.label, 0.5);
      // const bgColor = this.stringToColour(category.category_name, 0.3);

      let gradient = this.$refs.canvas.getContext('2d').createLinearGradient(0, 0, 0, 450)

      gradient.addColorStop(0, this.stringToColour(elem.label, 0.5));
      gradient.addColorStop(0.5, this.stringToColour(elem.label, 0.25));
      gradient.addColorStop(1, this.stringToColour(elem.label, 0));

      elem.backgroundColor = gradient;
      elem.borderColor = color;
      return elem;

    });
    this.renderChart(this.chartdata, this.options)
  }
}