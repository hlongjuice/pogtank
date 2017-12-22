<!-- BEGIN SIDEBAR -->
<div class="page-sidebar-wrapper">
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <ul class="page-sidebar-menu">
            <li class="sidebar-toggler-wrapper">
                <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                <div class="sidebar-toggler">
                </div>
                <div class="clearfix">
                </div>
                <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
            </li>
            <li class="sidebar-search-wrapper">
                <form class="search-form" role="form" action="index.html" method="get">
                    <div class="input-icon right">
                        <i class="fa fa-search"></i>
                        <input type="text" class="form-control input-sm" name="query" placeholder="Search...">
                    </div>
                </form>
            </li>
            {{--Dashboard--}}
            <li class="start active">
                <a href="index.html">
                    <i class="icon-home"></i>
                    <span class="title">Dashboard</span>
                </a>
            </li>
            {{--Material Types--}}
            <li>
                <a href="{{route('admin.materials.types.index')}}">
                    <i class="icon-anchor"></i>
                    หมวดหมู่วัสดุ/อุปกรณ์</a>
            </li>
            {{--Material Item--}}
            <li>
                <a href="{{route('admin.materials.items.index')}}">
                    <i class="icon-book-open"></i>
                    วัสดุ/อุปกรณ์</a>
            </li>
            <li class="last ">
                <a href="login.html">
                    <i class="icon-user"></i>
                    <span class="title">Login</span>
                </a>
            </li>
        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
</div>
<!-- END SIDEBAR -->