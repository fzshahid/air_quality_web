@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.ccs811-reading.actions.create'))

@section('body')

    <div class="container-xl">

                <div class="card">
        
        <ccs811-reading-form
            :action="'{{ url('admin/ccs811-readings') }}'"
            v-cloak
            inline-template>

            <form class="form-horizontal form-create" method="post" @submit.prevent="onSubmit" :action="action" novalidate>
                
                <div class="card-header">
                    <i class="fa fa-plus"></i> {{ trans('admin.ccs811-reading.actions.create') }}
                </div>

                <div class="card-body">
                    @include('admin.ccs811-reading.components.form-elements')
                </div>
                                
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" :disabled="submiting">
                        <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                        {{ trans('brackets/admin-ui::admin.btn.save') }}
                    </button>
                </div>
                
            </form>

        </ccs811-reading-form>

        </div>

        </div>

    
@endsection