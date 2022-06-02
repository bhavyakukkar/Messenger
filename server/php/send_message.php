<?php 
/*

Parameters: 

me: sender id
you: received id
say: message


*/
header('Access-Control-Allow-Origin: *');

$messaging_directory = "../../database/messaging/";
$user_list_directory = "../../database/user-list.json";

$salt = "1940261";


function getArrayFromJson($path) {

    return json_decode(file_get_contents($path), true);
}

function setArrayToJson($array, $path) {

    file_put_contents($path, json_encode($array));
}


function userExist($user_id) {
    global $user_list_directory;

    $user_list = getArrayFromJson($user_list_directory);
    if(in_array($user_id, $user_list))
        return True;
    else
        return False;
}

function passwordMatch($user_id, $key) {
    global $salt, $messaging_directory;

    $user_key = loginUser($user_id);
    $path = $messaging_directory.$user_key."password.json";

    $server_key = getArrayFromJson($path)[0];
    if(hash('md5', $salt.$key.$salt) == $server_key)
        return True;
    else
        return False;
}


function loginUser($user_id) {
    global $messaging_directory, $salt;

    $user_hash = $user_id;
    //$user_hash = hash('md5', $salt.$user_id.$salt);

    $user_directory_name = $user_hash;

    $path = $messaging_directory.$user_directory_name;
    
    return $user_directory_name."/";
}


function loginContact($user_key, $contact_id) {
    global $messaging_directory, $salt;

    //$contact_hash = hash('md5', $salt.$user_id.$salt);
    $contact_hash = $contact_id;
    $contact_file_name = $contact_hash.".json";

    $path = $messaging_directory.$user_key."chats/".$contact_file_name;

    //Scope to implement Friend Requests, right now creates chat triggered by first ever message
    //First Interaction Ever
    if(!file_exists($path)) {

        $fp = fopen($path, 'w');
        fwrite($fp, json_encode(array()));
        fclose($fp);
    }
    
    return $user_key."chats/".$contact_file_name;
}


function addMessage($contact_key, $message) {
    global $messaging_directory;

    $path = $messaging_directory.$contact_key;
    $existing_chat = getArrayFromJson($path);

    //Scope to implement Friend Requests, right now creates chat triggered by first ever message
    //First Message Ever
    /*if(!$existing_chat)
        $existing_chat_length = 0;
    //Not First Message Ever
    else
        $existing_chat_length = count($existing_chat);*/
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
    global $messaging_directory;

    $path = $messaging_directory.$user_key."notifications.json";
    $existing_notifications = getArrayFromJson($path);
    $existing_notifications_length = count($existing_notifications);

    if(newNotification($existing_notifications, $contact_id)) {

        $id = $existing_notifications_length;
    
        $updated_notifications = $existing_notifications;
        $updated_notifications[$id] = Array(
            "ID" => strval($id + 1),
            "contact_id" => $contact_id
        );
        setArrayToJson($updated_notifications, $path);
    }
}


//Check if Notification already there
function newNotification($notifications, $contact_id) {
    for($i = 0; $i < count($notifications); $i++) {
        if($notifications[$i]["contact_id"] == $contact_id)
            return False;
    }
    return True;
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


$code = array(-1, -1);
$response = array(
    0 => array(
        0 => "Message Successfully Delivered",
        1 => "No problems occured."
    ),

    1 => array(
        0 => "Parameter Error, Message not Delivered",
        1 => "Sender Address missing. Use parameter 'me'",
        2 => "Receiver Address missing. Use parameter 'you'",
        3 => "Message missing. Use parameter 'say'",
        4 => "Sender Password Key missing. Retry sending message"
    ),
    2 => array(
        0 => "Existence Error, Message not Delivered",
        1 => "Sender Address does not exist. Please create new account",
        2 => "Receiver Address does not exist. Please verify address",
        3 => "Sender Password Key does not match. Please authorize yourself"
    ),

    //Todo: Implement Authorization
    3 => array (
        0 => "Authorization Error, Message not Delivered"
    )
);


//Sender Parameter
if(!empty($_GET['me'])) {

    //Receiver Parameter
    if(!empty($_GET['you'])) {

        //Message Parameter
        if(!empty($_GET['say'])) {
            
            //Sender Password Key Parameter
            if(!empty($_GET['key'])) {

                //Sender Exist
                if(userExist($_GET['me'])) {

                    //Receiver Exist
                    if(userExist($_GET['you'])) {

                        //Sender Password Key Match
                        if(passwordMatch($_GET['me'], $_GET['key'])) {
                            
                            sendMessage($_GET['me'], $_GET['you'], $_GET['say']);
                            $code = array(0, 1);
                        }
                        else {
                            $code = array(2, 3);
                        }
                    }
                    else {
                        $code = array(2, 2);
                    }
                }
                else {
                    $code = array(2, 1);
                }
            }
            else {
                $code = array(1, 4);
            }
        }
        else {
            $code = array(1, 3);
        }
    }
    else {
        $code = array(1, 2);
    }
}
else {
    $code = array(1, 1);
}



echo $response[$code[0]][0]." > ".$response[$code[0]][$code[1]];

?>