Vue.component('widget', {
    // mixins: [AppListing],
    props: {  },
    data: function () {
        return {
            form: {
                startDate: moment().subtract('7', 'days').format('YYYY-MM-DD'),
                endDate: moment().format('YYYY-MM-DD'),
            },
            isLoading: false,
            // data: @json($data),
            keyLabels: {
                humidity: {
                    label: 'Humidity',
                    url: 'dashboard/line-chart-co-2',
                    xLabel: 'Time',
                    yLabel: 'Percentage',
                },
                temperature: {
                    label:  'Temperature',
                    url: 'dashboard/line-chart-co-2',
                    xLabel: 'Time',
                    yLabel: 'Celcius',
                },
                pm1_5: {
                    label:  'PM1.5',
                    url: 'dashboard/line-chart-co-2',
                    xLabel: 'Time',
                    yLabel: 'Parts per billion',
                },
                pm10: {
                    label:  'PM10',
                    url: 'dashboard/line-chart-co-2',
                    xLabel: 'Time',
                    yLabel: 'Parts per billion',
                },
                tvoc: {
                    label:  'TVOC',
                    url: 'dashboard/line-chart-co-2',
                    xLabel: 'Time',
                    yLabel: 'Parts per billion',
                },
                co2: {
                    label:  'CO₂',
                    url: 'dashboard/line-chart-co-2',
                    xLabel: 'Time',
                    yLabel: 'Parts per billion',
                },
            },
            showModal: false,
            email: '',
            aqiData: {},
            selectedItem: {},
            chartKey: +new Date(),
        }
    },
    async mounted() {
        if (this.apiData) {
            this.aqiData = this.apiData;
        }

        await this.loadData();
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
        switchChart(item) {
            this.selectedItem = item;
            this.chartKey++;
        },
        loadData: async function () {
            try {
                const apiUrl = "/api/get-widget-data";
                const data = await axios.get(
                    apiUrl
                );
                
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