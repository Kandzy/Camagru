function signupCheck(){

var loginSign = document.getElementById("SignUp");
    if (loginSign) {
        loginSign.onclick = function () {
            var log = document.getElementById("login").value;
            var pass = document.getElementById("passwd").value;
            var pass2 = document.getElementById("passwd2").value;
            var email = document.getElementById("email").value;
            var errorSign = document.getElementById("errorSign");
            var errorMsg = document.getElementById("errorMsg");
            var request = "login=" + log + "&email=" + email + "&passwd=" + pass + "&conf_pass=" + pass2;
            var register = new AjaxRequest(request, "/signup/register", registeMsg);
            function registeMsg(responseText)
            {
                if (responseText == 0) {
                    errorSign.style.display = "block";
                    errorMsg.innerHTML = "Your username or password is incorrect.";
                }
                else if (responseText == 1) {
                    window.location.replace("/main");
                }
                else if (responseText == -1) {
                    errorSign.style.display = "block";
                    errorMsg.innerHTML = "Your username, email or password is incorrect.";
                }
            }
        }
    }


    var loginField = document.getElementById("login");
    if (loginField) {
        loginField.onkeyup = function () {
            checkButton();
        };
        loginField.onchange = function () {
            var log = document.getElementById("login").value;
            var userExistDiv = document.getElementById('userExistDiv');
            var userExist = document.getElementById("userExist");
            if (log.length >= 6) {
                loginField.style.backgroundColor = "#FFF";
                var loginCheckRequest = new AjaxRequest("login=" + log, "/signup/userExist", loginIsSet);
            }else {
                loginField.style.backgroundColor = "#F00000D0";
            }
            function loginIsSet(responseText) {
                if (responseText == 0) {
                    loginField.style.backgroundColor = "#FFF";
                    userExistDiv.style.display = 'none';
                }
                if (responseText == 1) {
                    loginField.style.backgroundColor = "#F00000D0";
                    userExistDiv.style.display = 'block';
                    userExist.innerHTML = "User already exist.";
                }
            }
        }
    }



    var email = document.getElementById("email");
    if (email) {
        email.onkeyup = function () {
            checkButton();
        };
        email.onchange = function () {
            var regular = /^[-a-z0-9!#$%&'*+/=?^_`{|}~]+(?:\.[-a-z0-9!#$%&'*+/=?^_`{|}~]+)*@(?:[a-z0-9]([-a-z0-9]{0,61}[a-z0-9])?\.)*(?:aero|arpa|asia|biz|cat|com|coop|edu|gov|info|int|jobs|mil|mobi|museum|name|net|org|pro|tel|travel|[a-z][a-z])$/;
            if (!regular.test(email.value))
            {
                email.style.backgroundColor = '#F00000D0';
            }
            else
            {
                var em = email.value;
                var emailExistDiv = document.getElementById('emailExistDiv');
                var emailExist = document.getElementById('emailExist');
                email.style.backgroundColor = 'white';
                var emailCheckRequest = new AjaxRequest("email=" + em, "/signup/emailExist", emailIsSet);
                function emailIsSet(responseText) {
                    if (responseText == 0)
                    {
                        email.style.backgroundColor = "#FFF";
                        emailExistDiv.style.display = 'none';
                    }
                    if (responseText == 1)
                    {
                        emailExistDiv.style.display = 'block';
                        emailExist.innerHTML = "Email already exist";
                        email.style.backgroundColor = "#F00000D0";
                    }
                }
            }
        }
    }
    


    var pass = document.getElementById("passwd");
    if (pass) {
        pass.onkeyup = function () {
            checkButton();
        };
        pass.onchange = function ()
        {
            checkPassLength();
            checkPassMatch();
        }
    }

    var pass2 = document.getElementById("passwd2");
    if (pass2) {
        pass2.onkeyup = function () {
            checkButton();
        };
        pass2.onchange = function ()
        {
            checkPassLength();
            checkPassMatch();

        }
    }

    function checkButton()
    {
        var log = document.getElementById("login").value;
        var pass = document.getElementById("passwd").value;
        var pass2 = document.getElementById("passwd2").value;
        var email = document.getElementById("email").value;
        var buttonSignUp = document.getElementById("SignUp");
        if (log == "" || pass == "" || pass2 == "" || email == "") {
            buttonSignUp.style.backgroundColor = "grey";
            buttonSignUp.setAttribute("disabled", "");
        }
        else {
            if (!checkPassLength()) {
                buttonSignUp.style.backgroundColor = "#08558b";
                buttonSignUp.removeAttribute("disabled");
            }
        }
    }
    
    function checkPassLength() {
        var lengthOK = 0;
        if (pass2.value.length < 8) {
            pass2.style.backgroundColor = "#F00000D0";
            lengthOK = 1;
        }
        else {
            pass2.style.backgroundColor = "#FFF";
            lengthOK = 0;
        }
        if (pass.value.length < 8)
        {
            pass.style.backgroundColor = "#F00000D0";
            lengthOK = 1;
        }else
        {
            pass.style.backgroundColor = "#FFF";
            lengthOK = 0;
        }
        return lengthOK;
    }
    function checkPassMatch() {
        var passwordMatchDiv = document.getElementById('passwordMatchDiv');
        if (pass.value !== pass2.value)
        {
            passwordMatchDiv.style.display = 'block';
            document.getElementById('passwordMatch').innerHTML = "\n" + "Passwords do not match";
            pass.style.backgroundColor = "#F00000D0";
            pass2.style.backgroundColor = "#F00000D0";
        }
        else
        {
            pass.style.backgroundColor = "#FFF";
            pass2.style.backgroundColor = "#FFF";
            passwordMatchDiv.style.display = 'none';
        }

    }
 }