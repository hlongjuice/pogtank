<!DOCTYPE html>
<!--
Template Name: Conquer - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.2.0
Version: 2.0
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/conquer-responsive-admin-dashboard-template/3716838?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8"/>
    <title>Conquer | Page Layouts - Blank Page</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <meta name="MobileOptimized" content="320">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

{{--Start Css--}}
<!-- BEGIN GLOBAL MANDATORY STYLES -->
    {{--<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>--}}
    <link href="{{asset('templates/admin/conquer/theme/assets/plugins/font-awesome/css/font-awesome.min.css')}} "
          rel="stylesheet" type="text/css"/>
    <link href="{{asset('templates/admin/conquer/theme/assets/plugins/simple-line-icons/simple-line-icons.min.css')}} "
          rel="stylesheet" type="text/css"/>
    <link href="{{asset('templates/admin/conquer/theme/assets/plugins/bootstrap/css/bootstrap.min.css')}} "
          rel="stylesheet" type="text/css"/>
    <link href="{{asset('templates/admin/conquer/theme/assets/plugins/uniform/css/uniform.default.css')}} "
          rel="stylesheet" type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->
    {{--<link rel="stylesheet" type="text/css"--}}
          {{--href="{{asset('templates/admin/conquer/theme/assets/plugins/select2/select2.css')}}"/>--}}
    <link rel="stylesheet" type="text/css"
          href="{{asset('templates/admin/conquer/theme/assets/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css')}}"/>
    <!-- END PAGE LEVEL STYLES -->
    <!-- BEGIN THEME STYLES -->
    <link href="{{asset('templates/admin/conquer/theme/assets/css/style-conquer.css')}} " rel="stylesheet"
          type="text/css"/>
    <link href="{{asset('templates/admin/conquer/theme/assets/css/style.css')}} " rel="stylesheet" type="text/css"/>
    <link href="{{asset('templates/admin/conquer/theme/assets/css/style-responsive.css')}} " rel="stylesheet"
          type="text/css"/>
    <link href="{{asset('templates/admin/conquer/theme/assets/css/plugins.css')}} " rel="stylesheet" type="text/css"/>
    <link href="{{asset('templates/admin/conquer/theme/assets/css/themes/default.css')}} " rel="stylesheet"
          type="text/css" id="style_color"/>
    <link href="{{asset('templates/admin/conquer/theme/assets/css/custom.css')}} " rel="stylesheet" type="text/css"/>
    <!-- END THEME STYLES -->
    <link rel="shortcut icon" href="{{asset('favicon.ico')}}"/>
    <link rel="stylesheet"
          href="{{asset('templates/admin/conquer/theme/assets/plugins/bootstrap-toastr/toastr.min.css')}}">
    {{--Extend Css--}}
    @yield('css')
    <link href="{{asset('css/app.css')}}" rel="stylesheet"/>
    <link href="{{asset('css/custom_spinner.css')}}" rel="stylesheet"/>
    {{--Font Awesome--}}
    <link rel="stylesheet" href="{{asset('css/font-awesome/css/fontawesome-all.min.css')}}">
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="page-header-fixed">
<!-- BEGIN HEADER -->
<div class="header navbar  navbar-fixed-top">
    <!-- BEGIN TOP NAVIGATION BAR -->
    <div class="header-inner">
        <!-- BEGIN LOGO -->
        {{--<div class="page-logo">--}}
            {{--<a href="index.html">--}}
                {{--<img src="{{asset('templates/admin/conquer/theme/assets/img/logo.png')}}" alt="logo"/>--}}
               {{----}}
            {{--</a>--}}

        {{--</div>--}}
        <div class="col-xs-5">
            <h4 class="text-light">Dashboard</h4>
        </div>
        {{--<form class="search-form search-form-header" role="form" action="index.html">--}}
            {{--<div class="input-icon right">--}}
                {{--<i class="icon-magnifier"></i>--}}
                {{--<input type="text" class="form-control input-sm" name="query" placeholder="Search...">--}}
            {{--</div>--}}
        {{--</form>--}}
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <img src="{{asset('templates/admin/conquer/theme/assets/img/menu-toggler.png')}}" alt=""/>
        </a>
        <!-- END RESPONSIVE MENU TOGGLER -->
        <!-- BEGIN TOP NAVIGATION MENU -->
        <ul class="nav navbar-nav pull-right">
            <!-- BEGIN NOTIFICATION DROPDOWN -->
            <li class="dropdown" id="header_notification_bar">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                   data-close-others="true">
                    <i class="icon-bell"></i>
                    <span class="badge badge-success">
				6 </span>
                </a>
                <ul class="dropdown-menu extended notification">
                    <li>
                        <p>
                            You have 14 new notifications
                        </p>
                    </li>
                    <li>
                        <ul class="dropdown-menu-list scroller" style="height: 250px;">
                            <li>
                                <a href="#">
								<span class="label label-sm label-icon label-success">
								<i class="fa fa-plus"></i>
								</span>
                                    New user registered. <span class="time">
								Just now </span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
								<span class="label label-sm label-icon label-danger">
								<i class="fa fa-bolt"></i>
								</span>
                                    Server #12 overloaded. <span class="time">
								15 mins </span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
								<span class="label label-sm label-icon label-warning">
								<i class="fa fa-bell"></i>
								</span>
                                    Server #2 not responding. <span class="time">
								22 mins </span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
								<span class="label label-sm label-icon label-info">
								<i class="fa fa-bullhorn"></i>
								</span>
                                    Application error. <span class="time">
								40 mins </span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
								<span class="label label-sm label-icon label-danger">
								<i class="fa fa-bolt"></i>
								</span>
                                    Database overloaded 68%. <span class="time">
								2 hrs </span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
								<span class="label label-sm label-icon label-danger">
								<i class="fa fa-bolt"></i>
								</span>
                                    2 user IP blocked. <span class="time">
								5 hrs </span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
								<span class="label label-sm label-icon label-warning">
								<i class="fa fa-bell"></i>
								</span>
                                    Storage Server #4 not responding. <span class="time">
								45 mins </span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
								<span class="label label-sm label-icon label-info">
								<i class="fa fa-bullhorn"></i>
								</span>
                                    System Error. <span class="time">
								55 mins </span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
								<span class="label label-sm label-icon label-danger">
								<i class="fa fa-bolt"></i>
								</span>
                                    Database overloaded 68%. <span class="time">
								2 hrs </span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="external">
                        <a href="#">See all notifications <i class="fa fa-angle-right"></i></a>
                    </li>
                </ul>
            </li>
            <!-- END NOTIFICATION DROPDOWN -->
            <!-- BEGIN INBOX DROPDOWN -->
            <li class="dropdown" id="header_inbox_bar">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                   data-close-others="true">
                    <i class="icon-envelope-open"></i>
                    <span class="badge badge-info">
				5 </span>
                </a>
                <ul class="dropdown-menu extended inbox">
                    <li>
                        <p>
                            You have 12 new messages
                        </p>
                    </li>
                    <li>
                        <ul class="dropdown-menu-list scroller" style="height: 250px;">
                            <li>
                                <a href="inbox.html?a=view">
								<span class="photo">
								<img src="{{asset('templates/admin/conquer/theme/assets/img/avatar2.jpg')}}" alt=""/>
								</span>
                                    <span class="subject">
								<span class="from">
								Lisa Wong </span>
								<span class="time">
								Just Now </span>
								</span>
                                    <span class="message">
								Vivamus sed auctor nibh congue nibh. auctor nibh auctor nibh... </span>
                                </a>
                            </li>
                            <li>
                                <a href="inbox.html?a=view">
								<span class="photo">
								<img src="{{asset('templates/admin/conquer/theme/assets/img/avatar3.jpg')}}" alt=""/>
								</span>
                                    <span class="subject">
								<span class="from">
								Richard Doe </span>
								<span class="time">
								16 mins </span>
								</span>
                                    <span class="message">
								Vivamus sed congue nibh auctor nibh congue nibh. auctor nibh auctor nibh... </span>
                                </a>
                            </li>
                            <li>
                                <a href="inbox.html?a=view">
								<span class="photo">
								<img src="{{asset('templates/admin/conquer/theme/assets/img/avatar1.jpg')}}" alt=""/>
								</span>
                                    <span class="subject">
								<span class="from">
								Bob Nilson </span>
								<span class="time">
								2 hrs </span>
								</span>
                                    <span class="message">
								Vivamus sed nibh auctor nibh congue nibh. auctor nibh auctor nibh... </span>
                                </a>
                            </li>
                            <li>
                                <a href="inbox.html?a=view">
								<span class="photo">
								<img src="{{asset('templates/admin/conquer/theme/assets/img/avatar2.jpg')}}" alt=""/>
								</span>
                                    <span class="subject">
								<span class="from">
								Lisa Wong </span>
								<span class="time">
								40 mins </span>
								</span>
                                    <span class="message">
								Vivamus sed auctor 40% nibh congue nibh... </span>
                                </a>
                            </li>
                            <li>
                                <a href="inbox.html?a=view">
								<span class="photo">
								<img src="{{asset('templates/admin/conquer/theme/assets/img/avatar3.jpg')}}" alt=""/>
								</span>
                                    <span class="subject">
								<span class="from">
								Richard Doe </span>
								<span class="time">
								46 mins </span>
								</span>
                                    <span class="message">
								Vivamus sed congue nibh auctor nibh congue nibh. auctor nibh auctor nibh... </span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="external">
                        <a href="inbox.html">See all messages <i class="fa fa-angle-right"></i></a>
                    </li>
                </ul>
            </li>
            <!-- END INBOX DROPDOWN -->
            <!-- BEGIN TODO DROPDOWN -->
            <li class="dropdown" id="header_task_bar">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                   data-close-others="true">
                    <i class="icon-calendar"></i>
                    <span class="badge badge-warning">
				5 </span>
                </a>
                <ul class="dropdown-menu extended tasks">
                    <li>
                        <p>
                            You have 12 pending tasks
                        </p>
                    </li>
                    <li>
                        <ul class="dropdown-menu-list scroller" style="height: 250px;">
                            <li>
                                <a href="#">
								<span class="task">
								<span class="desc">
								New release v1.2 </span>
								<span class="percent">
								30% </span>
								</span>
                                    <span class="progress">
								<span style="width: 40%;" class="progress-bar progress-bar-success" aria-valuenow="40"
                                      aria-valuemin="0" aria-valuemax="100">
								<span class="sr-only">
								40% Complete </span>
								</span>
								</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
								<span class="task">
								<span class="desc">
								Application deployment </span>
								<span class="percent">
								65% </span>
								</span>
                                    <span class="progress progress-striped">
								<span style="width: 65%;" class="progress-bar progress-bar-danger" aria-valuenow="65"
                                      aria-valuemin="0" aria-valuemax="100">
								<span class="sr-only">
								65% Complete </span>
								</span>
								</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
								<span class="task">
								<span class="desc">
								Mobile app release </span>
								<span class="percent">
								98% </span>
								</span>
                                    <span class="progress">
								<span style="width: 98%;" class="progress-bar progress-bar-success" aria-valuenow="98"
                                      aria-valuemin="0" aria-valuemax="100">
								<span class="sr-only">
								98% Complete </span>
								</span>
								</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
								<span class="task">
								<span class="desc">
								Database migration </span>
								<span class="percent">
								10% </span>
								</span>
                                    <span class="progress progress-striped">
								<span style="width: 10%;" class="progress-bar progress-bar-warning" aria-valuenow="10"
                                      aria-valuemin="0" aria-valuemax="100">
								<span class="sr-only">
								10% Complete </span>
								</span>
								</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
								<span class="task">
								<span class="desc">
								Web server upgrade </span>
								<span class="percent">
								58% </span>
								</span>
                                    <span class="progress progress-striped">
								<span style="width: 58%;" class="progress-bar progress-bar-info" aria-valuenow="58"
                                      aria-valuemin="0" aria-valuemax="100">
								<span class="sr-only">
								58% Complete </span>
								</span>
								</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
								<span class="task">
								<span class="desc">
								Mobile development </span>
								<span class="percent">
								85% </span>
								</span>
                                    <span class="progress progress-striped">
								<span style="width: 85%;" class="progress-bar progress-bar-success" aria-valuenow="85"
                                      aria-valuemin="0" aria-valuemax="100">
								<span class="sr-only">
								85% Complete </span>
								</span>
								</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
								<span class="task">
								<span class="desc">
								New UI release </span>
								<span class="percent">
								18% </span>
								</span>
                                    <span class="progress progress-striped">
								<span style="width: 18%;" class="progress-bar progress-bar-important" aria-valuenow="18"
                                      aria-valuemin="0" aria-valuemax="100">
								<span class="sr-only">
								18% Complete </span>
								</span>
								</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="external">
                        <a href="#">See all tasks <i class="fa fa-angle-right"></i></a>
                    </li>
                </ul>
            </li>
            <!-- END TODO DROPDOWN -->
            <li class="devider">
                &nbsp;
            </li>
            <!-- BEGIN USER LOGIN DROPDOWN -->
            <li class="dropdown user">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                   data-close-others="true">
                    <img alt="" src="{{asset('templates/admin/conquer/theme/assets/img/avatar3_small.jpg')}}"/>
                    <span class="username">
                        {{Auth::user()->username}}
				 </span>
                    <i class="fa fa-angle-down"></i>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="extra_profile.html"><i class="fa fa-user"></i> My Profile</a>
                    </li>
                    <li>
                        <a href="page_calendar.html"><i class="fa fa-calendar"></i> My Calendar</a>
                    </li>
                    <li>
                        <a href="page_inbox.html"><i class="fa fa-envelope"></i> My Inbox <span
                                    class="badge badge-danger">
						3 </span>
                        </a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-tasks"></i> My Tasks <span class="badge badge-success">
						7 </span>
                        </a>
                    </li>
                    <li class="divider">
                    </li>
                    <li>
                        <a
                           onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();"
                        >
                            Logout</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                    {{--<form method="POST" action="{{route('logout')}}">--}}
                        {{--<li>--}}
                            {{--{{csrf_field()}}--}}
                            {{--<button class="btn btn-navbar" type="submit"><i class="fa fa-key"></i> Log Out</button>--}}
                        {{--</li>--}}
                    {{--</form>--}}

                </ul>
            </li>
            <!-- END USER LOGIN DROPDOWN -->
        </ul>
        <!-- END TOP NAVIGATION MENU -->
    </div>
    <!-- END TOP NAVIGATION BAR -->
