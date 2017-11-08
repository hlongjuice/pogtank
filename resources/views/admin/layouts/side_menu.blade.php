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
            {{--Materials--}}
            <li>
                <a href="javascript:;">
                    <i class="icon-puzzle"></i>
                    <span class="title">วัสดุอุปกรณ์</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a href="{{route('admin.materials.types.index')}}">
                            <i class="icon-anchor"></i>
                           หมวดหมู่วัสดุ/อุปกรณ์</a>
                    </li>
                    <li>
                        <a href="{{route('admin.materials.items.index')}}">
                            <i class="icon-book-open"></i>
                            วัสดุ/อุปกรณ์</a>
                    </li>

                    <li class="active">
                        <a href="layout_blank_page.html">
                            <i class="icon-paper-clip"></i>
                            Blank Page</a>
                    </li>
                    <li>
                        <a href="layout_ajax.html">
                            <i class="icon-bubble"></i>
                            Content Loading via Ajax</a>
                    </li>
                </ul>
            </li>
            <li >
                <a href="javascript:;">
                    <i class="icon-present"></i>
                    <span class="title">UI Features</span>
                    <span class="arrow "></span>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a href="ui_general.html">
                            General</a>
                    </li>
                    <li>
                        <a href="ui_buttons.html">
                            Buttons</a>
                    </li>
                    <li>
                        <a href="ui_icons.html">
                            Icons</a>
                    </li>
                    <li>
                        <a href="ui_typography.html">
                            Typography</a>
                    </li>
                    <li>
                        <a href="ui_modals.html">
                            Modals</a>
                    </li>
                    <li>
                        <a href="ui_extended_modals.html">
                            Extended Modals</a>
                    </li>
                    <li>
                        <a href="ui_tabs_accordions_navs.html">
                            Tabs, Accordions & Navs</a>
                    </li>
                    <li>
                        <a href="ui_toastr.html">
                            <span class="badge badge-warning">new</span>Toastr Notifications</a>
                    </li>
                    <li>
                        <a href="ui_datepaginator.html">
                            <span class="badge badge-success">new</span>Date Paginator</a>
                    </li>
                    <li>
                        <a href="ui_tree.html">
                            Tree View</a>
                    </li>
                    <li>
                        <a href="ui_nestable.html">
                            Nestable List</a>
                    </li>
                    <li>
                        <a href="ui_ion_sliders.html">
                            <span class="badge badge-important">new</span>Ion Range Sliders</a>
                    </li>
                    <li>
                        <a href="ui_jqueryui_sliders.html">
                            jQuery UI Sliders</a>
                    </li>
                    <li>
                        <a href="ui_knob.html">
                            Knob Circle Dials</a>
                    </li>
                </ul>
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