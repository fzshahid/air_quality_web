@extends('brackets/admin-ui::admin.layout.default')

@section('title', 'Admin Users')

@section('body')
{{-- <commit-chart></commit-chart> --}}
<dashboard v-cloak inline-template :action="''">
    <div>
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