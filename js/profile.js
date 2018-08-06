function img() {
    window.location.replace("/profile/addPicture");
}

function checkUpdates() {
    var login = document.getElementById('UpdateLogin');
    var email = document.getElementById('UpdateEmail');
    if (login)
    {
        login.onkeyup = function () {

            checkDataForUpdate();
        };
    }
    if (email)
    {
        email.onkeyup = function () {
            checkDataForUpdate();
        };
    }
    function checkDataForUpdate()
    {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                if (this.responseText == 1)
                {
                    document.getElementById('Upd').removeAttribute("disabled");
                    document.getElementById('updErr').innerHTML = "";
                    //window.location.replace("/profile");
                } else if(this.responseText == 0)
                {
                    document.getElementById('updErr').innerHTML = "User already exist";
                    document.getElementById('Upd').setAttribute("disabled", "");
                }
                else if (this.responseText == -1)
                {
                    document.getElementById('updErr').innerHTML = "Email already exist.";
                    document.getElementById('Upd').setAttribute("disabled", "");
                }
                else{
                    document.getElementById('updErr').innerHTML = "Unknown error.";
                }
            }
        };
        var request = "login=" + login.value + "&email=" + email.value;
        xhttp.open("POST", "/profile/checkUpdatedData", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(request);
    }
}

function profileGalleryShow(min, max) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var image = JSON.parse(this.responseText);
            var to = image.length;
            if (to != 0) {
                document.getElementById('ProfilePhotos').innerHTML = "";
                document.getElementById('MainPicture').setAttribute('src', '../../' + image[0]["url"]);
                document.getElementById("PID").setAttribute("value",image[0]["PicID"]);
                fillComment(image[0]["PicID"], 0);
            }
            else
            {
                var page = document.getElementById('page');
                page.setAttribute("value", ""+(page.value - 1));
            }
            for (var num = 1; num <=to; num++) {
                addProfilePicture(image[num -1]["url"], image[num-1]["PicID"]);
            }
        }
    };
    var from = (min - 1);
    var request = "from=" + from + "&to=" + max;
    xhttp.open("POST", "/profile/showGallery", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(request);
}

function addProfilePicture(url, id) {
    var i = document.getElementsByClassName("profilePhotoDiv").length + 1;
    var cont = document.getElementById('ProfilePhotos');
    if (cont) {
        cont.innerHTML +='            <div class="profilePhotoDiv">\n' +
            '                <input id="PID' + i + '" type="hidden" value="' + id + '">\n' +
            '                <img onclick="chosePicture('+i+')" id="picture' + i + '" class="profileSmallImg" src="../../' + url + '">\n' +
            '<button class="ButtonForget" onclick="delphoto('+i+')">del</button>' +
            '            </div>';
    }
}

function chosePicture(id) {
    var url = document.getElementById('picture'+id).getAttribute('src');
    var Pid = document.getElementById('PID'+id).getAttribute("value");
    document.getElementById('MainPicture').setAttribute('src', url);
    document.getElementById("PID").setAttribute("value",Pid);
    fillComment(Pid, 0);
}
function buttons() {
    var nextbutton = document.getElementById('buttonNext');
    if (nextbutton)
    {
        nextbutton.onclick = function () {
            var page = document.getElementById('page').value;
            var pictures = document.getElementsByClassName('profilePhotoDiv').length;
            if (pictures == 5)
            {
                var newpage = parseInt(page) + 1;
                document.getElementById('page').setAttribute('value', ""+newpage);
                profileGalleryShow((newpage - 1)*5 + 1, (newpage)*5);
            }
        }
    }
    var buttonprev = document.getElementById('buttonPrevious');
    if (buttonprev) {
        buttonprev.onclick = function () {
            var page = document.getElementById('page').value;
            if (page > 1)
            {
                var newpage = page - 1;
                document.getElementById('page').setAttribute('value', ""+newpage);
                profileGalleryShow((newpage-1)*5 + 1, (newpage)*5);
            }
        }
    }
}

function addAnsw() {
    var xhttp = new XMLHttpRequest();
    var text = document.getElementById('Answ').value;
    var PID = document.getElementById('PID').getAttribute("value");
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("Answ").value = "";
                fillComment(PID, 0);
        }
    };
    var request = "PID=" + PID + "&text=" + text;
    xhttp.open("POST", "/main/addComment", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(request);
}

/*
    Profile update form
 */

function buttonDelete() {
    window.location.replace("/profile/deleteUser");
}

function buttonChange() {
    // window.location.replace("/profile/changepassword");
    window.location.href = '/profile/changepassword';
}




function changePass() {
    var oldpass = document.getElementById('oldpass');
    var newpass = document.getElementById('newpass');
    var conpass = document.getElementById('connewpass');
    document.getElementById("changePass").onclick = function (){
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                if (this.responseText == 1)
                {
                    window.location.replace("/profile");
                } else if(this.responseText == 0)
                {
                    document.getElementById('passFail').innerHTML = "Passwords did not match or length less then 8 symbols.";
                }
                else if (this.responseText == -1)
                {
                    document.getElementById('passFail').innerHTML = "Old password did not match.";
                }
                else{
                    document.getElementById('passFail').innerHTML = "Unknown error.";
                }
            }
        };
        var request = "oldpass=" + oldpass.value + "&newpass=" + newpass.value + "&connewpass=" + conpass.value;
        xhttp.open("POST", "/profile/ConfirmChangePassword", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(request);
    };
    if (oldpass)
    {
        oldpass.onkeyup = function () {
            checkButtonStatus();
        }
    }
    if (newpass)
    {
        newpass.onkeyup = function () {
            checkButtonStatus();
        }
    }
    if (conpass)
    {
        conpass.onkeyup = function () {
            checkButtonStatus();
        }
    }
    function checkButtonStatus() {
        if (conpass.value == "" || newpass.value == "" || oldpass.value == "") {
            document.getElementById("changePass").style.backgroundColor = "grey";
            document.getElementById("changePass").setAttribute("disabled", "");
        }
        else {
            document.getElementById("changePass").style.backgroundColor = "#08558b";
            document.getElementById("changePass").removeAttribute("disabled");
        }
    }
}

function delphoto(i){
    var PID = document.getElementById('PID'+i).value;
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            if (document.getElementsByClassName('profilePhotoDiv').length > 1) {
                var page = document.getElementById("page").value;
                profileGalleryShow((page - 1) * 5 + 1, (page) * 5);
            }
            else if (document.getElementsByClassName('profilePhotoDiv').length == 1)
            {
                document.getElementById("ProfilePhotos").innerHTML = "";
                document.getElementById("MainPicture").setAttribute("src", "../../src/picnotfound.jpg");
                profileGalleryShow(1, 1);
            }
        }
    };
    var request = "PID=" + PID;
    xhttp.open("POST", "/profile/delPicture", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(request);
}


