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
    <link rel="stylesheet" type="text/css"
          href="{{asset('templates/admin/conquer/theme/assets/plugins/select2/select2.css')}}"/>
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
    <link href="{{asset('templates/admin/conquer/theme/assets/css/pages/login.css')}}" rel="stylesheet"
          type="text/css"/>
    {{--Font Awesome--}}
    <link rel="stylesheet" href="{{asset('css/font-awesome/css/fontawesome-all.min.css')}}">
</head>
{{--<!-- END HEAD -->--}}
{{--<!-- BEGIN BODY -->--}}
<body class="login">
<!-- BEGIN LOGO -->
<div class="logo">
    <a href="index.html">
        <img src="assets/img/logo.png" alt=""/>
    </a>
</div>
<!-- END LOGO -->
<!-- BEGIN LOGIN -->
<div class="content">
    <!-- BEGIN LOGIN FORM -->
    <form class="login-form" action="{{url('login')}}" method="post">
        {{csrf_field()}}
        <h3 class="form-title">Login to your account</h3>
        <div class="alert alert-danger display-hide">
            <button class="close" data-close="alert"></button>
            <span>
			Enter any username and password. </span>
        </div>
        <div class="form-group">
            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
            <label class="control-label visible-ie8 visible-ie9">Username</label>
            <div class="input-icon">
                <i class="fa fa-user"></i>
                <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Username"
                       name="username"/>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Password</label>
            <div class="input-icon">
                <i class="fa fa-lock"></i>
                <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Password"
                       name="password"/>
            </div>
        </div>
        <div class="form-actions">
            <label class="checkbox">
                <input type="checkbox" name="remember" value="1"/> Remember me </label>
            <button type="submit" class="btn btn-info pull-right">
                Login
            </button>
        </div>
        <div class="forget-password">
            <h4>Forgot your password ?</h4>
            <p>
                no worries, click <a href="javascript:;" id="forget-password">here</a>
                to reset your password.
            </p>
        </div>
        <div class="create-account">
            <p class="text-right">
                <a href="javascript:;" id="register-btn">สมัครสมาชิกใหม่</a>
            </p>
        </div>
    </form>
    <!-- END LOGIN FORM -->
    <!-- BEGIN FORGOT PASSWORD FORM -->
    <form class="forget-form" action="index.html" method="post">
        <h3>Forget Password ?</h3>
        <p>
            Enter your e-mail address below to reset your password.
        </p>
        <div class="form-group">
            <div class="input-icon">
                <i class="fa fa-envelope"></i>
                <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email"
                       name="email"/>
            </div>
        </div>
        <div class="form-actions">
            <button type="button" id="back-btn" class="btn btn-default">
                <i class="m-icon-swapleft"></i> Back
            </button>
            <button type="submit" class="btn btn-info pull-right">
                Submit
            </button>
        </div>
    </form>
    <!-- END FORGOT PASSWORD FORM -->
    <!-- BEGIN REGISTRATION FORM -->
    <form class="register-form" action="{{route('register_admin.store')}}" method="post">
        {{csrf_field()}}
        <h3>
            สมัครสมาชิก
        </h3>
        <div class="line line-gray"></div>
        {{-- -- Username--}}
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Username</label>
            <div class="input-icon">
                <i class="fa fa-user"></i>
                <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Username"
                       name="username"/>
            </div>
        </div>
        {{--  -- Role--}}
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">หน้าที่</label>
            <select name="role" id="role" class="form-control">
                @foreach($roles as $role)
                    <option value="{{$role->id}}">{{$role->name}}</option>
                    @endforeach
            </select>
        </div>
        {{-- -- Password--}}
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Password</label>
            <div class="input-icon">
                <i class="fa fa-lock"></i>
                <input class="form-control placeholder-no-fix" type="password" autocomplete="off" id="register_password"
                       placeholder="Password" name="password"/>
            </div>
        </div>
        {{-- -- Confirm Password--}}
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Confirm Password</label>
            <div class="controls">
                <div class="input-icon">
                    <i class="fa fa-check"></i>
                    <input class="form-control placeholder-no-fix" type="password" autocomplete="off"
                           placeholder="Re-type Your Password" id="password_confirmation" name="password_confirmation"/>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <button id="register-back-btn" type="button" class="btn btn-default">
                <i class="m-icon-swapleft"></i> Back
            </button>
            <button type="submit" id="register-submit-btn" class="btn btn-info pull-right">
                Sign Up <i class="m-icon-swapright m-icon-white"></i>
            </button>
        </div>
    </form>
    <!-- END REGISTRATION FORM -->
</div>
<!-- END LOGIN -->
<!-- BEGIN COPYRIGHT -->
<div class="copyright">
    2018 &copy; POGTANK. Admin Dashboard Template.
</div>

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

{{--<!-- BEGIN PAGE LEVEL PLUGINS -->--}}
<script type="text/javascript"
        src="{{asset('templates/admin/conquer/theme/assets/plugins/ckeditor/ckeditor.js')}}"></script>
<script type="text/javascript"
        src="{{asset('templates/admin/conquer/theme/assets/plugins/select2/select2.min.js')}}"></script>
<script type="text/javascript"
        src="{{asset('templates/admin/conquer/theme/assets/plugins/datatables/media/js/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript"
        src="{{asset('templates/admin/conquer/theme/assets/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js')}}"></script>
<!-- END CORE PLUGINS -->
<script src="{{asset('templates/admin/conquer/theme/assets/scripts/table-editable.js')}}"></script>
<script src="{{asset('templates/admin/conquer/theme/assets/scripts/form-samples.js')}}"></script>
<script src="{{asset('templates/admin/conquer/theme/assets/plugins/bootstrap-toastr/toastr.min.js')}}"></script>

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{asset('templates/admin/conquer/theme/assets/plugins/jquery-validation/js/jquery.validate.min.js')}}"
        type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{asset('templates/admin/conquer/theme/assets/scripts/app.js')}}"></script>
<script src="{{asset('templates/admin/conquer/theme/assets/scripts/login.js')}}"></script>
<script src="{{asset('templates/admin/conquer/theme/assets/scripts/custom.js')}}"></script>
<!-- END PAGE LEVEL SCRIPTS -->

<script>
    jQuery(document).ready(function () {
        $('.register-form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            rules: {
                username:{
                    required:true
                },
                password: {
                    required: true,
                    minlength:4
                },
                password_confirmation: {
                    equalTo: "#register_password"
                }
            },
            messages: { // custom messages for radio buttons and checkboxes
                password:{
                    minlength:"ต้องการอย่างน้อย 4 หลัก",
                },
                password_confirmation: {
                    equalTo: "รหัสผ่านไม่ตรงกัน"
                }
            },
            highlight: function (element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            }
        });
        App.init();
        Login.init();
        var action = location.hash.substr(1);
        if (action == 'createaccount') {
            $('.register-form').show();
            $('.login-form').hide();
            $('.forget-form').hide();
        } else if (action == 'forgetpassword') {
            $('.register-form').hide();
            $('.login-form').hide();
            $('.forget-form').show();
        }
    });
</script>
@yield('script')
<!-- END JAVASCRIPTS -->
</body>
{{--<!-- END BODY -->--}}
</html>