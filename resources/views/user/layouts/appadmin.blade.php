@include('user.layouts.sidebar')
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

        <div class="page-container">
@include('user.layouts.top')
            <div class="main-content">
            <div class="container-fluid " style="padding: 30px;">
                

@yield('content')

</div>
</div>


@include('user.layouts.footer')