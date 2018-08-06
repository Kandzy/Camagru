function addcomment(id) {
    var text = document.getElementById("comment" + id).value;
    var PID = document.getElementById("PID"+id).getAttribute("value");
    var request = "PID=" + PID + "&text=" + text;
    var ajaxComment = new AjaxRequest(request, "/main/addComment", responseAddComent);
    function responseAddComent(responseText) {
        document.getElementById("comment" + id).value = "";
        var max = document.getElementsByClassName("galeryImage").length;
        for (var num = 1; num <=max; num++) {
            var PicID = document.getElementById("PID"+num).value;
            fillComment(PicID, num);
        }
    }
}

function galleryShow(min, max) {

    var from = (min - 1);
    var request = "from=" + from + "&to=" + max;
    var ajaxGallery = new AjaxRequest(request, "/main/showGallery", responseGalleryShow);
    function responseGalleryShow(responseText) {
        var image = JSON.parse(responseText);
        var PicID, st;
        var old = document.getElementsByClassName("galeryImage").length;
        var to = old + image.length;
        var iter = 5 - (max - to);
        for (var num = 1; num <=iter; num++) {
            addPicture(image[num -1]["url"], image[num-1]["PicID"]);
        }
        var updated = document.getElementsByClassName("galeryImage").length;
        for (st = 1; st <= updated; st++) {
            PicID = document.getElementById("PID"+st).value;
            fillComment(PicID, st);
        }
        for (st = 1; st <= updated; st++) {
            PicID = document.getElementById("PID"+st).value;
            checkLike(PicID, st);
        }
    }
}

function fillComment(PicID, id)
{

    var element = document.getElementById("commentpic"+id);
    var request = "PicID=" + PicID;
    if (!element)
        return;
    element.value = "";
    var ajaxFillComment = new AjaxRequest(request, "/main/FillComment", responseFillComment);
    function responseFillComment(responseText) {
        var comments = responseText.split("&");
        for (var i = comments.length - 1; i >= 0; i--) {
            element.value += comments[i] + "\n";
        }
    }
}

function bNext() {
    var old = document.getElementsByClassName("galeryImage").length;
    var upd = old+5;
    galleryShow(old+1, upd);
}

function addPicture(url, id) {
    var i = document.getElementsByClassName("galeryImage").length + 1;
    var cont = document.getElementById('Photos');
    if (cont) {
        url = "/" + url;
        cont.innerHTML +='<div class="BlockDiv">\n' +
            '            <div class="PhotoDiv">\n' +
            '                <input id="PID' + i + '" type="hidden" value="' + id + '">\n' +
            '                <img id="picture' + i + '" class="galeryImage" src="' + url + '">\n' +
            '<div><button id="like'+i+'" class="likes" onclick="addLike('+id+','+i+')">&hearts;</button> </div>'+
            '            </div>\n' +
            '            <div class="commentField">\n' +
            '                <textarea disabled class="Commarea" id="commentpic' + i + '"></textarea>\n' +
            '                <textarea placeholder="Add your comment..." id="comment' + i + '" class="userComment" onkeypress="if(event.keyCode == 13){addcomment(' + i + ');}"></textarea>\n' +
            '                <div>\n' +
            '                    <button id="button' + i + '" class="buttonSend" onclick="addcomment(' + i + ')">Send</button>\n' +
            '                </div>\n' +
            '            </div>\n' +
            '        </div>';
        if (!document.getElementById("profileBut")) {
            document.getElementById('comment'+i).style.display = "none";
            document.getElementById('button'+i).style.display = "none";
            document.getElementById('like'+i).style.display = "none";
        }
    }
}

function checkLike(id, i) {
    var request = "PID=" + id;
    var likeCheckRequest = new AjaxRequest(request ,"/main/checkLike", requestCheck);
    function requestCheck(responseText) {
        var likes = responseText.split("|");
        var like = document.getElementById("like"+i);
        if (parseInt(likes[1])) {
            like.style.backgroundColor = "#ff0023";
            like.innerHTML = likes[0]+'&hearts;';
        }else{
            like.style.backgroundColor = "#FFF";
            like.innerHTML = likes[0]+'&hearts;';
        }
    }
}

function addLike(id, i) {
    var request = "PID=" + id;
    var ajax = new AjaxRequest(request, "/main/addLike", addLikeRequest);
    function addLikeRequest(responseText) {
        var like = document.getElementById("like"+i);
        var likes = responseText.split("|");
        if (parseInt(likes[1]))
        {
            like.style.backgroundColor = "#ff0023";
            like.innerHTML = likes[0]+'&hearts;';
        }else {
            like.style.backgroundColor = "#fff";
            like.innerHTML = likes[0]+'&hearts;';
        }
    }
}

function newPhoto() {
    var newPictureButton = document.getElementById('NewPictureButton');
    if (newPictureButton)
    {
        newPictureButton.onclick = function () {
            window.location.href = "/camera/action";
        }
    }
}