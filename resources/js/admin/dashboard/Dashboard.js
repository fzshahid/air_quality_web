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
            keyLabels: {
                humidity: {
                    label: 'Humidity',
                    selectedOption: '24hrs',
                    dataUrl: 'dashboard/line-chart-humidity',
                    xLabel: 'Time',
                    yLabel: 'Percentage',
                    unit: '%',
                },
                temperature: {
                    label: 'Temperature',
                    selectedOption: '24hrs',
                    dataUrl: 'dashboard/line-chart-temperature',
                    xLabel: 'Time',
                    yLabel: 'Celcius',
                    unit: '°C',
                },
                pm2_5: {
                    label: 'PM2.5',
                    selectedOption: '24hrs',
                    dataUrl: 'dashboard/line-chart-pm-2-5',
                    xLabel: 'Time',
                    yLabel: 'µg/m³',
                    unit: 'µg/m³',
                },
                pm10: {
                    label: 'PM10',
                    selectedOption: '24hrs',
                    dataUrl: 'dashboard/line-chart-pm-10',
                    xLabel: 'Time',
                    yLabel: 'µg/m³',
                    unit: 'µg/m³',
                },
                pm: {
                    label: 'PM',
                    selectedOption: '24hrs',
                    dataUrl: 'dashboard/line-chart-pm',
                    xLabel: 'Time',
                    yLabel: 'µg/m³',
                    unit: 'µg/m³',
                },
                pm4: {
                    label: 'PM4',
                    selectedOption: '24hrs',
                    dataUrl: 'dashboard/line-chart-pm-4',
                    xLabel: 'Time',
                    yLabel: 'µg/m³',
                    unit: 'µg/m³',
                },
                tvoc: {
                    label: 'TVOC',
                    selectedOption: '24hrs',
                    dataUrl: 'dashboard/line-chart-tvoc',
                    xLabel: 'Time',
                    yLabel: 'ppb',
                    unit: 'ppb',
                },
                co2: {
                    label: 'CO₂',
                    selectedOption: '24hrs',
                    dataUrl: 'dashboard/line-chart-co-2',
                    xLabel: 'Time',
                    yLabel: 'Parts per million',
                    unit: 'ppm',
                },
                eco2: {
                    label: 'eCO₂',
                    selectedOption: '24hrs',
                    dataUrl: 'dashboard/line-chart-co-2',
                    xLabel: 'Time',
                    yLabel: 'Parts per million',
                    unit: 'ppm',
                },
            },
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