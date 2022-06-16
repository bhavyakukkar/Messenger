var username = "pranav";
var key = "a12619925a8e16d9a7a827d8ce6375aa";

var welcomeBoardOpen = true;
var currentContactOpen = "";

var hostUrl = "https://ghost-in-the-heap.000webhostapp.com/";
var storageUsernameIndex = "Messenger-Login-username";
var storageKeyIndex = "Messenger-Login-key";



//Detect change in existing and retrieved DOM
function foundUpdations(retrievedMessagesCount, elementId) {
    var existingMessagesCount = document.getElementById(elementId).childElementCount;
    
    if(retrievedMessagesCount == existingMessagesCount)
        return false;
    else
        return true;
}

function clean(message) {
    return message.replace('\n', '%0A');
}

function sendXmlHttpsRequest(url, responseId) {

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var parser = new DOMParser();
            var responseDom = parser.parseFromString(this.responseText, "text/html");
            var requestedDom = responseDom.getElementById(responseId);
            
            return requestedDom;
        }
    };
    xmlhttp.open("GET", url, true);
    xmlhttp.send();
}

function hash(password) {
    input = "6562832"+password+"6562832";
    var hash = function(d){var r = M(V(Y(X(d),8*d.length)));return r.toLowerCase()};function M(d){for(var _,m="0123456789ABCDEF",f="",r=0;r<d.length;r++)_=d.charCodeAt(r),f+=m.charAt(_>>>4&15)+m.charAt(15&_);return f}function X(d){for(var _=Array(d.length>>2),m=0;m<_.length;m++)_[m]=0;for(m=0;m<8*d.length;m+=8)_[m>>5]|=(255&d.charCodeAt(m/8))<<m%32;return _}function V(d){for(var _="",m=0;m<32*d.length;m+=8)_+=String.fromCharCode(d[m>>5]>>>m%32&255);return _}function Y(d,_){d[_>>5]|=128<<_%32,d[14+(_+64>>>9<<4)]=_;for(var m=1732584193,f=-271733879,r=-1732584194,i=271733878,n=0;n<d.length;n+=16){var h=m,t=f,g=r,e=i;f=md5_ii(f=md5_ii(f=md5_ii(f=md5_ii(f=md5_hh(f=md5_hh(f=md5_hh(f=md5_hh(f=md5_gg(f=md5_gg(f=md5_gg(f=md5_gg(f=md5_ff(f=md5_ff(f=md5_ff(f=md5_ff(f,r=md5_ff(r,i=md5_ff(i,m=md5_ff(m,f,r,i,d[n+0],7,-680876936),f,r,d[n+1],12,-389564586),m,f,d[n+2],17,606105819),i,m,d[n+3],22,-1044525330),r=md5_ff(r,i=md5_ff(i,m=md5_ff(m,f,r,i,d[n+4],7,-176418897),f,r,d[n+5],12,1200080426),m,f,d[n+6],17,-1473231341),i,m,d[n+7],22,-45705983),r=md5_ff(r,i=md5_ff(i,m=md5_ff(m,f,r,i,d[n+8],7,1770035416),f,r,d[n+9],12,-1958414417),m,f,d[n+10],17,-42063),i,m,d[n+11],22,-1990404162),r=md5_ff(r,i=md5_ff(i,m=md5_ff(m,f,r,i,d[n+12],7,1804603682),f,r,d[n+13],12,-40341101),m,f,d[n+14],17,-1502002290),i,m,d[n+15],22,1236535329),r=md5_gg(r,i=md5_gg(i,m=md5_gg(m,f,r,i,d[n+1],5,-165796510),f,r,d[n+6],9,-1069501632),m,f,d[n+11],14,643717713),i,m,d[n+0],20,-373897302),r=md5_gg(r,i=md5_gg(i,m=md5_gg(m,f,r,i,d[n+5],5,-701558691),f,r,d[n+10],9,38016083),m,f,d[n+15],14,-660478335),i,m,d[n+4],20,-405537848),r=md5_gg(r,i=md5_gg(i,m=md5_gg(m,f,r,i,d[n+9],5,568446438),f,r,d[n+14],9,-1019803690),m,f,d[n+3],14,-187363961),i,m,d[n+8],20,1163531501),r=md5_gg(r,i=md5_gg(i,m=md5_gg(m,f,r,i,d[n+13],5,-1444681467),f,r,d[n+2],9,-51403784),m,f,d[n+7],14,1735328473),i,m,d[n+12],20,-1926607734),r=md5_hh(r,i=md5_hh(i,m=md5_hh(m,f,r,i,d[n+5],4,-378558),f,r,d[n+8],11,-2022574463),m,f,d[n+11],16,1839030562),i,m,d[n+14],23,-35309556),r=md5_hh(r,i=md5_hh(i,m=md5_hh(m,f,r,i,d[n+1],4,-1530992060),f,r,d[n+4],11,1272893353),m,f,d[n+7],16,-155497632),i,m,d[n+10],23,-1094730640),r=md5_hh(r,i=md5_hh(i,m=md5_hh(m,f,r,i,d[n+13],4,681279174),f,r,d[n+0],11,-358537222),m,f,d[n+3],16,-722521979),i,m,d[n+6],23,76029189),r=md5_hh(r,i=md5_hh(i,m=md5_hh(m,f,r,i,d[n+9],4,-640364487),f,r,d[n+12],11,-421815835),m,f,d[n+15],16,530742520),i,m,d[n+2],23,-995338651),r=md5_ii(r,i=md5_ii(i,m=md5_ii(m,f,r,i,d[n+0],6,-198630844),f,r,d[n+7],10,1126891415),m,f,d[n+14],15,-1416354905),i,m,d[n+5],21,-57434055),r=md5_ii(r,i=md5_ii(i,m=md5_ii(m,f,r,i,d[n+12],6,1700485571),f,r,d[n+3],10,-1894986606),m,f,d[n+10],15,-1051523),i,m,d[n+1],21,-2054922799),r=md5_ii(r,i=md5_ii(i,m=md5_ii(m,f,r,i,d[n+8],6,1873313359),f,r,d[n+15],10,-30611744),m,f,d[n+6],15,-1560198380),i,m,d[n+13],21,1309151649),r=md5_ii(r,i=md5_ii(i,m=md5_ii(m,f,r,i,d[n+4],6,-145523070),f,r,d[n+11],10,-1120210379),m,f,d[n+2],15,718787259),i,m,d[n+9],21,-343485551),m=safe_add(m,h),f=safe_add(f,t),r=safe_add(r,g),i=safe_add(i,e)}return Array(m,f,r,i)}function md5_cmn(d,_,m,f,r,i){return safe_add(bit_rol(safe_add(safe_add(_,d),safe_add(f,i)),r),m)}function md5_ff(d,_,m,f,r,i,n){return md5_cmn(_&m|~_&f,d,_,r,i,n)}function md5_gg(d,_,m,f,r,i,n){return md5_cmn(_&f|m&~f,d,_,r,i,n)}function md5_hh(d,_,m,f,r,i,n){return md5_cmn(_^m^f,d,_,r,i,n)}function md5_ii(d,_,m,f,r,i,n){return md5_cmn(m^(_|~f),d,_,r,i,n)}function safe_add(d,_){var m=(65535&d)+(65535&_);return(d>>16)+(_>>16)+(m>>16)<<16|65535&m}function bit_rol(d,_){return d<<_|d>>>32-_}
    return hash(input);
}



