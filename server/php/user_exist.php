<?php 
/*

Parameters: 

username


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



//User-Specific Tools
function userExist($user_id) {
    global $user_list_directory;

    $user_list = getArrayFromJson($user_list_directory);
    if(in_array($user_id, $user_list))
        return True;
    else
        return False;
}



//Status Handling
$code = array(-1, -1);
$response = array(
    0 => array(
        0 => "Search Successful. Username found",
        1 => "No problems occured"
    ),

    1 => array(
        0 => "Parameter Error, Search Unsuccessful",
        1 => "Username missing. Use parameter 'username'"
    ),
    2 => array(
        0 => "Existence Error, Search Unsuccessful",
        1 => "Username does not exist. Please verify"
    )
);


//Username Parameter
if(!empty($_GET['username'])) {

    //Username exists
    if(userExist($_GET['username'])) {

        $code = array(0, 1);
    }
    else {
        $code = array(2, 1);
    }  
}
else {
    $code = array(1, 1);
}

echo '<div id="user-exist">'.($code[0] + $code[1]).'</div>';
echo $response[$code[0]][0]." > ".$response[$code[0]][$code[1]];


?>