function time() {
    var time = new Date();

    var elem = document.getElementById('time');
    var sec = time.getSeconds();
    var min = time.getMinutes();
    var h = time.getHours();
    if (sec < 10)
    {
        sec = "0" + sec;
    }
    if (min < 10)
    {
        min = "0" + min;
    }
    if (h < 10)
    {
        h = "0" + h;
    }
    var string = h + ":" + min + ":" + sec;
    elem.innerHTML = string;
}


window.onload = function () {
    time();

    var go = setInterval(time, 1000);
    if (document.getElementById("loginPage")){
        loginCheck();
    }
    if (document.getElementById("signup")) {
        signupCheck();
    }
    if (document.getElementById("gallery")) {
        newPhoto();
        galleryShow(1, 5);
    }
    if (document.getElementsByClassName("recoverPass"))
    {
        recoveringPassword();
    }
    if (document.getElementById('recoverPassForm'))
    {
        deleteHeader();
        recoverForm();
    }
    if (document.getElementById("profileGaleryForm"))
    {
        profileGalleryShow(1, 5);
        buttons();
    }
    if (document.getElementsByClassName("profileUpdateForm"))
    {
        checkUpdates();
    }

    if(document.getElementById('changePassForm')){
        changePass();
    }
    var gallery = document.getElementById("galleryButton");
    if (gallery)
    {
        gallery.onclick =function () {
            window.location.href = '/';
        };
    }
};
