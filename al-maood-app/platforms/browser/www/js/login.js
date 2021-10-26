var $$ = Dom7;

login = {    
    register: function () {
        // if (core.isOnline()) {
            var name = $$('.reg_form .name').val();
            var email = $$('.reg_form .email').val();
            var password = $$('.reg_form .password').val();
            var conf_pass = $$('.reg_form .conf_pass').val();
            
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
            if (password != conf_pass) {
                core.alert('Error', 'Confirm Password not matched', 'OK', function () {
                    return;
                });
                return;
            }
            myApp.showIndicator();

            var register_data = {name: name, email: email, password: password};
            core.log(register_data);
            var url = "user/userRegister";
            core.postRequest(url, register_data, function (response, status) {
                // if (status === 'success') {            
                core.log(response);
                var result = JSON.parse(response);
                    if (result.status === 'success') {                        
                        $$('.login_form .email').val('');
                        $$('.login_form .password').val('');
                        $$('.reg_form .password').val('');
                        $$('.reg_form .conf_pass').val('');
                        // localStorage.setItem('isStarted', true);
                        // myApp.closeModal('.login-screen')
                        // app.setSession(result);
                    core.alert('Success', 'Please Check Your E-mail to Activite Your Account', 'OK', function () {
                    return;
                });
                    } else {
                        $.each(result.error,function(key,msg){
                            core.alert('Error', msg, 'OK');
                        });
                        
                    }

                // }
            });
        // }
    }

    // login_status: 'auth',
};

