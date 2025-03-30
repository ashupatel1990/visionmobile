<div class="left-side-menu">

    <div class="h-100" data-simplebar>

        <!-- User box -->
        <div class="user-box text-center">
            <img src="../assets/images/users/user-1.jpg" alt="user-img" title="Mat Helme"
                class="rounded-circle avatar-md">
            <div class="dropdown">
                <a href="javascript: void(0);" class="text-dark dropdown-toggle h5 mt-2 mb-1 d-block"
                    data-toggle="dropdown">Geneva Kennedy</a>
                <div class="dropdown-menu user-pro-dropdown">

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-user mr-1"></i>
                        <span>My Account</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-settings mr-1"></i>
                        <span>Settings</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-lock mr-1"></i>
                        <span>Lock Screen</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-log-out mr-1"></i>
                        <span>Logout</span>
                    </a>

                </div>
            </div>
            <p class="text-muted">Admin Head</p>
        </div>

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <ul id="side-menu">
                <li>
                    <a href="{{route('dashboard')}}">
                        <i data-feather="airplay"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('allpurchases')}}" >
                        <i data-feather="shopping-cart"></i>
                        <span>Stocks</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="purchase">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{route('allpurchases')}}">All Stocks</a>
                            </li>
                            <li>
                                <a href="{{route('purchase.create')}}">Add Stock</a>
                            </li>
                            <li>
                                <a href="{{route('purchase.importform')}}">Import Stocks</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="#sales" data-toggle="collapse">
                        <i data-feather="briefcase"></i>
                        <span>Sell</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sales">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('allsales')}}">Sold Items</a>
                            </li>
                            <li>
                                <a href="{{ route('new-sale') }}">New Sale</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="{{ route('allinvoices')}}">
                        <i class="fa-file-invoice fa"></i>
                        <span>Invoice</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="invoice">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('allinvoices')}}">Manage Invoice</a>
                            </li>
                            <li>
                                <a href="{{ route('newinvoice') }}">New Invoice</a>
                            </li>
                        </ul>
                    </div>
                </li>
                @if (Auth::check() && Auth::user()->id == 4)
                <li>
                    <a href="{{ route('sale-report')}}" >
                        <i class="fa fa-chart-line"></i>
                        <span>Reports</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="reports">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('sale-report')}}">Sales</a>
                            </li>
                            <li>
                                <a href="{{ route('purchase-report') }}">Purchase</a>
                            </li>
                            <li>
                                <a href="{{ route('saleschart') }}">Chart</a>
                            </li>
                            <li>
                                <a href="{{ route('customers') }}">Customers</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="{{ route('expenses')}}">
                        <i class="fa-wallet fa"></i>
                        <span>Expense Tracker</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="expenses">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('expenses')}}">Expenses</a>
                            </li>
                            <li>
                                <a href="{{ route('add-expense') }}">Add Expense</a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endif
            </ul>

        </div>
        <!-- End Sidebar -->
        <div class="clearfix"></div>
    </div>
    <!-- Sidebar -left -->
</div>