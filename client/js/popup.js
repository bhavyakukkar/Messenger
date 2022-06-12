var username = "pranav";
var password_hash = "a12619925a8e16d9a7a827d8ce6375aa";
var contact = "bhavya";

function init() {
    //updateContacts();
    updateMessages();
}

function updateMessages() {

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var parser = new DOMParser();
            var responseDoc = parser.parseFromString(this.responseText, "text/html");

            console.log(responseDoc);
        }
    };

    var urlParameters = "for="+username+"&between="+contact+"&key="+password_hash;
    var url = "https://ghost-in-the-heap.000webhostapp.com/Messenger/server/php/fetch_messages.php?"+urlParameters;
    xmlhttp.open("GET", url, true);
    xmlhttp.send();
}


if (document.readyState !== 'loading') {
    init();
} else {
    document.addEventListener('DOMContentLoaded', function() {
        init();
    });
}