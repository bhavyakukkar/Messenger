<?php 
/*

- folder for every user
- every user has folders for every contact who messages them
- each of these folders has a portal.json, where received message is indicated by portal['new'] - true, and user client updates it to false once user clicks on messages

*/
header('Access-Control-Allow-Origin: *');

$data_directory = "../../database/";


function getPassword($user_id) {
    global $data_directory;

    $path = $data_directory.$user_id."/password.json";
    $password_json = file_get_contents($path);
    $password = json_decode($existing_json, true)[0];
}

function isMatchPassword($sender_id, $sender_password_in) {

    $salt = "2761";
    $sender_password = hash('md5', $salt.$sender_id.$salt);
}

function sendMessage($sender_id, $receiver_id, $message) {

    
}

function loginUser() {

}

function loginContact() {

}

function 




$code = 0;
$response = "";


//Sender Parameter
if(!empty($_GET['me'])) {

    //Sender Account Existence
    if(isExistent($_GET['me'])) {

        //Receiver Parameter
        if(!empty($_GET['you'])) {

            //Receiver Account Existence
            if(isExistent($_GET['you'])) {

                //Message Parameter
                if(!empty($_GET['say'])) {

                    //Sender Password
                    if(!empty($_POST['me'])) {

                        //Sender Password Match
                        if(isMatchPassword($_GET['me'], $_POST['me'])) {
                            
                            sendMessage($_GET['me'], $_GET['you'], $_GET['say']);

                            $code = 1;
                            $response = "Message sent";
                        }
                        else {
                            $code = 0;
                            $response = "Receiver Authorization failed";
                        }
                    }
                    else {
                        $code = 2;
                        $response = "Error: Receiver Password missing, message request from illegal source";
                    }
                    
                }
                else {
                    $code = 0;
                    $response = "Message missing. Use parameter 'say'";
                }
            }
            else {
                $code = 0;
                $response = "Receiver Address not found";
            }
        }
        else {
            $code = 0;
            $response = "Receiver Address missing. Use parameter 'you'";
        }
    }
    else {
        $code = 0;
        $response = "Sender Address not found. Please register or login before sending messages";
    }
}
else {
    $code = 0;
    $response = "Sender Address missing. Use parameter 'me'";
}


echo json_encode(array( 'code' => $code, 'response' => $response ));


?>