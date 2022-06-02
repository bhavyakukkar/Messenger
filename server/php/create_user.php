<?php 
/*

Parameters: 

username
password


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

function hashPassword($password) {
    global $salt;

    return hash('md5', $salt.$password.$salt);
}



function createUser($user_id, $password) {
    global $messaging_directory;

    //Make user directory
    $path = $messaging_directory.$user_id;
    mkdir($path);

    //Make Password File
    $path = $messaging_directory.$user_id."/password.json";
    setArrayToJson(array(hashPassword(hashPassword($password))), $path);

    //Make Notifications File
    $path = $messaging_directory.$user_id."/notifications.json";
    setArrayToJson(array(), $path);

    //Make Chats Directory
    $path = $messaging_directory.$user_id."/chats";
    mkdir($path);
}

function addUserToUserList($user_id) {
    global $user_list_directory;

    $user_list = getArrayFromJson($user_list_directory);
    array_push($user_list, $user_id);

    setArrayToJson($user_list, $user_list_directory);
}




$code = array(-1, -1);
$response = array(
    0 => array(
        0 => "User Successfully Created",
        1 => "No problems occured."
    ),

    1 => array(
        0 => "Parameter Error, User not Created",
        1 => "Username missing. Use parameter 'username'",
        2 => "Password missing. Use parameter 'password'"
    ),
    2 => array(
        0 => "Existence Error, User not Created",
        1 => "Username already exists. Please try another username"
    ),

    //Todo: Implement Authorization
    3 => array (
        0 => "Authorization Error, User not Created"
    )
);


//Username Parameter
if(!empty($_GET['username'])) {

    //Password Parameter
    if(!empty($_GET['password'])) {

        //Username doesn't already exist
        if(!userExist($_GET['username'])) {

            createUser($_GET['username'], $_GET['password']);
            addUserToUserList($_GET['username']);
            $code = array(0, 1);
        }
        else {
            $code = array(2, 1);
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