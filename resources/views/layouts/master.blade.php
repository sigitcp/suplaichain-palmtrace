@include('layouts.header')
<body>
    @include('layouts.sidebar')
    <main class="main-content">
        @include('layouts.navbar')

        @yield('container')

        
    </main>
    @include('layouts.script')
</body>
</html>