<?php
/*

Parameters: 

of: requetsee whose contacts are being retrieved
key: requestee password


*/
/*

Comments:

- 


*/
header('Access-Control-Allow-Origin: *');

//Global Addresses
$messaging_directory = "../../database/messaging/";
$user_list_directory = "../../database/user-list.json";

$salt = "1940261";



//Getter and Setters for Database Access
function getArrayFromJson($path) {

    return json_decode(file_get_contents($path), true);
}

function setArrayToJson($array, $path) {

    file_put_contents($path, json_encode($array));
}



//Login Tools
function loginUser($user_id) {
    global $messaging_directory, $salt;

    $user_hash = $user_id;
    //$user_hash = hash('md5', $salt.$user_id.$salt);

    $user_directory_name = $user_hash;

    $path = $messaging_directory.$user_directory_name;
    
    return $user_directory_name."/";
}



//User-Specific Tools
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



//Script-specific Tools
function outputContacts($contacts) {

    echo "<div id='contacts-list'>";
    for($i = 0; $i < count($contacts); $i++) {
        $contact_id = $contacts[$i];
        echo '<div class="contact">'.$contact_id.'</div>';
    }
    echo "</div>";
}



//Main Method
function fetchContacts($requestee_id) {
    global $messaging_directory;

    $requestee_key = loginUser($requestee_id);
    $path = $messaging_directory.$requestee_key."contacts.json";
    $contacts = getArrayFromJson($path);

    outputContacts($contacts);
}



//Status Handling
$code = array(-1, -1);
$response = array(
    0 => array(
        0 => "Contacts successfully Retrieved",
        1 => "No problems occured"
    ),

    1 => array(
        0 => "Parameter Error, Contacts not Retrieved",
        1 => "Requestee Address missing. Use parameter 'of'",
        2 => "Password Key missing. Use parameter 'key'"
    ),
    2 => array(
        0 => "Existence Error, Contacts not Retrieved",
        1 => "Requestee Address does not exist. Please create new account",
        2 => "Password Key does not match. Please authorize yourself"
    )
);


//Requestee Parameter
if(!empty($_GET['of'])) {

    //Requestee Password Key Parameter
    if(!empty($_GET['key'])) {

        //Requestee Exist
        if(userExist($_GET['of'])) {

            //Requestee Password Key Match
            if(passwordMatch($_GET['of'], $_GET['key'])) {

                fetchContacts($_GET['of']);
                $code = array(0, 1);
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
        $code = array(1, 2);
    }
}
else {
    $code = array(1, 1);
}


echo $response[$code[0]][0]." > ".$response[$code[0]][$code[1]];


?>