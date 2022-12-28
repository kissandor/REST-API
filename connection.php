<?php
Class dbObj{
 /* Database connection */
  var $servername = "localhost";
  var $username = "root";
  var $password = "";
  var $dbname = "school";
  var $conn;

  function getConnstring() {
    $checkCon = new mysqli('localhost', 'root','');
    try
    {
      //$con = mysqli_connect($this->servername, $this->username, $this->password, $this->dbname) or die("Connection failed: " . mysqli_connect_error());  
        $db = mysqli_select_db($checkCon, 'school');
        $checkCon->close();
    } 
    catch(Exception $e)
    {
            $sql1="CREATE DATABASE school";
            
            $sql2 = "CREATE TABLE subjects (
                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                Subject VARCHAR(50),
                Teacher VARCHAR(125),
                Grade INT(11)
                )";
            
            $sql3="CREATE TABLE users (
                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(50),
                pword VARCHAR(50)
            )";
            
            $sql4="INSERT INTO `users`(`username`, `pword`) VALUES ('admin','12345')";
            
            $checkCon->query($sql1);
            $db = new mysqli('localhost', 'root','','school');
            $db->query($sql2);
            $db->query($sql3);
            $db->query($sql4);
            $checkCon->close();
    }
     
     $con = mysqli_connect($this->servername, $this->username, $this->password, $this->dbname) or die("Connection failed: " . mysqli_connect_error());  
        
    /* check connection */
    if (mysqli_connect_errno()) {
       printf("Connect failed: %s\n", mysqli_connect_error());
       exit();
    } else {
       $this->conn = $con;
      }
      return $this->conn;
    }
  }