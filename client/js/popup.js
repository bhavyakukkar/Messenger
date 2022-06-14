var username = "pranav";
var password_hash = "a12619925a8e16d9a7a827d8ce6375aa";
var contact = "bhavya";

function init() {
    //updateContacts();
    setInterval(function() {
        retrieveMessages();
    }, 500);
}

function retrieveMessages() {

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var parser = new DOMParser();
            var responseDom = parser.parseFromString(this.responseText, "text/html");
            var retrievedMessages = responseDom.getElementById('messages');
            
            if(foundUpdations(retrievedMessages.childElementCount))
                updateMessages(retrievedMessages);
        }
    };

    var urlParameters = "for="+username+"&between="+contact+"&key="+password_hash;
    var url = "https://ghost-in-the-heap.000webhostapp.com/Messenger/server/php/fetch_messages.php?"+urlParameters;
    xmlhttp.open("GET", url, true);
    xmlhttp.send();
}


function foundUpdations(retrievedMessagesCount) {
    var existingMessagesCount = document.getElementById('messages').childElementCount;
    
    if(retrievedMessagesCount == existingMessagesCount)
        return false;
    else
        return true;
}


function updateMessages(retrievedMessages) {
    
    var messages = document.getElementById('messages');
    var chat = document.getElementById('chat');

    chat.removeChild(messages);
    chat.insertBefore(retrievedMessages, document.getElementById("new-message"));
}


init();