import axios from 'axios';
import AppForm from '../app-components/Form/AppForm';
import CommitChart from './CommitChart';
// import BarChartContainer from  './BarChartContainer.vue';
// import LineChartContainer from  './LineChartContainer.vue';

Vue.component('dashboard', {
    mixins: [AppForm],
    component: {
      // 'CommitChart': CommitChart,
    //   'bar-chart-container': BarChartContainer,
    //   'line-chart-container': LineChartContainer,
    },
    props: {
        // statuses: {
        //     type: Array,
        //     required: true,
        // },
    },
    data: function () {
        return {
            form: {
                startDate: moment().subtract('7', 'days').format('YYYY-MM-DD'),
                endDate: moment().format('YYYY-MM-DD'),
            },
            isLoading: false,
        }
    },
    mounted() {
    },
    methods: {
        reloadStats() {

        }
    }

});