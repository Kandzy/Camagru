function recoveringPassword() {

    var loginRecoverField = document.getElementById("loginForRecover");
    if (loginRecoverField) {
        loginRecoverField.onkeyup = function () {
            recoverButtonCheck();
        }
    }

    var EmailRecoverField = document.getElementById("EmailForRecover");
    if (EmailRecoverField) {
        EmailRecoverField.onkeyup = function () {
            recoverButtonCheck();
        }
    }

    var recoverButton = document.getElementById("buttonRecovering");
    if (recoverButton) {
        recoverButton.onclick = function () {
            var request = "login=" + document.getElementById("loginForRecover").value + "&email=" + document.getElementById("EmailForRecover").value;
            var ajaxRecoverPass = new AjaxRequest(request, "/passrecover", responseRecoverPassword);
            function responseRecoverPassword(responseText) {
                var errorRecovering = document.getElementById("errorRecovering");
                var ErrorMessage = document.getElementById('ErrorMessage');
                if (responseText == 1) {
                    window.location.replace("/login");
                } else if (responseText == 0) {
                    errorRecovering.style.display = "block";
                    ErrorMessage.innerHTML = "Your username or email is incorrect.";
                }
                else {
                    errorRecovering.style.display = "block";
                    ErrorMessage.innerHTML = "Sorry but we cant send email =( Try next time.";
                }
            }
        }
    }

    function recoverButtonCheck() {
        var log = document.getElementById("loginForRecover").value;
        var email = document.getElementById("EmailForRecover").value;
        var buttonRecovering = document.getElementById("buttonRecovering");
        if (log == "" || email == "") {
            buttonRecovering.style.backgroundColor = "grey";
            buttonRecovering.setAttribute("disabled", "");
        }
        else {
            buttonRecovering.style.backgroundColor = "#08558b";
            buttonRecovering.removeAttribute("disabled");

        }
    }
}

function deleteHeader()
{
    document.getElementById('headerGaleryButton').innerHTML = '';
    document.getElementById('LoginSignin').innerHTML = '';
}

function recoverForm() {
    var loginRecoverField = document.getElementById("newRecoveredPasswd");
    if (loginRecoverField) {
        loginRecoverField.onkeyup = function () {
            recoverButtonCheck();
        }
    }

    var EmailRecoverField = document.getElementById("newRecoveredPasswdConfirm");
    if (EmailRecoverField) {
        EmailRecoverField.onkeyup = function () {
            recoverButtonCheck();
        }
    }

    function recoverButtonCheck() {
        var buttonRecover = document.getElementById("buttonRecover");
        var pass1 = document.getElementById("newRecoveredPasswd").value;
        var pass2 = document.getElementById("newRecoveredPasswdConfirm").value;
        if (pass1 == "" || pass2 == "") {
            buttonRecover.style.backgroundColor = "grey";
            buttonRecover.setAttribute("disabled", "");
        }
        else {
            buttonRecover.style.backgroundColor = "#08558b";
            buttonRecover.removeAttribute("disabled");
        }
    }

    var recoverButton = document.getElementById("buttonRecover");
    if (recoverButton) {
        recoverButton.onclick = function () {
            var userData = document.getElementById('userData');
            var password1 = document.getElementById("newRecoveredPasswd");
            var password2 = document.getElementById("newRecoveredPasswdConfirm");
            var login = userData.name;
            var act = userData.value;
            var request = "pass1=" + password1.value + "&pass2=" + password2.value + "&login=" + login + "&act=" + act;
            
            var ajaxRecoverButton = new AjaxRequest(request, "/passrecover/finish_recover", responseRecoverButton);
            
            function responseRecoverButton(responseText) {
                var errorRecovering = document.getElementById("errorRecovering");
                var ErrorMessage = document.getElementById('ErrorMessage');
                if (responseText == 1) {
                    window.location.replace("/login");
                } else if (responseText == 0) {
                    errorRecovering.style.display = "block";
                    ErrorMessage.innerHTML = "Passwords do not match.";
                }
                else if (responseText == -1) {
                    errorRecovering.style.display = "block";
                    ErrorMessage.innerHTML = "Sorry but we cant recover your password=( Try next time.";
                }else {
                    errorRecovering.style.display = "block";
                    ErrorMessage.innerHTML = "Password must consist of big and small letters and digits.";
                }
            }
        }
    }
}