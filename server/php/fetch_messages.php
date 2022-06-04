<?php 
/*

Parameters:

for: requestee who is requesting message retrieval
between: contact whose conversation with requestee is being retrieved
key: requestee password


*/
header('Access-Control-Allow-Origin: *');

//Global Addresses
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


$code = array(-1, -1);
$response = array(
    0 => array(
        0 => "Messages successfully Retrieved",
        1 => "No problems occured"
    ),

    1 => array(
        0 => "Parameter Error, Messages not Retrieved",
        1 => "Requestee Address missing. Use parameter 'for'",
        2 => "Contact Address missing. Use parameter 'between'",
        3 => "Password Key missing. Use parameter 'key'"
    ),
    2 => array(
        0 => "Existence Error, Messages not Retrieved",
        1 => "Requestee Address does not exist. Please create new account",
        2 => "Contact Address does not exist. Please verify address",
        3 => "Password Key does not match. Please authorize yourself"
    )
);


function fetchMessages() {
    
    $contact_list = 
}


//Requestee Parameter
if(!empty($_GET['for'])) {

    //Contact Parameter
    if(!empty($_GET['between'])) {

        //Requestee Password Key Parameter
        if(!empty($_GET['key'])) {

            //Requestee Exist
            if(userExist($_GET['for'])) {

                //Contact Exist
                if(userExist($_GET['between'])) {

                    //Requestee Password Key Match
                    if(passwordMatch($_GET['for'], $_GET['key'])) {

                        fetchMessages($_GET['for'], $_GET['between'], $_GET['key']);
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