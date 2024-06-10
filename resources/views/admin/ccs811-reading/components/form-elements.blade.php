<div class="form-group row align-items-center" :class="{'has-danger': errors.has('temperature'), 'has-success': fields.temperature && fields.temperature.valid }">
    <label for="temperature" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.ccs811-reading.columns.temperature') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.temperature" v-validate="'decimal'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('temperature'), 'form-control-success': fields.temperature && fields.temperature.valid}" id="temperature" name="temperature" placeholder="{{ trans('admin.ccs811-reading.columns.temperature') }}">
        <div v-if="errors.has('temperature')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('temperature') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('humidity'), 'has-success': fields.humidity && fields.humidity.valid }">
    <label for="humidity" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.ccs811-reading.columns.humidity') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.humidity" v-validate="'decimal'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('humidity'), 'form-control-success': fields.humidity && fields.humidity.valid}" id="humidity" name="humidity" placeholder="{{ trans('admin.ccs811-reading.columns.humidity') }}">
        <div v-if="errors.has('humidity')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('humidity') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('eco2'), 'has-success': fields.eco2 && fields.eco2.valid }">
    <label for="eco2" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.ccs811-reading.columns.eco2') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.eco2" v-validate="'decimal'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('eco2'), 'form-control-success': fields.eco2 && fields.eco2.valid}" id="eco2" name="eco2" placeholder="{{ trans('admin.ccs811-reading.columns.eco2') }}">
        <div v-if="errors.has('eco2')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('eco2') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('tvoc'), 'has-success': fields.tvoc && fields.tvoc.valid }">
    <label for="tvoc" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.ccs811-reading.columns.tvoc') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.tvoc" v-validate="'decimal'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('tvoc'), 'form-control-success': fields.tvoc && fields.tvoc.valid}" id="tvoc" name="tvoc" placeholder="{{ trans('admin.ccs811-reading.columns.tvoc') }}">
        <div v-if="errors.has('tvoc')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('tvoc') }}</div>
    </div>
</div>


