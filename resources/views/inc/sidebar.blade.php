<?php
$x = Auth::user()->getAllPermissions()->pluck('name');
$modules = [];

foreach($x as $key => $val)
{
  $j = (explode(".", $val))[0];
  if(!in_array($j, $modules))
    $modules[] = $j;
}
// dd($modules);
?>
<div class="sidebar" data-color="orange">
    <!--
    Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
-->
    <div class="logo">
        <a href="{{config('app.url')}}" class="simple-text logo-mini">
            <i class="fab fa-laravel"></i>
        </a>
        <a href="{{config('app.url')}}" class="simple-text logo-normal">
            {{config('app.name')}}
        </a>
    </div>
    <div class="sidebar-wrapper" id="sidebar-wrapper">
        <ul class="nav">
            <li class="@if ($activePage == 'dashboard') active @endif">
                <a href="/dashboard">
                    <i class="fas fa-tachometer-alt"></i>
                    <p>{{ __('Dashboard') }}</p>
                </a>
            </li>
            @if (in_array('user', $modules))
            <li class="@if ($activePage == 'user') active @endif">
              <a href="{{ route('user.index') }}">
                <i class="fas fa-users-cog"></i>
                <p> {{ __("User Management") }} </p>
              </a>
            </li>
            @endif

            {{-- <li>
                <a data-toggle="collapse" href="#laravelExamples">
                    <i class="fab fa-laravel"></i>
                    <p>
                        {{ __("Laravel Examples") }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse show" id="laravelExamples">
                    <ul class="nav">
                        <li class="@if ($activePage == 'profile') active @endif">
                            <a href="{{ route('profile.edit') }}">
                                <i class="now-ui-icons users_single-02"></i>
                                <p> {{ __("User Profile") }} </p>
                            </a>
                        </li>
                        <li class="@if ($activePage == 'users') active @endif">
                            <a href="{{ route('user.index') }}">
                                <i class="now-ui-icons design_bullet-list-67"></i>
                                <p> {{ __("User Management") }} </p>
                            </a>
                        </li>
                    </ul>
                </div>
            <li class="@if ($activePage == 'icons') active @endif">
                <a href="{{ route('page.index','icons') }}">
                    <i class="now-ui-icons education_atom"></i>
                    <p>{{ __('Icons') }}</p>
                </a>
            </li>
            <li class="@if ($activePage == 'maps') active @endif">
                <a href="{{ route('page.index','maps') }}">
                    <i class="now-ui-icons location_map-big"></i>
                    <p>{{ __('Maps') }}</p>
                </a>
            </li>
            <li class=" @if ($activePage == 'notifications') active @endif">
                <a href="{{ route('page.index','notifications') }}">
                    <i class="now-ui-icons ui-1_bell-53"></i>
                    <p>{{ __('Notifications') }}</p>
                </a>
            </li>
            <li class=" @if ($activePage == 'table') active @endif">
                <a href="{{ route('page.index','table') }}">
                    <i class="now-ui-icons design_bullet-list-67"></i>
                    <p>{{ __('Table List') }}</p>
                </a>
            </li>
            <li class="@if ($activePage == 'typography') active @endif">
                <a href="{{ route('page.index','typography') }}">
                    <i class="now-ui-icons text_caps-small"></i>
                    <p>{{ __('Typography') }}</p>
                </a>
            </li>
            <li class="@if ($activePage == 'upgrade') active @endif active-pro">
                <a href="{{ route('page.index','upgrade') }}" class="color-ev">
                    <i class="now-ui-icons arrows-1_cloud-download-93"></i>
                    <p>{{ __('Upgrade to PRO') }}</p>
                </a>
            </li> --}}
        </ul>
    </div>
</div>
