<div class="navbar-custom">
    <div class="container-fluid">
        <ul class="list-unstyled topnav-menu float-right mb-0">

            {{--
            <li class="dropdown d-inline-block d-lg-none">
                <a class="nav-link dropdown-toggle arrow-none waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <i class="fe-search noti-icon"></i>
                </a>
                <div class="dropdown-menu dropdown-lg dropdown-menu-right p-0">
                    <form class="p-3">
                        <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
                    </form>
                </div>
            </li>
            --}}
            <!-- <li class="nav-link">
                <p style="color: #fff;"><b>Date:</b> {{ now()->format('d-m-Y') }} &nbsp;<b>Time:</b> <span id="currentTime"></span></p>
            </li>
            <script>
                function updateTime() {
                    const now = new Date();
                    const hours = String(now.getHours()).padStart(2, '0');
                    const minutes = String(now.getMinutes()).padStart(2, '0');
                    const seconds = String(now.getSeconds()).padStart(2, '0');
                    const currentTime = hours + ":" + minutes + ":" + seconds;
                    document.getElementById('currentTime').innerText = currentTime;
                }
                setInterval(updateTime, 1000);
            </script> -->

            <li class="dropdown d-none d-lg-inline-block">
                <a class="nav-link dropdown-toggle arrow-none waves-effect waves-light" data-toggle="fullscreen" href="#">
                    <i class="fe-maximize noti-icon"></i>
                </a>
            </li>

            <li class="dropdown notification-list topbar-dropdown">
                <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <img src="{{asset('admin/users/'. auth()->user()->profile_image)}}" alt="user-image" class="rounded-circle">
                    <span class="pro-user-name ml-1">
                    {{ ucfirst(auth()->user()->username) }} <i class="mdi mdi-chevron-down"></i> 
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                    <!-- item-->
                    <div class="dropdown-header noti-title">
                        <h6 class="text-overflow m-0">Welcome !</h6>
                    </div>

                    <!-- item-->
                    <a href="{{route('admin.profile')}}" class="dropdown-item notify-item">
                        <i class="fe-user"></i>
                        <span>My Profile</span>
                    </a>
                    <a href="{{route('admin.changepassword')}}" class="dropdown-item notify-item">
                        <i class="fe-user"></i>
                        <span>Change Password</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-lock"></i>
                        <span>Lock Screen</span>
                    </a>

                    <div class="dropdown-divider"></div>

                    <!-- item-->
                    <!-- <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-log-out"></i>
                        <span>Logout</span>
                    </a> -->

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <a href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();" class="dropdown-item notify-item">
                            <i class="fe-log-out"></i><span>{{ __('Log Out') }}</span>
                        </a>
                    </form>

                </div>
            </li>    
        </ul>

        <!-- LOGO -->
        <div class="logo-box">
            <a href="{{ route('dashboard')}}" class="logo logo-dark text-center">
                <span class="logo-sm">
                    <img src="{{asset('assets/images/visionlogo-wb.png')}}" alt="Vision Mobile" height="40">
                </span>
                <span class="logo-lg">
                    <img src="{{asset('assets/images/visionlogo-wb.png')}}" alt="Vision Mobile" height="20">
                </span>
            </a>

            <a href="{{ route('dashboard')}}" class="logo logo-light text-center">
                <span class="logo-sm">
                    <img src="../assets/images/logo-sm.png" alt="" height="22">
                </span>
                <span class="logo-lg">
                    <img src="{{asset('assets/images/vision_mobile.png')}}" alt="" height="50">
                </span>
            </a>
        </div>

        <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
            <li>
                <button class="button-menu-mobile waves-effect waves-light">
                    <i class="fe-menu"></i>
                </button>
            </li>

            <li>
                <!-- Mobile menu toggle (Horizontal Layout)-->
                <a class="navbar-toggle nav-link" data-toggle="collapse" data-target="#topnav-menu-content">
                    <div class="lines">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </a>
                <!-- End mobile menu toggle-->
            </li>

        </ul>
        <div class="clearfix"></div>
    </div>
</div>