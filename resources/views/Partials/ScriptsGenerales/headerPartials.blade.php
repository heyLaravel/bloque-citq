
<header class="header black-bg">
    <link href='{{ asset('assets/img/icon.ico') }}' rel='shortcut icon'>
    <div class="sidebar-toggle-box">
        <div style="color: #078006" class="fa fa-bars tooltips" data-placement="right" data-original-title="Activar Menú"></div>
    </div>

    <!--logo start-->
    <a href="#" class="logo"><img align="middle" style="width:80px;position:absolute;top:5%" src="{{ asset('assets/img/citq.png') }}"></a>
    <!--logo end-->

    <div class="nav notify-row" id="top_menu">
        <!--  notification start -->
        <ul class="nav top-menu">

        </ul>
        <!--  notification end -->
    </div>
    <div class="top-menu">
        <ul class="nav pull-right top-menu">
            <li><a class="logout" href="{{route('logout')}}">Logout</a></li>
        </ul>
    </div>

    <!-- FILE INPUT  -->

</header>

