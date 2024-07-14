<html>

<head>
    <meta charset="utf-8">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Air Quality Measurement Widget</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <base target="_self">
    <meta name="description" content="A Bootstrap 4 admin dashboard theme that will get you started. The sidebar toggles off-canvas on smaller screens. This example also include large stat blocks, modal and cards. The top navbar is controlled by a separate hamburger toggle button." />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google" value="notranslate">
    <link rel="shortcut icon" href="/images/cp_ico.png">


    <!--stylesheets / link tags loaded here-->


    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/vue-toasted@2.1.2/dist/vue-toasted.min.css" rel="stylesheet">

    <style type="text/css">
        [v-cloak] {
            visibility: hidden;
        }

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

        body,
        html {
            height: 100%;
        }

        @media screen and (max-width: 48em) {
            .row-offcanvas {
                position: relative;
                -webkit-transition: all 0.25s ease-out;
                -moz-transition: all 0.25s ease-out;
                transition: all 0.25s ease-out;
            }

            .row-offcanvas-left .sidebar-offcanvas {
                left: -33%;
            }

            .row-offcanvas-left.active {
                left: 33%;
                margin-left: -6px;
            }

            .sidebar-offcanvas {
                position: absolute;
                top: 0;
                width: 33%;
                height: 100%;
            }
        }

        /*
        * Off Canvas wider at sm breakpoint
        * --------------------------------------------------
        */

        @media screen and (max-width: 34em) {
            .row-offcanvas-left .sidebar-offcanvas {
                left: -45%;
            }

            .row-offcanvas-left.active {
                left: 45%;
                margin-left: -6px;
            }

            .sidebar-offcanvas {
                width: 45%;
            }
        }

        .card {
            overflow: hidden;
        }

        .card-block .rotate {
            z-index: 8;
            float: right;
            height: 100%;
        }

        .card-block .rotate i {
            color: rgba(20, 20, 20, 0.15);
            position: absolute;
            left: 0;
            left: auto;
            right: 5px;
            bottom: 0px;
            display: block;
        }
    </style>

</head>

