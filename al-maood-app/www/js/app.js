var map;
var infowindow;
var $$ = Dom7;
var app = {
    pyrmont: {},
    push: {
        id: '880441689454'
    },
    initialize: function () {
        this.bindEvents();
    },
    bindEvents: function () {
        document.addEventListener('deviceready', app.onDeviceReady, false);
        document.addEventListener("pause", core.onPause, false);
        document.addEventListener("resume", core.onResume, false);
        document.addEventListener("backbutton", core.goBack, false);

    },
    onDeviceReady: function () {
        core.current_screen = 'index';
        core.onResume();
        
        if (core.isOnline()) {
            profile.showSideMenuName();
            var login_status = localStorage.getItem(login.login_status);
            if (login_status === true || login_status === 'true') {
                profile.count_msg_ann13();
            }
        }
    },
    setSession: function (data) {
        localStorage.setItem(login.login_status, true);
        app.saveSession(data);
    },
    saveSession: function (result) {
        core.log(result);
        localStorage.setItem('user_id', result.user_id);
        localStorage.setItem('driver_id', result.rider_id);
        localStorage.setItem('full_name', result.full_name);
        localStorage.setItem('mobile', result.mobile);
        localStorage.setItem('email', result.email);
        localStorage.setItem('driver_pic', result.driver_pic);
        localStorage.setItem('vehicle_number', result.vehicle_number);
        localStorage.setItem('restaurant_address', result.restaurant_address);
        localStorage.setItem('restaurant_name', result.restaurant_name);
        localStorage.setItem('restaurant_phone', result.restaurant_phone);
        localStorage.setItem('restaurant_latitude', result.restaurant_latitude);
        localStorage.setItem('restaurant_longitude', result.restaurant_longitude);
        localStorage.setItem('restaurant_email', result.restaurant_email);
        localStorage.setItem('department', result.department);
        localStorage.setItem('based_at', result.based_at);
        localStorage.setItem('job_title', result.job_title);
        localStorage.setItem('emp_latitude', result.emp_latitude);
        localStorage.setItem('emp_longitude', result.emp_longitude);
        localStorage.setItem('client_type', result.client_type);
        profile.showSideMenuName();
        profile.loadSetting();
        profile.loadMap();
        profile.count_msg_ann();
    },

};
$$('.create-popup').on('click', function () {
    var popupHTML = '<div class="popup">'+
                      '<div class="content-block">'+
                        // ''+
                        '<div data-page="forgot_pasword" class="page inner_page no-toolbar trip_detail_page">'+
                            '<div class="page-content">'+

                                '<div class="forgot_password-screen" id="forgot_password-screen">'+
                                    '<div class="page-content forgot_password-screen-content">'+                                   
                                        

                                        '<form class="forgot_password_recover" style="display:none; ">'+
                                        '<div class="lgin-wlcm">'+
                                            '<h1>Recover Password</h1>'+
                                            '<p>Enter Code And New password</p>'+
                                        '</div>'+
                                            '<div class="list">'+
                                                '<ul>'+
                                                    '<li class="item-content item-input">'+
                                                        '<div class="item-inner">'+
                                                            '<div class="item-input-wrap">'+
                                                                '<input type="text" class="code" name="code" placeholder="Enter Code" value="">'+
                                                            '</div>'+
                                                        '</div>'+
                                                    '</li>'+
                                                    '<li class="item-content item-input">'+
                                                        '<div class="item-inner">'+
                                                            '<div class="item-input-wrap">'+
                                                                '<input type="password" class="password" name="password" placeholder="Enter New Password" value="">'+
                                                            '</div>'+
                                                        '</div>'+
                                                    '</li>'+
                                                    '<li class="item-content item-input">'+
                                                        '<div class="item-inner">'+
                                                            '<div class="item-input-wrap">'+
                                                                '<input type="password" class="confirm" name="confirm" placeholder="Enter Confirm Password" value="">'+
                                                            '</div>'+
                                                        '</div>'+
                                                    '</li>'+
                                                    
                                                '</ul>'+
                                            '</div>'+
                                            '<div class="list">'+
                                                '<ul>'+
                                                    '<li class="form_submit_wrapper">'+
                                                        '<a class="item-link button button-fill" href="#" onclick="login.recover_pass()" style="width: 94%; ">Submit</a></li>'+
                                                '</ul>'+
                                            '</div>'+
                                        '</form>'+
                                        '<form class="forgot_password_form">'+
                                        '<div class="lgin-wlcm">'+
                                            '<h1>Forgot Password</h1>'+
                                            '<p>Enter your email address to reset the password</p>'+
                                        '</div>'+
                                            '<div class="list">'+
                                                '<ul>'+
                                                    '<li class="item-content item-input">'+
                                                        '<div class="item-inner">'+
                                                            '<div class="item-input-wrap">'+
                                                                '<input type="text" class="email" name="email" placeholder="Email Address" value="">'+
                                                            '</div>'+
                                                        '</div>'+
                                                    '</li>'+
                                                    
                                                '</ul>'+
                                            '</div>'+
                                            '<div class="list">'+
                                                '<ul>'+
                                                    '<li class="form_submit_wrapper">'+
                                                        '<a class="item-link button button-fill" href="#" onclick="login.forgotPassword()">Reset Password</a></li>'+
                                                '</ul>'+
                                            '</div>'+
                                        '</form>'+

                                        '<div class="footer">'+
                                        '<p><a href="#" class="close-popup">Cancel</a></p>'+
                                        '</div>'+
                                    '</div>'+
                               '</div>'+
                            '</div>'+
                        '</div>'+
                        '<p><a href="#" class="close-popup">Cancel</a></p>'+
                      '</div>'+
                    '</div>'
    myApp.popup(popupHTML);
  }); 