<?php 

header('Access-Control-Allow-Origin: *');

function isAuthorized($sender_id, $sender_password_in) {

    $salt = "2761";
    $sender_password = hash('md5', $salt.$sender_id.$salt);

    if($se)
}

function process($sender_id, $receiver_id, $message) {

    loginUser() {

    }
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

    //Receiver Parameter
    if(!empty($_GET['you'])) {

        //Message Parameter
        if(!empty($_GET['say'])) {

            //Sender Private Parameter
            if(!empty($_POST['me'])) {

                //Sender Private Parameter Match
                if(isAuthorized($_GET['me'], $_POST['me'])) {
                    
                    process($_GET['me'], $_GET['you'], $_GET['say']);

                    $code = 1;
                    $response = "Message sent";
                }
                else {
                    $code = 0;
                    $response = "Receiver Authorization failed";
                }
            }
            else {
                $code = 0;
                $response = "Receiver Password missing";
            }
            
        }
        else {
            $code = 0;
            $response = "Message missing. Use parameter 'say'";
        }
    }
    else {
        $code = 0;
        $response = "Receiver Address missing. Use parameter 'you'";
    }
}
else {
    $code = 0;
    $response = "Sender Address missing. Use parameter 'me'";
}


echo json_encode(array( 'code' => $code, 'response' => $response ));


?>