</div>
<!-- END HEADER -->
<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
@include('admin.layouts.side_menu')
<!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">
            <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
            <div class="modal fade" id="portlet-config" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">Modal title</h4>
                        </div>
                        <div class="modal-body">
                            Widget settings form goes here
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success">Save changes</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
            <!-- BEGIN PAGE HEADER-->
            {{--<h3 class="page-title">--}}
            {{--Blank Page--}}
            {{--<small>blank page</small>--}}
            {{--</h3>--}}
            <div class="page-bar">
                {{--Bread Crumb--}}
                @yield('breadcrumb')
            </div>
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
            <div id="start-app" class="row">
                <div class="col-md-12">
                    @yield('content')
                </div>
            </div>
            {{--Start Vue Component--}}
            <div id="my-root-vue" class="row">
                <div class="col-xs-12">
                    <router-view></router-view>
                </div>
            </div>
            <!-- END PAGE CONTENT-->
        </div>
    </div>
    <!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<div class="footer">
    <div class="footer-inner">
        {{--2013 &copy; Conquer by keenthemes.--}}
    </div>
    <div class="footer-tools">
		<span class="go-top">
		<i class="fa fa-angle-up"></i>
		</span>
    </div>
</div>
<!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<script src="{{asset('templates/admin/conquer/theme/assets/plugins/jquery-1.11.0.min.js')}}"
        type="text/javascript"></script>
