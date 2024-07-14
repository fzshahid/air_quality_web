Vue.component('widget', {
    // mixins: [AppListing],
    props: {},
    data: function () {
        return {
            form: {
                startDate: moment().subtract('7', 'days').format('YYYY-MM-DD'),
                endDate: moment().format('YYYY-MM-DD'),
            },
            isLoading: false,
            keyLabels: {
                humidity: {
                    label: 'Humidity',
                    url: 'dashboard/line-chart-humidity',
                    xLabel: 'Time',
                    yLabel: 'Percentage',
                    unit: '%',
                },
                temperature: {
                    label: 'Temperature',
                    url: 'dashboard/line-chart-temperature',
                    xLabel: 'Time',
                    yLabel: 'Celcius',
                    unit: '°C',
                },
                pm1_5: {
                    label: 'PM1',
                    url: 'dashboard/line-chart-pm-1',
                    xLabel: 'Time',
                    yLabel: 'µg/m³',
                    unit: 'µg/m³',
                },
                pm2_5: {
                    label: 'PM2.5',
                    url: 'dashboard/line-chart-pm-2-5',
                    xLabel: 'Time',
                    yLabel: 'µg/m³',
                    unit: 'µg/m³',
                },
                pm4: {
                    label: 'PM4',
                    url: 'dashboard/line-chart-pm-4',
                    xLabel: 'Time',
                    yLabel: 'µg/m³',
                    unit: 'µg/m³',
                },
                pm10: {
                    label: 'PM10',
                    url: 'dashboard/line-chart-pm-10',
                    xLabel: 'Time',
                    yLabel: 'µg/m³',
                    unit: 'µg/m³',
                },
                tvoc: {
                    label: 'TVOC',
                    url: 'dashboard/line-chart-tvoc',
                    xLabel: 'Time',
                    yLabel: 'ppb',
                    unit: 'ppb',
                },
                co2: {
                    label: 'CO₂',
                    url: 'dashboard/line-chart-co-2',
                    xLabel: 'Time',
                    yLabel: 'Parts per million',
                    unit: 'ppm',
                },
                eco2: {
                    label: 'eCO₂',
                    url: 'dashboard/line-chart-co-2',
                    xLabel: 'Time',
                    yLabel: 'Parts per million',
                    unit: 'ppm',
                },
                all: {
                    label: 'All Metrices',
                    url: 'dashboard/line-chart-all',
                    xLabel: 'Time',
                    yLabel: '',
                    unit: '',
                },
            },
            showModal: false,
            email: '',
            aqiData: {},
            selectedItem: {},
            chartKey: +new Date(),
            selectedOption: '24hrs',
        }
    },
    async mounted() {
        if (this.apiData) {
            this.aqiData = this.apiData;
        }

        await this.loadData();
        this.switchChart(this.keyLabels.co2);

        // Set interval to load data every 10 seconds
        setInterval(this.loadData, 10000);
    },
    watch: {
        showModal(newValue) {
            if (newValue) {
                $(this.$refs.subscribeModal).modal('show');
            } else {
                $(this.$refs.subscribeModal).modal('hide');
            }
        },
    },
    methods: {
        switchChart(item) {
            this.selectedItem = item;
            this.chartKey++;
        },
        loadData: async function () {
            try {
                const apiUrl = "/api/get-widget-data";
                const data = await axios.get(apiUrl);
                
                this.aqiData = data.data.data;
                this.loaded = true;
            } catch (e) {
                console.error(e);
            }
        },
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
