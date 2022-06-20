<?php 
/*

Parameters: 

username
key


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
function hashPassword($password) {
    global $salt;

    return hash('md5', $salt.$password.$salt);
}



//Status Handling
$code = array(-1, -1);
$response = array(
    0 => array(
        0 => "Log-in Successful",
        1 => "No problems occured"
    ),

    1 => array(
        0 => "Parameter Error, Log-in Unsuccessful",
        1 => "Username missing. Use parameter 'username'",
        2 => "Password Key missing. Use parameter 'key'"
    ),
    2 => array(
        0 => "Existence Error, User not Created",
        1 => "Username does not exist. Please create new account",
        2 => "Password Key does not match. Please authorize yourself"
    )
);


//Username Parameter
if(!empty($_GET['username'])) {

    //Password Parameter
    if(!empty($_GET['key'])) {

        //Username exists
        if(userExist($_GET['username'])) {

            //Password Key Match
            if(passwordMatch($_GET['username'], $_GET['key']))
                $code = array(0, 1);
            else
                $code = array(2, 2);
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

echo '<div id="login">'.($code[0] + $code[1]).'</div>';
echo $response[$code[0]][0]." > ".$response[$code[0]][$code[1]];


?>