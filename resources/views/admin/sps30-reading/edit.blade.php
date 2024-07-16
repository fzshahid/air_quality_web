@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.sps30-reading.actions.edit', ['name' => $sps30Reading->id]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <sps30-reading-form
                :action="'{{ $sps30Reading->resource_url }}'"
                :data="{{ $sps30Reading->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.sps30-reading.actions.edit', ['name' => $sps30Reading->id]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.sps30-reading.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </sps30-reading-form>

        </div>
    
</div>

@endsection