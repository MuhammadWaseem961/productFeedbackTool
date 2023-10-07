<template>
    <div class="wrapper dashboard-wrapper">
        <div class="d-flex flex-wrap flex-xl-nowrap">
            <div class="db-sidebar bg-white">
                <nav class="navbar navbar-expand-xl navbar-light d-block px-0 header-sticky dashboard-nav py-0">
                    <div class="sticky-area shadow-xs-1 py-3">
                        <div class="d-flex px-3 px-xl-6 w-100">
                            <router-link to="/" class="navbar-brand" >
                                <img src="{{asset('assets/frontend/images/logo.png')}}" alt="HomeID">
                            </a>
                            <div class="ml-auto d-flex align-items-center ">
                                <div class="d-flex align-items-center d-xl-none">
                                    <div class="dropdown px-3">
                                        <a href="#" class="dropdown-toggle d-flex align-items-center text-heading"
                                            data-toggle="dropdown">
                                            <div class="w-48px">
                                                <img src="{{asset('assets/frontend/images/avatar.jpeg')}}" alt="Ronald Hunter"
                                                    class="rounded-circle">
                                            </div>
                                            <span class="fs-13 font-weight-500 d-none d-sm-inline ml-2">
                                            {{Auth::guard('user')->user()->name}}
                                            </span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <!--<a class="dropdown-item" href="#">My Profile</a>-->
                                            <a class="dropdown-item" type="button" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;"> @csrf <input type="hidden" name="targetUrl" value="/login"/> </form>
                                        </div>
                                    </div>
                                    <div class="dropdown no-caret py-4 px-3 d-flex align-items-center notice mr-3">
                                        <a href="#" class="dropdown-toggle text-heading fs-20 font-weight-500 lh-1"
                                            data-toggle="dropdown">
                                            <i class="far fa-bell"></i>
                                            <span class="badge badge-primary badge-circle badge-absolute font-weight-bold fs-13">1</span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                                <button class="navbar-toggler border-0 px-0" type="button" data-toggle="collapse"
                                    data-target="#primaryMenuSidebar" aria-controls="primaryMenuSidebar"
                                    aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="navbar-toggler-icon"></span>
                                </button>
                            </div>
                        </div>
                        <div class="collapse navbar-collapse bg-white" id="primaryMenuSidebar">
                            
                            <ul class="list-group list-group-flush w-100">
                                <li class="list-group-item pt-6 pb-4">
                                    <h5 class="fs-13 letter-spacing-087 text-muted mb-3 text-uppercase px-3">Main</h5>
                                    <ul class="list-group list-group-no-border rounded-lg">
                                        <li class="list-group-item px-3 px-xl-4 py-2 sidebar-item @if(Request::is('user/profile')) active @endif">
                                            <a href="{{route('get.account.detail')}}" class="text-heading  lh-1 sidebar-link">
                                                <span class="sidebar-item-icon d-inline-block mr-3 fs-20"><i
                                                        class="fal fa-user"></i></span>
                                                <span class="sidebar-item-text">Profile</span>
                                            </a>
                                        </li>

                                        <li class="list-group-item px-3 px-xl-4 py-2 sidebar-item @if(Request::is('user/dashboard')) active @endif">
                                            <a href="{{route('user.dashboard')}}" class="text-heading  lh-1 sidebar-link">
                                                <span class="sidebar-item-icon d-inline-block mr-3 fs-20"><i
                                                        class="fal fa-tachometer"></i></span>
                                                <span class="sidebar-item-text">Dashboard</span>
                                            </a>
                                        </li>

                                        <li class="list-group-item px-3 px-xl-4 py-2 sidebar-item @if(Request::is('user/sold/units')) active @endif">
                                            <a href="{{route('get.sold.units')}}" class="text-heading  lh-1 sidebar-link">
                                                <span class="sidebar-item-icon d-inline-block mr-3 fs-20"><i
                                                        class="fal fa-list"></i></span>
                                                <span class="sidebar-item-text">Sold Units</span>
                                            </a>
                                        </li>

                                        <li class="list-group-item px-3 px-xl-4 py-2 sidebar-item @if(Request::is('user/payments/history')) active @endif">
                                            <a href="{{route('get.payments.history')}}" class="text-heading  lh-1 sidebar-link">
                                                <span class="sidebar-item-icon d-inline-block mr-3 fs-20"><i
                                                        class="fal fa-credit-card"></i></span>
                                                <span class="sidebar-item-text">Payments History</span>
                                            </a>
                                        </li>

                                        <li class="list-group-item px-3 px-xl-4 py-2 sidebar-item @if(Request::is('user/inventory/stock')) active @endif">
                                            <a href="{{route('get.inventory.stock')}}" class="text-heading  lh-1 sidebar-link">
                                                <span class="sidebar-item-icon d-inline-block mr-3 fs-20"><i
                                                        class="fal fa-inventory"></i></span>
                                                <span class="sidebar-item-text">Inventory Stock</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="page-content">
                <header class="main-header shadow-none shadow-lg-xs-1 bg-white position-relative d-none d-xl-block">
                    <div class="container-fluid">
                        <nav class="navbar navbar-light py-0 row no-gutters px-3 px-lg-0">
                            <div class="col-md-4 px-0 px-md-6 order-1 order-md-0">
                                <!-- <form>
                                    <div class="input-group">
                                        <div class="input-group-prepend mr-0">
                                            <button class="btn border-0 shadow-none fs-20 text-muted p-0"
                                                type="submit"><i class="far fa-search"></i></button>
                                        </div>
                                        <input type="text" class="form-control border-0 bg-transparent shadow-none"
                                            placeholder="Search for..." name="search">
                                    </div>
                                </form> -->
                            </div>
                            <div class="col-md-6 d-flex flex-wrap justify-content-md-end order-0 order-md-1">
                                <div class="dropdown  border-0 py-3 text-right">
                                    <a href="#"
                                        class="dropdown-toggle text-heading pr-3 pr-sm-6 d-flex align-items-center justify-content-end"
                                        data-toggle="dropdown">
                                        <div class="mr-4 w-48px">
                                            <img src="{{asset('assets/frontend/images/avatar.jpeg')}}" alt="Ronald Hunter"
                                                class="rounded-circle">
                                        </div>
                                        <div class="fs-13 font-weight-500 lh-1">
                                            {{Auth::guard('user')->user()->name}}
                                        </div>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right w-100">
                                        <!--<a class="dropdown-item" href="dashboard-my-profiles.html">My Profile</a>-->
                                        <a class="dropdown-item" type="button" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                                        <form id="logout-form" action="{{ route('dashboard.logout') }}" method="POST" style="display: none;"> @csrf <input type="hidden" name="targetUrl" value="/dashboard/login"/></form>
                                    </div>
                                </div>
                            </div>
                        </nav>
                    </div>
                </header>
                <main id="content" class="bg-gray-01">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        
    }
</script>