<body class="bg-inverse">
    <div id="app" v-cloak>
        <widget inline-template>
            <div>

                <!-- <nav class="mb-4 navbar navbar-expand-lg navbar-dark cyan">
                    <a class="navbar-brand font-bold" href="#">Navbar</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-4" aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item active">
                                <a class="nav-link" href="#"><i class="fa fa-envelope"></i> Subscribe <span class="sr-only">(current)</span></a>
                            </li>
                        </ul>
                    </div>
                </nav> -->
                <!-- <nav class="navbar navbar-fixed-top navbar-toggleable-sm navbar-inverse bg-primary mb-3">
                    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#collapsingNavbar">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="flex-row d-flex">
                    <a class="navbar-brand mb-1" href="#">Brand</a>
                    <button type="button" class="hidden-md-up navbar-toggler" data-toggle="offcanvas" title="Toggle responsive left sidebar">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                    </div>
                    <div class="navbar-collapse collapse" id="collapsingNavbar">
                    <ul class="navbar-nav">
                        <li class="nav-item active">
                        <a class="nav-link" href="#">Home <span class="sr-only">Home</span></a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="#features">Features</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="#myAlert" data-toggle="collapse">Wow</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                        <a class="nav-link" href="" data-target="#myModal" data-toggle="modal">About</a>
                        </li>
                    </ul>
                    </div>
                </nav> -->

                <div class="container-fluid p-4" id="main">
                    <div class="row  d-flex justify-content-center">

                        <!--/col-->

                        <div class="col-md-9 col-lg-9 main">
                            <div class="row mb-3">
                                <div class="col-xl-6 col-lg-6 d-flex">
                                    <div class="card">
                                        <div class="card-block">
                                            <h6 class="text-uppercase text-dark">Air Quality PM2.5 <i v-if="messages.pm2_5" class="mdi mdi-alert-circle-outline text-danger "></i></h6>
                                            <div class="h3 text-dark">@{{aqiData.pm2_5}} <span class="text-small text-dark">±10 µg/m³</span></div>
                                            <div class="alert alert-success" :class="{'alert-danger': messages.pm2_5, 'alert-success': messages.pm2_5 == null}" role="alert">
                                                <h4 class="alert-heading">@{{aqiIndex.aqi_pm2_5.tag}}</h4>
                                                <p>@{{aqiIndex.aqi_pm2_5.message}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 d-flex">
                                    <div class="card">
                                        <div class="card-block">
                                            <h6 class="text-uppercase text-dark">Air Quality PM10 <i v-if="messages.pm10" class="mdi mdi-alert-circle-outline text-danger "></i></h6>
                                            <div class="h3 text-dark">@{{aqiData.pm10}} <span class="text-small text-dark">±10 µg/m³</span></div>
                                            <div class="alert alert-success" role="alert">
                                                <h4 class="alert-heading">@{{aqiIndex.aqi_pm10.tag}}</h4>
                                                <p>@{{aqiIndex.aqi_pm10.message}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-xl-3 col-lg-6">
                                    <div class="card">
                                        <div class="card-block">
                                            <h6 class="text-uppercase text-dark">Temperature <i v-if="messages.temperature" class="mdi mdi-alert-circle-outline text-danger "></i></h6>
                                            <div class="h3 text-dark">@{{aqiData.temperature}} <span class="text-small text-dark">±0.5°C</span></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-6">
                                    <div class="card">
                                        <div class="card-block">
                                            <h6 class="text-uppercase text-dark">Humidity <i v-if="messages.humidity" class="mdi mdi-alert-circle-outline text-danger "></i></h6>
                                            <div class="h3 text-dark">@{{aqiData.humidity}} <span class="text-small text-dark">±3%</span></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-6">
                                    <div class="card">
                                        <div class="card-block">
                                            <h6 class="text-uppercase text-dark">CO₂ <i v-if="messages.co2" class="mdi mdi-alert-circle-outline text-danger "></i></h6>
                                            <div class="h3 text-dark">@{{aqiData.co2}} <span class="text-small text-dark">±30 ppm</span></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-6">
                                    <div class="card">
                                        <div class="card-block">
                                            <h6 class="text-uppercase text-dark">TVOC <i v-if="messages.tvoc" class="mdi mdi-alert-circle-outline text-danger "></i></h6>
                                            <div class="h3 text-dark">@{{aqiData.tvoc}} <span class="text-small text-dark">±10 ppb</span></div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="alert alert-warning" role="alert" v-if="messages.humidity">
                                <i class="mdi mdi-alert-circle-outline "></i> High humidity levels detected. Consider using a dehumidifier.
                            </div>
                            <div class="alert alert-warning" role="alert" v-if="messages.co2">
                                High CO₂ levels detected. Ensure good ventilation.
                            </div>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="d-flex align-items-baseline">
                                                <p class="mb-0 mr-3">Subscribe to the realtime email notifications.</p>
                                                <button class="btn btn-dark" @click="showModal = true">Subscribe</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--row-->
                            <div class="row">
                                <div class="col-md-12 col-xs-12 align-self-center">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="h3 text-dark mb-3">Historical Trends</div>

                                            <ul class="row">
                                                <div class="col d-flex justify-content-center">
                                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                        <template v-for="(value, key) in aqiData">
                                                            <label class="btn btn-outline-secondary" :class="{ active: selectedChartItem === key }" :key="key">
                                                                <input type="radio" name="options" :id="key" :key="lastweek" v-model="selectedChartItem" @click="switchChart(keyLabels[key])">@{{ keyLabels[key].label }}</label>
                                                        </template>

                                                    </div>
                                                </div>
                                            </ul>
                                            <div class="row">
                                                <div class="col-lg">
                                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                        <label class="btn btn-outline-info" :class="{ active: selectedOption === '24hrs' }">
                                                            <input type="radio" name="options" id="24hrs" value="24hrs" v-model="selectedOption"> 24 hrs
                                                        </label>
                                                        <label class="btn btn-outline-info" :class="{ active: selectedOption === 'lastweek' }">
                                                            <input type="radio" name="options" id="lastweek" value="lastweek" v-model="selectedOption"> Last week
                                                        </label>
                                                        <!-- <label class="btn btn-outline-info" :class="{ active: selectedOption === 'lastmonth' }">
                                                        <input type="radio" name="options" id="lastmonth" value="lastmonth" v-model="selectedOption"> Last Month
                                                    </label> -->
                                                    </div>
                                                </div>
                                            </div>
                                            <line-chart-container :key="chartKey" :selected-option="selectedOption" :data-url="selectedItem.url" :title="selectedItem.label" :x-axis-label="selectedItem.xLabel" :y-axis-label="selectedItem.yLabel" :start-date="form.startDate" :end-date="form.endDate"></line-chart-container>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--/row-->

                            <hr>
                        </div>
                        <!--/main col-->
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
        </widget>
    </div>

    <!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>
    -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/vue@2"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/vue-toasted@2.1.2/dist/vue-toasted.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>
    <script src="{{mix('js/admin.js')}}" type="text/javascript"></script>
</body>

</html>