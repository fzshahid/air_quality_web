<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-title">{{ trans('brackets/admin-ui::admin.sidebar.content') }}</li>
            <li class="nav-item"><a class="nav-link" href="{{ url('/dashboard') }}"><i class="nav-icon icon-chart"></i>Dashboard</a></li>
            <!-- <li class="nav-item"><a class="nav-link" href="{{ url('admin/air-quality-readings') }}"><i class="icon-book-open"></i> {{ trans('admin.air-quality-reading.title') }}</a></li> -->
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/ccs811-readings') }}"><i class="nav-icon icon-umbrella"></i>{{ trans('admin.ccs811-reading.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/scd41-readings') }}"><i class="nav-icon icon-check"></i> {{ trans('admin.scd41-reading.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/sps30-readings') }}"><i class="nav-icon icon-drop"></i> {{ trans('admin.sps30-reading.title') }}</a></li>
           {{-- Do not delete me :) I'm used for auto-generation menu items --}}

            <li class="nav-title">{{ trans('brackets/admin-ui::admin.sidebar.settings') }}</li> 
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/admin-users') }}"><i class="nav-icon icon-user"></i> Users</a></li>
            <!-- <li class="nav-item"><a class="nav-link" href="{{ url('admin/translations') }}"><i class="nav-icon icon-location-pin"></i> {{ __('Translations') }}</a></li> -->
            {{-- Do not delete me :) I'm also used for auto-generation menu items --}}
            {{--<li class="nav-item"><a class="nav-link" href="{{ url('admin/configuration') }}"><i class="nav-icon icon-settings"></i> {{ __('Configuration') }}</a></li>--}}
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
