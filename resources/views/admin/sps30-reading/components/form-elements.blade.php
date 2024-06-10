<div class="form-group row align-items-center" :class="{'has-danger': errors.has('pm1_0'), 'has-success': fields.pm1_0 && fields.pm1_0.valid }">
    <label for="pm1_0" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.sps30-reading.columns.pm1_0') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.pm1_0" v-validate="'decimal'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('pm1_0'), 'form-control-success': fields.pm1_0 && fields.pm1_0.valid}" id="pm1_0" name="pm1_0" placeholder="{{ trans('admin.sps30-reading.columns.pm1_0') }}">
        <div v-if="errors.has('pm1_0')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('pm1_0') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('pm2_5'), 'has-success': fields.pm2_5 && fields.pm2_5.valid }">
    <label for="pm2_5" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.sps30-reading.columns.pm2_5') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.pm2_5" v-validate="'decimal'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('pm2_5'), 'form-control-success': fields.pm2_5 && fields.pm2_5.valid}" id="pm2_5" name="pm2_5" placeholder="{{ trans('admin.sps30-reading.columns.pm2_5') }}">
        <div v-if="errors.has('pm2_5')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('pm2_5') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('pm4'), 'has-success': fields.pm4 && fields.pm4.valid }">
    <label for="pm4" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.sps30-reading.columns.pm4') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.pm4" v-validate="'decimal'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('pm4'), 'form-control-success': fields.pm4 && fields.pm4.valid}" id="pm4" name="pm4" placeholder="{{ trans('admin.sps30-reading.columns.pm4') }}">
        <div v-if="errors.has('pm4')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('pm4') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('pm10'), 'has-success': fields.pm10 && fields.pm10.valid }">
    <label for="pm10" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.sps30-reading.columns.pm10') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.pm10" v-validate="'decimal'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('pm10'), 'form-control-success': fields.pm10 && fields.pm10.valid}" id="pm10" name="pm10" placeholder="{{ trans('admin.sps30-reading.columns.pm10') }}">
        <div v-if="errors.has('pm10')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('pm10') }}</div>
    </div>
</div>


