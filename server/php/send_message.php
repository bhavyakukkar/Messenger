<?php 
/*

- folder for every user
- every user has folders for every contact who messages them
- each of these folders has a portal.json, where received message is indicated by portal['new'] - true, and user client updates it to false once user clicks on messages

*/
header('Access-Control-Allow-Origin: *');

$data_directory = "../../database/";
$salt = "2761";


function getArrayFromJson($path) {

    return json_decode(file_get_contents($path), true);
}

function setArrayToJson($array, $path) {

    file_put_contents($path, json_encode($array));
}


function loginUser($user_id) {
    global $data_directory, $salt;

    $user_hash = hash('md5', $salt.$user_id.$salt);
    $user_directory_name = "u-".$user_hash;

    $path = $data_directory.$user_directory_name;
    if(!file_exists($path)) {
        mkdir($path);
    }
    
    return $user_directory_name."/";
}


function loginContact($user_key, $contact_id) {
    global $data_directory, $salt;

    //$contact_hash = hash('md5', $salt.$user_id.$salt);
    $contact_hash = $contact_id;
    $contact_file_name = $contact_hash.".json";

    $path = $data_directory.$user_key.$contact_file_name;
    
    return $user_key.$contact_file_name;
}


function addMessage($contact_key, $message) {
    global $data_directory;

    $path = $data_directory.$contact_key;
    $existing_chat = getArrayFromJson($path);

    $existing_chat_length = count($existing_chat);
    $id = $existing_chat_length;
    
    $updated_chat = $existing_chat;
    $updated_chat[$id] = Array (
        "ID" => strval($id + 1),
        "message" => $message
    );
    setArrayToJson($updated_chat, $path);
}


function addNotification($user_key, $contact_id) {
    global $data_directory;

    $path = $data_directory.$user_key."notifications.json";
    $existing_notifications = getArrayFromJson($path);

    $existing_notifications_length = count($existing_notifications);
    $id = $existing_notifications_length;
    
    $updated_notifications = $existing_notifications;
    $updated_notifications[$id] = Array(
        "ID" => strval($id + 1),
        "contact" => $contact_id
    );
    setArrayToJson($updated_notifications, $path);
}


function sendMessage($sender_id, $receiver_id, $message) {

    addMessage(
        loginContact(
            loginUser($receiver_id),
            $sender_id
        ),
        $message
    );

    addNotification(
        loginUser($receiver_id),
        $sender_id
    );
}


$code = 0;
$response = "";


//Sender Parameter
if(!empty($_GET['me'])) {

    //Receiver Parameter
    if(!empty($_GET['you'])) {

        //Message Parameter
        if(!empty($_GET['say'])) {

            sendMessage($_GET['me'], $_GET['you'], $_GET['say']);

            $code = 1;
            $response = "Message sent";
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