<?php
// conection to database 
$conn=mysqli_connect("localhost","root","","blog");
if(! $conn){
     echo mysqli_connect_error();
     exit();
 }
 // select user
 $id=filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
 $query="DELETE FROM 'users' WHERE 'users'.'id'=".$id."LIMIT 1";
 if(mysqli_query($conn,$query)){
 	header("Location:list.php");
 	exit;

 }else{
 	echo mysqli_error($conn);
 }
 //close the connect
 mysqli_close($conn);