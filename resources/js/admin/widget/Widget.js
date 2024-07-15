Vue.component('widget', {
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
                pm2_5: {
                    label: 'PM2.5',
                    url: 'dashboard/line-chart-pm-2-5',
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
            },
            showModal: false,
            email: '',
            aqiData: {},
            selectedItem: {},
            chartKey: +new Date(),
            // selectedOption: '24hrs',
            aqiIndex: {},
            messages: {},
            selectedChartItem: 'pm2_5',

            currentTime: '',
            dayName: '',
            lastweek: null,
            lastUpdatedAt: null,
            chartConfigOption: {
                dataUrl: '',
                selectedOption: '24hrs',
                selectedChartItem: 'pm2_5',
                xLabel: '',
                yLabel: '',
                title: '',
            }
        }
    },
    async mounted() {
        if (this.apiData) {
            this.aqiData = this.apiData;
        }

        await this.loadData();
        this.switchChart(this.keyLabels.co2);

        setInterval(this.loadData, 10000);

        this.updateTime();
        setInterval(this.updateTime, 1000);
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
        formatTimeAgo(timestamp) {
            const date = new Date(timestamp);
            return date.toLocaleTimeString(navigator.language, {hour: '2-digit', minute:'2-digit'});
        },
        updateTime() {
            const now = new Date();
            const options = { year: 'numeric', month: '2-digit', day: '2-digit', hour: '2-digit', minute: '2-digit' };
            this.currentTime = now.toLocaleDateString('en-GB', options).replace(/,/g, '');
            this.dayName = now.toLocaleDateString('en-US', { weekday: 'long' });
        },
        switchChart(item) {
            this.chartConfigOption.dataUrl = item.url;
            this.chartConfigOption.xLabel = item.xLabel;
            this.chartConfigOption.yLabel = item.yLabel;
            this.chartConfigOption.label = item.label;
            this.chartConfigOption.unit = item.unit;
            this.selectedItem = item;
        },
        loadData: async function () {
            try {
                const apiUrl = "/api/get-widget-data";
                const data = await axios.get(apiUrl);
                this.aqiData = data.data.data;
                this.messages = data.data.messages.messages;
                this.aqiIndex = data.data.aqi_index;
                this.lastUpdatedAt = data.data.updated_at;
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
