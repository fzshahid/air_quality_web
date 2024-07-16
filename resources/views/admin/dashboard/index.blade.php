@extends('brackets/admin-ui::admin.layout.default')

@section('title', 'Admin Users')

@section('body')
{{-- <commit-chart></commit-chart> --}}
<dashboard v-cloak inline-template :action="''">
    <div>
        <div class="alert alert-danger" role="alert" v-if="messages.humidity">
            <i class="fa fa-warning "></i> High humidity levels detected. Consider using a dehumidifier.
        </div>
        <div class="alert alert-danger" role="alert" v-if="messages.co2">
            High CO₂ levels detected. Ensure good ventilation.
        </div>
        <div class="row mb-3">
            <div class="col-xl-6 col-md-6 col-lg-6 d-flex">
                <div class="card w-100">
                    <div class="card-block">
                        <h6 class="text-uppercase text-dark">Air Quality PM2.5 <i v-if="messages.pm2_5" class="fa fa-warning text-danger "></i></h6>
                        <!-- <div class="h3 text-dark">@{{aqiData.pm2_5}} <span class="text-small text-dark">±10 µg/m³</span></div> -->
                        <div class="row">
                            <div class="col-6 h4 text-dark">PM2.5: <span class="text-small text-dark">@{{aqiData.pm2_5}}±10 µg/m³</span></div>
                            <div class="col-6 h4 text-dark">AQI: <span class="text-small text-dark">@{{aqiIndex.aqi_pm2_5.aqi}}</span></div>
                        </div>
                        <div class="alert alert-primary" role="alert">
                            <h4 class="alert-heading">@{{aqiIndex.aqi_pm2_5.tag}}</h4>
                            <p>@{{aqiIndex.aqi_pm2_5.message}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-md-6 col-lg-6 d-flex">
                <div class="card w-100">
                    <div class="card-block">
                        <h6 class="text-uppercase text-dark">Air Quality PM10 <i v-if="messages.pm10" class="fa fa-warning text-danger "></i></h6>
                        <div class="row">
                            <div class="col-6 h4 text-dark">PM10: <span class="text-small text-dark">@{{aqiData.pm10}}±10 µg/m³</span></div>
                            <div class="col-6 h4 text-dark">AQI: <span class="text-small text-dark">@{{aqiIndex.aqi_pm10.aqi}}</span></div>
                        </div>
                        <div class="alert alert-primary" role="alert">
                            <h4 class="alert-heading">@{{aqiIndex.aqi_pm10.tag}}</h4>
                            <p>@{{aqiIndex.aqi_pm10.message}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="true" class="row mb-3">
            <div class="col-xl-3 col-lg-6">
                <div class="card">
                    <div class="card-block">
                        <h6 class="text-uppercase text-dark">Temperature <i v-if="messages.temperature" class="fa fa-warning text-danger "></i></h6>
                        <div class="h3 text-dark">@{{aqiData.temperature}} <span class="text-small text-dark">±0.5°C</span></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6">
                <div class="card">
                    <div class="card-block">
                        <h6 class="text-uppercase text-dark">Humidity <i v-if="messages.humidity" class="fa fa-warning text-danger "></i></h6>
                        <div class="h3 text-dark">@{{ aqiData.humidity }} <span class="text-small text-dark">±3%</span></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6">
                <div class="card">
                    <div class="card-block">
                        <h6 class="text-uppercase text-dark">CO₂ <i v-if="messages.co2" class="fa fa-warning text-danger "></i></h6>
                        <div class="h3 text-dark">@{{aqiData.co2}} <span class="text-small text-dark">±30 ppm</span></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6">
                <div class="card">
                    <div class="card-block">
                        <h6 class="text-uppercase text-dark">TVOC <i v-if="messages.tvoc" class="fa fa-warning text-danger "></i></h6>
                        <div class="h3 text-dark">@{{aqiData.tvoc}} <span class="text-small text-dark">±10 ppb</span></div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="col-lg mt-4 px-4 text-right">
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-light" :class="{ active: keyLabels.humidity.selectedOption === '24hrs' }">
                                <input type="radio" value="24hrs" v-model="keyLabels.humidity.selectedOption"> 24 hrs
                            </label>
                            <label class="btn btn-light" :class="{ active: keyLabels.humidity.selectedOption === 'lastweek' }">
                                <input type="radio" value="lastweek" v-model="keyLabels.humidity.selectedOption"> Last week
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="">
                            <line-chart-container :chart-config-option="keyLabels.humidity" :start-date="form.startDate" :end-date="form.endDate"></line-chart-container>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="col-lg mt-4 px-4 text-right">
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-light" :class="{ active: keyLabels.temperature.selectedOption === '24hrs' }">
                                <input type="radio" value="24hrs" v-model="keyLabels.temperature.selectedOption"> 24 hrs
                            </label>
                            <label class="btn btn-light" :class="{ active: keyLabels.temperature.selectedOption === 'lastweek' }">
                                <input type="radio" value="lastweek" v-model="keyLabels.temperature.selectedOption"> Last week
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="">
                            <line-chart-container :chart-config-option="keyLabels.temperature" :start-date="form.startDate" :end-date="form.endDate"></line-chart-container>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="col-lg mt-4 px-4 text-right">
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-light" :class="{ active: keyLabels.pm.selectedOption === '24hrs' }">
                                <input type="radio" value="24hrs" v-model="keyLabels.pm.selectedOption"> 24 hrs
                            </label>
                            <label class="btn btn-light" :class="{ active: keyLabels.pm.selectedOption === 'lastweek' }">
                                <input type="radio" value="lastweek" v-model="keyLabels.pm.selectedOption"> Last week
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="">
                            <line-chart-container :chart-config-option="keyLabels.pm" :start-date="form.startDate" :end-date="form.endDate"></line-chart-container>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="col-lg mt-4 px-4 text-right">
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-light" :class="{ active: keyLabels.tvoc.selectedOption === '24hrs' }">
                                <input type="radio" value="24hrs" v-model="keyLabels.tvoc.selectedOption"> 24 hrs
                            </label>
                            <label class="btn btn-light" :class="{ active: keyLabels.tvoc.selectedOption === 'lastweek' }">
                                <input type="radio" value="lastweek" v-model="keyLabels.tvoc.selectedOption"> Last week
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="">
                            <line-chart-container :chart-config-option="keyLabels.tvoc" :start-date="form.startDate" :end-date="form.endDate"></line-chart-container>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="col-lg mt-4 px-4 text-right">
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-light" :class="{ active: keyLabels.co2.selectedOption === '24hrs' }">
                                <input type="radio" value="24hrs" v-model="keyLabels.co2.selectedOption"> 24 hrs
                            </label>
                            <label class="btn btn-light" :class="{ active: keyLabels.co2.selectedOption === 'lastweek' }">
                                <input type="radio" value="lastweek" v-model="keyLabels.co2.selectedOption"> Last week
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="">
                            <line-chart-container :chart-config-option="keyLabels.co2" :start-date="form.startDate" :end-date="form.endDate"></line-chart-container>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</dashboard>
{{-- <bar-chart/> --}}
@endsection