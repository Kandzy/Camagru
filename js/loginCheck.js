function loginCheck(){

    var loginField = document.getElementById("loginSign");
    if (loginField) {
        var buttonLogin = document.getElementById("buttonLogin");
        loginField.onkeyup = function () {
            var log = document.getElementById("loginSign").value;
            var pass = document.getElementById("passLog").value;
            if (log == "" || pass == "") {
                buttonLogin.style.backgroundColor = "grey";
                buttonLogin.setAttribute("disabled", "");
            }
            else {
                buttonLogin.style.backgroundColor = "#08558b";
                buttonLogin.removeAttribute("disabled");
            }
        }
    }

    var pass = document.getElementById("passLog");
    if (pass) {
        var buttonLogin = document.getElementById("buttonLogin");
        pass.onkeyup = function () {
            var log = document.getElementById("loginSign").value;
            var pass = document.getElementById("passLog").value;
            if (log == "" || pass == "") {
                buttonLogin.style.backgroundColor = "grey";
                buttonLogin.setAttribute("disabled", "");
            }
            else {
                buttonLogin.style.backgroundColor = "#08558b";
                buttonLogin.removeAttribute("disabled");
            }
        }
    }

    var login = document.getElementById("buttonLogin");
    if (login) {
        login.onclick = function () {
            var log = document.getElementById("loginSign").value;
            var pass = document.getElementById("passLog").value;
            var LoginRequest = new AjaxRequest("login=" + log + "&passwd=" + pass, "/login/checkLog", LoginTry);
            function LoginTry(responseText) {
                if (responseText == 0) {
                    document.getElementById("errorLog").style.display = "block";
                    document.getElementById("tet").innerHTML = "Your username or password is incorrect.";
                }
                else if (responseText == 1) {
                    window.location.replace("/main");
                }
                else if (responseText == 2) {
                }
            }
        }
    }
    
    var recoveringButton = document.getElementById("buttonForgetPass");
    if(recoveringButton)
    {
        recoveringButton.onclick = function () {
            window.location.replace("/login/passrecovering")
        }
    }
}