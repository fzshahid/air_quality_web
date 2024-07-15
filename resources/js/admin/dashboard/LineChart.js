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
      required: true,
    }
  },
  methods: {

  },
  mounted() {
  },
  plugins: [
    {
      id: 'customCanvasBackgroundColor',
      beforeDraw: (chart, args, options) => {
      },
      defaults: {
        color: 'lightGreen'
      }
    }
  ]
};
