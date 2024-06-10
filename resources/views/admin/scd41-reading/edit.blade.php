@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.scd41-reading.actions.edit', ['name' => $scd41Reading->id]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <scd41-reading-form
                :action="'{{ $scd41Reading->resource_url }}'"
                :data="{{ $scd41Reading->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.scd41-reading.actions.edit', ['name' => $scd41Reading->id]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.scd41-reading.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </scd41-reading-form>

        </div>
    
</div>

@endsection