<script src="{{asset('templates/admin/conquer/theme/assets/plugins/jquery-migrate-1.2.1.min.js')}}"
        type="text/javascript"></script>

<!-- Build in Scripts -->
{{--Main Script--}}
<script src="{{ asset('js/app.js') }}"></script>
<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="{{asset('templates/admin/conquer/theme/assets/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js')}}"
        type="text/javascript"></script>
<script src="{{asset('templates/admin/conquer/theme/assets/plugins/bootstrap/js/bootstrap.min.js')}}"
        type="text/javascript"></script>
<script src="{{asset('templates/admin/conquer/theme/assets/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js')}}"
        type="text/javascript"></script>
<script src="{{asset('templates/admin/conquer/theme/assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js')}}"
        type="text/javascript"></script>
<script src="{{asset('templates/admin/conquer/theme/assets/plugins/jquery.blockui.min.js')}}"
        type="text/javascript"></script>
<script src="{{asset('templates/admin/conquer/theme/assets/plugins/uniform/jquery.uniform.min.js')}}"
        type="text/javascript"></script>

<!-- BEGIN PAGE LEVEL PLUGINS -->
{{--<script type="text/javascript"--}}
        {{--src="{{asset('templates/admin/conquer/theme/assets/plugins/ckeditor/ckeditor.js')}}"></script>--}}
{{--<script type="text/javascript"--}}
        {{--src="{{asset('templates/admin/conquer/theme/assets/plugins/select2/select2.min.js')}}"></script>--}}
<script type="text/javascript"
        src="{{asset('templates/admin/conquer/theme/assets/plugins/datatables/media/js/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript"
        src="{{asset('templates/admin/conquer/theme/assets/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js')}}"></script>
<!-- END CORE PLUGINS -->
<script src="{{asset('templates/admin/conquer/theme/assets/scripts/app.js')}}"></script>
<script src="{{asset('templates/admin/conquer/theme/assets/scripts/table-editable.js')}}"></script>
{{--<script src="{{asset('templates/admin/conquer/theme/assets/scripts/form-samples.js')}}"></script>--}}
<script src="{{asset('templates/admin/conquer/theme/assets/plugins/bootstrap-toastr/toastr.min.js')}}"></script>





{{--All Vue Js--}}
{{--<script src="{{asset('views/admin/js/app.js')}}"></script>--}}


<script>
    jQuery(document).ready(function () {
        App.init();
//        TableEditable.init();
//         FormSamples.init();
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-top-center",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
    });
</script>
@yield('script')
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>