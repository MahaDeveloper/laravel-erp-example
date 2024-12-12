@include('Client::layouts.head')

@if(empty($hideNavbar) || !$hideNavbar)
    @include('Client::layouts.head-nav')
@endif

@yield('content')
@include('Client::layouts.footer')
