<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Air Quality Measurement Widget</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/vue-toasted@2.1.2/dist/vue-toasted.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f3f4f6;
            /* display: flex; */

            height: 100vh;
            margin: 0;
        }

        .widget {
            background: linear-gradient(145deg, #e0f7fa, #ffffff);
            /* border-radius: 15px; */
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
            padding: 20px;
            /* width: 320px; */
            text-align: center;
            /* transition: transform 0.3s ease; */
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
        <widget inline-template>
            <div class="">

                <div v-if="true" class="row no-gutters">
                    <div class="col-md-3 col-xs-12 align-self-center">
                        <div class="card">
                            <div>
                                <div class="widget">
                                    <h2>Air Quality Measurement</h2>
                                    <template  v-for="(value, key) in aqiData" >
                                        <div class="measurement" @click="switchChart(keyLabels[key])" :key="key">
                                            <label>@{{ keyLabels[key].label }}:</label>
                                            <span>@{{ value }} @{{ keyLabels[key].unit }}</span>
                                        </div>
                                    </template>
                                    <div class="advisory" v-if="aqiData.humidity > 60">
                                        High humidity levels detected. Consider using a dehumidifier.
                                    </div>
                                    <div class="advisory" v-if="aqiData.co2 > 1000">
                                        High CO₂ levels detected. Ensure good ventilation.
                                    </div>
                                    <div class="subscribe">
                                        <button class="btn btn-primary" @click="showModal = true">Subscribe to Notifications</button>
                                    </div>
                                </div>
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
                        </div>
                    </div>
                    <div class="col-md-9 col-xs-12 align-self-center">
                        <div class="card">
                            <div class="card-body">
                                <div class="container">
                                    <div class="row">
                                        <div class="columns">
                                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                            <label class="btn btn-light" :class="{ active: selectedOption === '24hrs' }">
                                                <input type="radio" name="options" id="24hrs" value="24hrs" v-model="selectedOption"> 24 hrs
                                            </label>
                                            <label class="btn btn-light" :class="{ active: selectedOption === 'lastweek' }">
                                                <input type="radio" name="options" id="lastweek" value="lastweek" v-model="selectedOption"> Last week
                                            </label>
                                            <!-- <label class="btn btn-light" :class="{ active: selectedOption === 'lastmonth' }">
                                                <input type="radio" name="options" id="lastmonth" value="lastmonth" v-model="selectedOption"> Last Month
                                            </label> -->
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <line-chart-container :key="chartKey" :selected-option="selectedOption" :data-url="selectedItem.url" :title="selectedItem.label" :x-axis-label="selectedItem.xLabel" :y-axis-label="selectedItem.yLabel" :start-date="form.startDate" :end-date="form.endDate"></line-chart-container>
                        </div>
                    </div>
                </div>
            </div>
        </widget>
    </div>

    <!-- <script src="https://cdn.jsdelivr.net/npm/vue@2"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/vue-toasted@2.1.2/dist/vue-toasted.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>
    <script src="{{mix('js/admin.js')}}" type="text/javascript"></script>
</body>

</html>