function init() {
    
    checkLogin();
}

function main() {
    setInterval(function() {
        retrieveContacts();
    }, 800);
}



function checkLogin() {
    var storedUsername;

    chrome.storage.sync.get(storageUsernameIndex, function(data) {
        storedUsername = data[storageUsernameIndex];
        if(storedUsername) {
            username = storedUsername;
            chrome.storage.sync.get(storageKeyIndex, function(data) {
                storedPassword = data[storageKeyIndex];
                password = storedPassword;
                showScreen("main");
            });
        }
        else {
            showScreen("anon");
            addLoginButton();
            addRegisterButton();
        }
    });
}

function addLoginButton() {
    
    document.getElementById("login-screen-button").addEventListener('click', function() {
        showScreen("login");
        hideScreen("anon");
        
        document.getElementById("login-username-error").style.display = "none";
        document.getElementById("login-password-error").style.display = "none";

        //Login Attempt
        document.getElementById("login-button").addEventListener('click', function() {
            
            var loginUsername = document.getElementById("login-username").value;
            var loginPassword = document.getElementById("login-password").value;

            document.getElementById("login-username-error").style.display = "none";
            document.getElementById("login-password-error").style.display = "none";

            if(loginUsername && loginPassword)
                loginAttempt(loginUsername, loginPassword);
        });
    });
}
function loginAttempt(loginUsername, loginPassword) {
    var loginKey = hash(loginPassword);
    var urlParameters = "?username="+loginUsername+"&key="+loginKey;
    var url = hostUrl+"Messenger/server/php/login_user.php"+urlParameters;
    
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var parser = new DOMParser();
            var responseDom = parser.parseFromString(this.responseText, "text/html");
            var requestedDom = responseDom.getElementById("login");
            
            switch(requestedDom.innerText) {
                case "1":
                    successfulLogin(loginUsername, loginKey);
                    hideScreen("login");
                    showScreen("main");
                    main();
                    break;
                
                case "3":
                    document.getElementById("login-username-error").style.display = "block";
                    break;
                
                case "4":
                    document.getElementById("login-password-error").style.display = "block";
                    break;
                
                default:
                    alert("Unknown Error");
                    break;
            }
        }
    };
    xmlhttp.open("GET", url, true);
    xmlhttp.send();
}
function successfulLogin(inputUsername, inputKey) {
    console.log("ahoy"+inputUsername+" "+inputKey);
    username = inputUsername;
    key = inputKey;

    chrome.storage.sync.set({"Messenger-Login-username": inputUsername}, function() {
        chrome.storage.sync.set({"Messenger-Login-key": inputKey}, function() {});
    });
}


