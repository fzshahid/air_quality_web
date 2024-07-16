@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.air-quality-reading.actions.edit', ['name' => $airQualityReading->id]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <air-quality-reading-form
                :action="'{{ $airQualityReading->resource_url }}'"
                :data="{{ $airQualityReading->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.air-quality-reading.actions.edit', ['name' => $airQualityReading->id]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.air-quality-reading.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </air-quality-reading-form>

        </div>
    
</div>

@endsection