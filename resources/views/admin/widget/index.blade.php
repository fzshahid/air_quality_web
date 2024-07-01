<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Air Quality Measurement Widget</title>
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/vue-toasted@2.1.2/dist/vue-toasted.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f3f4f6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .widget {
            background: linear-gradient(145deg, #e0f7fa, #ffffff);
            border-radius: 15px;
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 320px;
            text-align: center;
            transition: transform 0.3s ease;
        }
        .widget:hover {
            transform: scale(1.05);
        }
        .widget h2 {
            margin-top: 0;
            font-size: 24px;
            color: #00796b;
        }
        .measurement {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 15px 0;
            padding: 10px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .measurement:last-child {
            margin-bottom: 0;
        }
        label {
            font-weight: bold;
            color: #004d40;
        }
        span {
            font-size: 18px;
            color: #004d40;
        }
        .advisory {
            font-size: 14px;
            color: #ff5722;
            margin-top: 10px;
        }
        .subscribe {
            margin-top: 20px;
        }
        .subscribe button {
            background-color: #00796b;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        .subscribe button:hover {
            background-color: #004d40;
        }
        @media (max-width: 480px) {
            .widget {
                width: 90%;
                padding: 15px;
            }
            .measurement {
                flex-direction: column;
                align-items: flex-start;
            }
            span {
                margin-top: 5px;
            }
        }
    </style>
</head>
<body>
    <div id="app">
        <div class="widget">
            <h2>Air Quality Measurement</h2>
            <div class="measurement" v-for="(value, key) in data" :key="key">
                <label>@{{ keyLabels[key] }}:</label>
                <span>@{{ value }}</span>
            </div>
            <div class="advisory" v-if="data.humidity > 60">
                High humidity levels detected. Consider using a dehumidifier.
            </div>
            <div class="advisory" v-if="data.co2 > 1000">
                High CO₂ levels detected. Ensure good ventilation.
            </div>
            <div class="subscribe">
                <button class="btn btn-primary" @click="showModal = true">Subscribe to Notifications</button>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="subscribeModal" tabindex="-1" aria-labelledby="subscribeModalLabel" aria-hidden="true" ref="subscribeModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="subscribeModalLabel">Subscribe to Notifications</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="email" class="form-control" v-model="email" placeholder="Enter your email">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="subscribe">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue-toasted@2.1.2/dist/vue-toasted.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>
    <script>
        // Vue.use(Toasted);

        new Vue({
            el: '#app',
            data: {
                data: @json($data),
                keyLabels: {
                    humidity: 'Humidity',
                    temperature: 'Temperature',
                    pm1_5: 'PM1.5',
                    pm10: 'PM10',
                    tvoc: 'TVOC',
                    co2: 'CO₂'
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
    </script>
</body>
</html>
