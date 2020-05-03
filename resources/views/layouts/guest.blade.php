<div class="wrapper wrapper-full-page ">
    @include('inc.navs.guest')
    <div class="full-page register-page section-image" filter-color="black" data-image="{{ $backgroundImage }}">
        @yield('content')
        @include('inc.footer')
    </div>
</div>
