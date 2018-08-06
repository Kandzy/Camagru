class AjaxRequest {
    constructor (request, controllerMethod, responseAction) {
        this.postRequest = request;
        this.controllerMethod = controllerMethod;
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200)
            {
                responseAction(this.responseText);
            }
        };
        xhttp.open("POST", this.controllerMethod, true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(this.postRequest);
    }
}