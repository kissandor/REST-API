<?php

include("connection.php");
$db = new dbObj();
$connection =  $db->getConnstring();
$request_method=$_SERVER["REQUEST_METHOD"];
//which method

switch($request_method)
{
  case 'GET':
   // GET with id
   if(!empty($_GET["id"]))
   {
    $id=intval($_GET["id"]);
    get_subjectsid($id);
   }
   else
   {
     get_subjects(); //all subjects
   }
   break;
 case 'POST':
  // Insert new subject with POST
  insert_subject();
  break;

 case 'PUT':
   // Update a subject (with id) and PUT method
   $id=intval($_GET["id"]);
   update_subject($id);
   break;
 case 'DELETE':
   //Delete a subject with ID, DELETE method
   $id=intval($_GET["id"]);
   delete_subject($id);
    
   break;
 default:
  // Invalid Request Method
    header("HTTP/1.0 405 Method Not Allowed");
    break;
} 



function get_subjects()
{
  global $connection;
  $query="SELECT * FROM subjects";
  $response=array();
  $result=mysqli_query($connection, $query);
  while($row=mysqli_fetch_assoc($result))
  {
    $response[]=$row;
  }
  header('Content-Type: application/json'); //send the header
  echo json_encode($response); //data in JSON format
}

function get_subjectsid($id=0)
{
  global $connection;
  $query="SELECT * FROM subjects";
  if($id != 0)
  {
    $query.=" WHERE id=".$id; //get subject with a given id
  }
  $response=array();
  $result=mysqli_query($connection, $query);
  while($row=mysqli_fetch_object($result))
  {
    $response[]=$row;
  }
  header('Content-Type: application/json'); //header
  echo json_encode($response); //in JSON format
}

function insert_subject()
 {
  global $connection;
   
    $data = json_decode(file_get_contents('php://input'), true); //getting data from the client
    $subject_name=$data["Subject"]; //separate them
    $teacher_name=$data["Teacher"];
    $grade=$data["Grade"];
    echo $query="INSERT INTO subjects SET Subject='".$subject_name."', Teacher='".$teacher_name."', Grade='".$grade."'";
    if(mysqli_query($connection, $query))
    {
       $response=array(
             'status' => 1,
             'status_message' =>'Subject Added Successfully.'
              );
    }
    else
    {
       $response=array(
             'status' => 0,
             'status_message' =>'Subject Addition Failed.'
             );
    }
    header('Content-Type: application/json');
    echo json_encode($response); //response with header 
}

function delete_subject($id)
{
   global $connection;
  $query="DELETE FROM subjects WHERE id=".$id;
   if(mysqli_query($connection, $query))
   {
     $response=array(
      'status' => 1,
       'status_message' =>'Subject Deleted Successfully.'
      );
   }
   else
   {
      $response=array(
         'status' => 0,
         'status_message' =>'Subject Deletion Failed.'
      );
   }
   header('Content-Type: application/json');
   echo json_encode($response);
}
                  

function update_subject($id)
 {
   global $connection;
   $post_vars = json_decode(file_get_contents("php://input"),true);
   $subject_name=$post_vars["Subject"];
   $teacher_name=$post_vars["Teacher"];
   $grade=$post_vars["Grade"];
   $query="UPDATE subjects SET Subject='".$subject_name."', Teacher='".$teacher_name."', Grade='".$grade."' WHERE id=".$id;
   if(mysqli_query($connection, $query))
   {
      $response=array(
         'status' => 1,
         'status_message' =>'Subject Updated Successfully.'
      );
    }
    else
    {
        $response=array(
            'status' => 0,
           'status_message' =>'Subject Updation Failed.'
        );
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}                  