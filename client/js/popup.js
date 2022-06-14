var username = "pranav";
var password_hash = "a12619925a8e16d9a7a827d8ce6375aa";

var welcomeBoardOpen = true;
var currentContactOpen = "";


//Detect change in existing and retrieved DOM
function foundUpdations(retrievedMessagesCount, elementId) {
    var existingMessagesCount = document.getElementById(elementId).childElementCount;
    
    if(retrievedMessagesCount == existingMessagesCount)
        return false;
    else
        return true;
}



//Main method
function init() {
    
    //Retrieve All Contacts & Add Buttons
    setInterval(function() {
        retrieveContacts();
    }, 2000);

    /*setInterval(function() {
        retrieveMessages();
    }, 500);*/
}



//Retrieve & Update Contacts
function retrieveContacts() {

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var parser = new DOMParser();
            var responseDom = parser.parseFromString(this.responseText, "text/html");
            var retrievedContacts = responseDom.getElementById('contacts-list');
            
            if(foundUpdations(retrievedContacts.childElementCount, "contacts-list"))
                updateContacts(retrievedContacts);
        }
    };

    var urlParameters = "of="+username+"&key="+password_hash;
    var url = "https://ghost-in-the-heap.000webhostapp.com/Messenger/server/php/fetch_contacts.php?"+urlParameters;
    xmlhttp.open("GET", url, true);
    xmlhttp.send();
}

function updateContacts(retrievedContacts) {

    var existingContacts = document.getElementById('contacts-list');
    var contacts = document.getElementById('contacts');

    contacts.removeChild(existingContacts);
    contacts.appendChild(retrievedContacts);

    addContactButtons(retrievedContacts);
}



//Add Event Listeners to Contact Buttons
function addContactButtons(retrievedContacts) {

    retrievedContacts.childNodes.forEach(contact => {
        contact.addEventListener("click", function() {
            
            currentContactOpen = contact.innerText;
            if(welcomeBoardOpen) {

                setInterval(function() {
                    retrieveMessages();
                }, 300);
                welcomeBoardOpen = false;
            }
            setTimeout(function() {
                updateContactName();
            }, 200);
        });
    });
}

function updateContactName() {
    document.getElementById("contact-name").innerText = currentContactOpen;
}



//Retrieve & Update Messages for selected Contact
function retrieveMessages() {
    
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var parser = new DOMParser();
            var responseDom = parser.parseFromString(this.responseText, "text/html");
            var retrievedMessages = responseDom.getElementById('messages');
            
            if(foundUpdations(retrievedMessages.childElementCount, "messages"))
                updateMessages(retrievedMessages);
        }
    };

    var urlParameters = "for="+username+"&between="+currentContactOpen+"&key="+password_hash;
    var url = "https://ghost-in-the-heap.000webhostapp.com/Messenger/server/php/fetch_messages.php?"+urlParameters;
    xmlhttp.open("GET", url, true);
    xmlhttp.send();
}

function updateMessages(retrievedMessages) {
    
    var existingMessages = document.getElementById('messages');
    var chat = document.getElementById('chat');

    chat.removeChild(existingMessages);
    chat.insertBefore(retrievedMessages, document.getElementById("new-message"));
    retrievedMessages.children[retrievedMessages.childElementCount-1].scrollIntoView();
}


init();