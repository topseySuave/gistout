/**
 * Created by Daniel on 4/24/2017.
 */


var _ = $;
var _forgotPasswordArea = _('#forgotPasswordArea');
var _registerArea = _('#registerArea');
var _loginArea = _('#loginArea');
var _body = _('body');
var animate = 'animated shake';
var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationEnd animationEnd';


var _forgotPassword = _('#forgotPassword');
var _signUpButton = _('#signUpButton');
var _signInButton = _('#signInButton');
var _loaderImg = '<img src="/docs/img/loaders/default2.gif" style="width: 20px; height: 20px;margin: 8px;">';

    // _signInButton.click(function () {
    //     _registerArea.hide();
    //     _loginArea.show();
    // });
    //
    // _forgotPassword.click(function () {
    //     _loginArea.hide();
    //     _forgotPasswordArea.css({'margin-bottom':'150px'}).removeClass('hide').show();
    // });
    //
    // _signUpButton.click(function(){
    //     Materialize.toast('hello world', 2000);
    //     _loginArea.hide();
    //     _registerArea.removeClass('hide').show();
    // });

    _body.on('click', '#signinSubmitBtn', function(){
        var _self = _(this);
        var username = _('#usernameInput').val();
        var password = _('#passwordInput').val();
        var signInform = _('#signInForm').serialize();
        _self.html(_loaderImg).attr('disabled','disabled');
        if(username === ''){
            var animate = 'animated shake';
            var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd animationEnd';
            username.addClass(animate).one(animationEnd, function () {
                username.removeClass(animate);
            });
            _self.html('Post');
            _self.removeAttr('disabled');
        }else if(password === ''){
            var animate = 'animated shake';
            var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd animationEnd';
            password.addClass(animate).one(animationEnd, function () {
                password.removeClass(animate);
            });
            _self.html('Post');
            _self.removeAttr('disabled');
        }else{
            _.ajax({
                url: '/signin.php',
                type: 'post',
                cache: false,
                data: signInform,
                success: function (res) {
                    if(res == 1 || res == 3) // login was successful
                    {
                        _self.html('Signed In').removeAttr('disabled');
                        // $scope.$emit('');
                        location.href = getRedirectParam();
                        // window.location.href = urlRoot;
                    }
                    else if(res == 2 || res == 4)
                    {
                        Materialize.toast(' Error occurred. Invalid Request, Please Try Again !!', 5000);
                        // _('#errorMsg').html('<div class="small alert alert-danger alert-dismissible fade show" role="alert" xmlns="http://www.w3.org/1999/html"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Houston We Have a Problem!</strong><br/> Error occurred Please Try Again !!</div>').removeClass('hid').show();
                        _self.html('Sign In').removeAttr('disabled');
                    }
                    else if(res == 0)
                    {
                        Materialize.toast('The Email or Password You Entered Do not Exist, Please Input a Valid Email and Password', 5000);
                        // _('#errorMsg').html('<div class="small alert alert-danger alert-dismissible fade show" role="alert" xmlns="http://www.w3.org/1999/html"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Houston We Have a Problem!</strong><br/> The Email or Password You Entered Do not Exist Please Input a Valid Email and Password</div>').removeClass('hid').show();
                        _self.html('Sign In').removeAttr('disabled');
                    }
                },
                error: function (e) {
                    log(e);
                }
            });
            return false;
        }
    });

    var checked = false;
    _body.on('click', '#acceptTermCheck', function(){
        _(this).each(function(){
            if (checked == false) {
                _('#signUpSubmitBtn').removeAttr('disabled');
                checked = true;
            } else {
                _('#signUpSubmitBtn').attr('disabled', 'disabled');
                checked = false;
            }
        });
    });

    _body.on('click', '#acceptModal', function () {
        _('#acceptTermCheck').click();
        _('#acceptClose').click();
    });

    _body.on('click', '#signUpSubmitBtn', function (e) {
        e.preventDefault();
        var _self = _(this);
        var formData = _('#registerForm').serialize();
        _self.html(_loaderImg).attr('disabled','disabled');
        _.ajax({
            url: '/signup.php',
            type: 'POST',
            data: formData,
            success: function (res) {
                // log(res);
                if(res == 2) // username already exists
                {
                    Materialize.toast('Oops!, The Username You Entered Already Exists Please Input Another Username', 5000);
                    // _('#regErrorMsg').html('<div class="small alert alert-danger alert-dismissible fade show" role="alert" xmlns="http://www.w3.org/1999/html"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Oops!</strong><br/> The Username You Entered Already Exists Please Input Another Username</div>').removeClass('hid').show();
                    _self.html('Sign Up').removeAttr('disabled');
                }
                else if(res == 3) // email already exists
                {
                    Materialize.toast('Oops!, The Email You Entered Already Exists Please Input Another Email', 5000);
                    // _('#regErrorMsg').html('<div class="small alert alert-danger alert-dismissible fade show" role="alert" xmlns="http://www.w3.org/1999/html"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Oops!</strong><br/> The Email You Entered Already Exists Please Input Another Email</div>').removeClass('hid').show();
                    _self.html('Sign Up').removeAttr('disabled');
                }
                else if(res == 0)
                {
                    Materialize.toast('Oop!, Error Signin you Up we are on it right now.', 5000);
                    // throw Error('Oop!, Error Signin you Up we are on iut right now.');
                }
                else
                {
                    Materialize.toast('<strong>Welcome!</strong><i class="material-icons" style="font-size: 50px; color: #00bfa5;">check_circle</i> Successfully Registered! Verification message has been sent to the email you provided, Please verify your Account.<br/><div class="small">Redirected in 5 sec...</div>', 5000);
                    _self.html('Signed Up');
                    setTimeout(function () {
                        window.location.href = urlRoot;
                    }, 5000);
                }
            }
        });
        // }
        return false;
    });

    function checkInput(_self, username, email, password, confirmPassword){
        if(username == '')
        {
            _('#regUsernameInput').addClass(animate).one(animationEnd, function() {
                _('#regUsernameInput').removeClass(animate);
            });
            _self.html('Sign Up').removeAttr('disabled');
            return false;
        }
        else if (email == '')
        {
            _('#regEmailInput').addClass(animate).one(animationEnd, function() {
                _('#regEmailInput').removeClass(animate);
            });
            _self.html('Sign Up').removeAttr('disabled');
            return false;
        }
        else if(password == '')
        {
            _('#regPasswordInput').addClass(animate).one(animationEnd, function() {
                _('#regPasswordInput').removeClass(animate);
            });
            _self.html('Sign Up').removeAttr('disabled');
            return false;
        }
        else if (password != confirmPassword)
        {
            _('#regErrorMsg').html('<div class="small alert alert-danger alert-dismissible fade show" role="alert" xmlns="http://www.w3.org/1999/html"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Houston We Have a Problem!</strong><br/> The passwords you provided do not match</div>').removeClass('hid').show();
            _self.html('Sign Up').removeAttr('disabled');
            return false;
        }
        else
        {
            return true;
        }
    }