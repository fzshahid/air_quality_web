import axios from 'axios';
import AppForm from '../app-components/Form/AppForm';

Vue.component('widget', {
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
    data: {
        keyLabels: {
            humidity: 'Humidity',
            temperature: 'Temperature',
            pm1_5: 'PM1.5',
            pm10: 'PM10',
            tvoc: 'TVOC',
            co2: 'CO₂'
        },
        units: {
            humidity: '%',
            temperature: '°C',
            pm1_5: 'µg/m³',
            pm10: 'µg/m³',
            tvoc: 'ppb',
            co2: 'ppm'
        },
        showModal: false,
        email: ''
    },
    watch: {
        showModal(newValue) {
            if (newValue) {
                $(this.$refs.subscribeModal).modal('show');
            } else {
                $(this.$refs.subscribeModal).modal('hide');
            }
        }
    },
    methods: {
        subscribe() {
            if (this.email === '') {
                this.$toasted.show("Please enter a valid email address", {
                    type: 'error',
                    duration: 3000
                });
                return;
            }

            axios.post('/api/subscribe', { email: this.email })
                .then(response => {
                    this.$toasted.show("Successfully subscribed!", {
                        type: 'success',
                        duration: 3000
                    });
                    this.showModal = false;
                    this.email = '';
                })
                .catch(error => {
                    this.$toasted.show("Subscription failed", {
                        type: 'error',
                        duration: 3000
                    });
                });
        }
    }
});