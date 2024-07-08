Vue.component('widget', {
    // mixins: [AppListing],
    props: {  },
    data: function () {
        return {
            // data: @json($data),
            keyLabels: {
                humidity: 'Humidity',
                temperature: 'Temperature',
                pm1_5: 'PM1.5',
                pm10: 'PM10',
                tvoc: 'TVOC',
                co2: 'CO₂'
            },
            showModal: false,
            email: '',
            aqiData: {},
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
        loadData: async function () {
            try {
                const apiUrl = "/api/get-widget-data";
                const data = await axios.get(
                    apiUrl
                );
                debugger
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