function addRegisterButton() {
    document.getElementById("register-screen-button").addEventListener('click', function() {
        showScreen("register");
        hideScreen("anon");

        document.getElementById("register-username-error").style.display = "none";

        //Register Attempt
        document.getElementById("register-button").addEventListener('click', function() {
            
            var registerUsername = document.getElementById("register-username").value;
            var registerPassword = document.getElementById("register-password").value;

            document.getElementById("register-username-error").style.display = "none";

            if(registerUsername && registerPassword)
                registerAttempt(registerUsername, registerPassword);
        });
    });
}
function registerAttempt(registerUsername, registerPassword) {
    var registerKey = hash(registerPassword);
    var urlParameters = "?username="+registerUsername+"&key="+registerKey;
    var url = hostUrl+"Messenger/server/php/create_user.php"+urlParameters;

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var parser = new DOMParser();
            var responseDom = parser.parseFromString(this.responseText, "text/html");
            var requestedDom = responseDom.getElementById("register");
            
            switch(requestedDom.innerText) {
                case "1":
                    successfulLogin(registerUsername, registerKey);
                    hideScreen("register");
                    hideScreen("anon");
                    showScreen("main");
                    main();
                    break;
                
                case "3":
                    document.getElementById("register-username-error").style.display = "block";
                    break;
                
                default:
                    alert("Unknown Error");
                    break;
            }
        }
    };
    xmlhttp.open("GET", url, true);
    xmlhttp.send();
}

function showScreen(elementId) {
    document.getElementById(elementId).style.display = "block";
}
function hideScreen(elementId) {
    document.getElementById(elementId).style.display = "none";
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

    var urlParameters = "?of="+username+"&key="+key;
    var url = hostUrl+"Messenger/server/php/fetch_contacts.php"+urlParameters;
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
            activateContact(contact.innerText);
        });
    });
}

function activateContact(contact) {

    currentContactOpen = contact;
    if(welcomeBoardOpen) {

        setInterval(function() {
            retrieveMessages();
        }, 350);
        welcomeBoardOpen = false;
        
        addSendMessageButton();
    }

    setTimeout(function() {
        updateContactName();
    }, 200);
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

    var urlParameters = "?for="+username+"&between="+currentContactOpen+"&key="+key;
    var url = hostUrl+"Messenger/server/php/fetch_messages.php"+urlParameters;
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



function addSendMessageButton() {

    var message = document.getElementById("new-message-text");
    var button = document.getElementById("new-message-send");

    button.addEventListener('click', function() {
        
        if(message.value) {
            
            var xmlhttp = new XMLHttpRequest();
            var urlParameters = "?message="+clean(message.value)+"&from="+username+"&to="+currentContactOpen+"&key="+key;
            var url = hostUrl+"Messenger/server/php/send_message.php"+urlParameters;

            xmlhttp.open("GET", url, true);
            xmlhttp.send();
        }
    });
}


init();