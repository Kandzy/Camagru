
    var image;
    var left = 0;
    var down = 0;
    var hei = 50;
    var wid = 50;

    var oi;

    window.addEventListener("DOMContentLoaded", function () {
        var canvas = document.getElementById('canvas');
        if (canvas) {
            var context = canvas.getContext('2d');
            var video = document.getElementById('video');
            var mediaConfig = {video: true};

            var errBack = function (e) {
            };

            if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                navigator.mediaDevices.getUserMedia(mediaConfig).then(function (stream) {
                    video.src = window.URL.createObjectURL(stream);
                    video.play();
                });
            }
            else if (navigator.getUserMedia) {
                navigator.getUserMedia(mediaConfig, function (stream) {
                    video.src = stream;
                    video.play();
                }, errBack);
            } else if (navigator.webkitGetUserMedia) {
                navigator.webkitGetUserMedia(mediaConfig, function (stream) {
                    video.src = window.webkitURL.createObjectURL(stream);
                    video.play();
                }, errBack);
            } else if (navigator.mozGetUserMedia) {
                navigator.mozGetUserMedia(mediaConfig, function (stream) {
                    video.src = window.URL.createObjectURL(stream);
                    video.play();
                }, errBack);
            }


            //save and manipulating photo

            document.getElementById('TakePic').addEventListener('click', function () {
                canvas.style.display = "block";
                video.style.display = "none";;
                document.getElementById("TakePic").style.display = 'none';
                document.getElementById('savephoto').style.display = 'block';
                context.drawImage(video, 0, 0, 480, 360);
                oi = document.getElementById('hiddenIMG');
                var oldImg = document.getElementById("canvas").toDataURL('image/png');
                oi.src = oldImg;
            });
            var savePhoto = document.getElementById('savephoto');
            savePhoto.onclick = function () {

                var image = getImage(document.getElementById("canvas"));
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        window.location.href = "/profile";
                    }
                };
                var request = "image=" + image;
                xhttp.open("POST", "/camera/saveImg", true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send(request);
            };

            function getImage(canvas) {
                var imageData = canvas.toDataURL('image/png');
                return imageData;
            }
        }
        if (document.getElementById("camera")) {
            camGalleryShow(1, 5);
        }
            function camGalleryShow(min, max) {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        var image = JSON.parse(this.responseText);
                        var to = image.length;
                        if (to != 0) {
                            var temp = document.getElementById('camegaEditPhotos');
                            if (temp) {
                                temp.innerHTML = "";
                            }
                        }
                        else {
                            var page = document.getElementById('page');
                            if (page) {
                                page.setAttribute("value", "" + (page.value - 1));
                            }
                        }
                        for (var num = 1; num <= to; num++) {
                            addCameraPicture(image[num - 1]["url"], image[num - 1]["PicID"]);
                        }
                    }
                };
                var from = (min - 1);
                var request = "from=" + from + "&to=" + max;
                xhttp.open("POST", "/camera/CamShowGallery", true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send(request);
            }

        function addCameraPicture(url, id) {
            var i = document.getElementsByClassName("camPhotoDiv").length + 1;
            var cont = document.getElementById('camegaEditPhotos');
            if (cont) {
                cont.innerHTML += '            <div class="camPhotoDiv">\n' +
                    '                <input id="PID' + i + '" type="hidden" value="' + id + '">\n' +
                    '                <img onclick="choseFrontPicture(' + i + ')" id="picture' + i + '" class="camSmallImg" src="../../' + url + '">\n' +
                    '            </div>';
            }
        }

        var nextbutton = document.getElementById('cambuttonNext');
        if (nextbutton) {
            nextbutton.onclick = function () {
                var page = document.getElementById('pagecam').value;
                var pictures = document.getElementsByClassName('camPhotoDiv').length;
                if (pictures == 5) {
                    var newpage = parseInt(page) + 1;
                    document.getElementById('pagecam').setAttribute('value', "" + newpage);
                    camGalleryShow((newpage - 1) * 5 + 1, (newpage) * 5);
                }
            }
        }
        var buttonprev = document.getElementById('cambuttonPrevious');
        if (buttonprev) {
            buttonprev.onclick = function () {
                var page = document.getElementById('pagecam').value;
                if (page > 1) {
                    var newpage = page - 1;
                    document.getElementById('pagecam').setAttribute('value', "" + newpage);
                    camGalleryShow((newpage - 1) * 5 + 1, (newpage) * 5);
                }
            }
        }
        // }

        var W = document.getElementById("W");
        var H = document.getElementById("H");
        var L = document.getElementById("L");
        var D = document.getElementById("D");
        if (W && H && L && D) {
            W.onkeyup = function () {
                if (parseInt(W.value) > 0 && parseInt(W.value) <= 500)
                    wid = parseInt(W.value);
                if (oi) {
                    context.drawImage(oi, 0, 0, 480, 360);
                    context.drawImage(image, left, down, wid, hei);
                }
            };
            H.onkeyup = function () {
                if (parseInt(H.value) > 0 && parseInt(H.value) <= 400)
                    hei = parseInt(H.value);
                if (oi) {
                    context.drawImage(oi, 0, 0, 480, 360);
                    context.drawImage(image, left, down, wid, hei);
                }
            };
            D.onkeyup = function () {
                if (parseInt(D.value) >= 0 && parseInt(D.value)<= 100)
                    down = 360 * parseInt(D.value) / 100;
                if (oi) {
                    context.drawImage(oi, 0, 0, 480, 360);
                    context.drawImage(image, left, down, wid, hei);
                }
            };
            L.onkeyup = function () {
                if (parseInt(L.value) >= 0 && L.value <= 100)
                    left = 480 * parseInt(L.value)/100;
                if (oi) {
                    context.drawImage(oi, 0, 0, 480, 360);
                    context.drawImage(image, left, down, wid, hei);
                }
            };
        }
    }, false);


    function choseFrontPicture(id) {
        image = document.getElementById('picture' + id);
        var context = canvas.getContext('2d');
        if (oi) {
            document.getElementById('savephoto').removeAttribute("disabled");
            context.drawImage(oi, 0, 0, 480, 360);
            context.drawImage(image, left, down, wid, hei);
        }
    }