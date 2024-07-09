@extends('brackets/admin-ui::admin.layout.default')

@section('title', 'Admin Users')

@section('body')
{{-- <commit-chart></commit-chart> --}}
<dashboard v-cloak inline-template :action="''">
    <div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group row align-items-center"
                    :class="{'has-danger': errors.has('start_date'), 'has-success': fields.start_date && fields.start_date.valid }">
                    <label for="start_date" class="col-form-label text-md-right"
                        :class="isFormLocalized ? 'col-md-4' : 'col-md-3'">Date</label>
                    <div :class="isFormLocalized ? 'col-md-4' : 'col-sm-8'">
                        <div class="input-group input-group--custom">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            <datetime v-model="form.startDate" :config="datePickerConfig" @change="reloadStats"
                                v-validate="'required_if:form.sponsored,true,1|date_format:yyyy-MM-dd'" class="flatpickr"
                                :class="{'form-control-danger': errors.has('start_date'), 'form-control-success': fields.start_date && fields.start_date.valid}"
                                id="start_date" name="start_date"
                                placeholder="{{ trans('brackets/admin-ui::admin.forms.select_a_date') }}"
                                data-vv-as="Start date"></datetime>
                        </div>
                        <div v-if="errors.has('start_date')" class="form-control-feedback form-text" v-cloak>
                            @{{ errors.first('start_date') }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <!-- <line-chart-container :data-url="'{{ url('dashboard/line-chart-pm') }}'" :title="'PM2.5 and AQI'" :start-date="form.startDate" :end-date="form.endDate"></line-chart-container> -->
                </div>
            </div>
            <div class="col-sm-12">
                <div class="card">
                    <line-chart-container :data-url="'{{ url('dashboard/temperature-line-chart') }}'" :title="'Temperature'" :start-date="form.startDate" :end-date="form.endDate"></line-chart-container>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="card">
                    <line-chart-container :data-url="'{{ url('dashboard/line-chart-co-2') }}'" :title="'Co2 Level'" :start-date="form.startDate" :end-date="form.endDate"></line-chart-container>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <new-users-chart :data-url="'{{ url('dashboard/temperature-line-chart') }}'" :start-date="form.startDate" :end-date="form.endDate"></new-users-chart>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <!-- <bar-chart-container :data-url="'{{ url('dashboard/active-users') }}'" :start-date="form.startDate" :end-date="form.endDate"></bar-chart-container> -->
                </div>
            </div>
        </div>
    </div>
</dashboard>
{{-- <bar-chart/> --}}
@endsection