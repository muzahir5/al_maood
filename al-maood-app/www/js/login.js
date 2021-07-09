var $$ = Dom7;

login = {    
    register: function () {
        core.alert(44);
        // if (core.isOnline()) {
            var name = $$('#reg_form .name').val();
            var email = $$('#reg_form .email').val();
            var password = $$('#reg_form .password').val();
            if (name === '') {
                core.alert('Error', 'Name required', 'OK', function () {
                    return;
                });
                return;
            }
            if (email === '') {
                core.alert('Error', 'Email required', 'OK', function () {
                    return;
                });
                return;
            }
            if (password === '') {
                core.alert('Error', 'Password required', 'OK', function () {
                    return;
                });
                return;
            }
            myApp.showIndicator();

            var register_data = {name: name, email: email, password: password};
            core.log(register_data);
            // var url = "user/userRegister";
            /*core.postRequest(url, register_data, function (response, status) {
                if (status === 'success') {
                    var result = JSON.parse(response);
                    if (result.status === 'success') {
                        $$('.login_form .email').val('');
                        $$('.login_form .password').val('');
                        localStorage.setItem('isStarted', true);
                        myApp.closeModal('.login-screen')
                        app.setSession(result);
                        if (result.client_type === 'logistic') {
                            profile.checkin_process('auto');
                        }
                        app.startLocationTracking();
                        profile.count_msg_ann();
                    } else {
                        core.alert('Error', result.error, 'OK');
                    }

                }
            });*/
        // }
    }

    // login_status: 'auth',
};

