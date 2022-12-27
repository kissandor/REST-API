<?php

include("token.php");
include("connection.php");
$db = new dbObj();
$connection =  $db->getConnstring();
$request_method=$_SERVER["REQUEST_METHOD"];
//which method


switch($request_method)
{
  case 'GET':
   break;
 case 'POST':
  user_login();
  break;

 case 'PUT':
   break;
 case 'DELETE':  
   break;
 default:
  // Invalid Request Method
    header("HTTP/1.0 405 Method Not Allowed");
    break;
} 

function user_login()
 {
  global $connection;
  global $tokens;
   
    $data = json_decode(file_get_contents('php://input'), true); //getting data from the client
    $login_name=$data["name"]; //separate them
    $password=$data["password"];
    
    $query="SELECT * FROM users WHERE username='".$login_name."'and pword='".$password."'";
    
    if(mysqli_query($connection, $query))
    {
       $response=array(
             'status' => 1,
             'status_message' =>'Login Successfull.',
             'token' => $tokens[0]
              );
    }
    else
    {
       $response=array(
             'status' => 0,
             'status_message' =>'Login Failed.'
             );
    }
    header('Content-Type: application/json');
    echo json_encode($response); //response with header 
}