<?php
//validation 
$error_fields=array();
if(!(isset($_POST['name']) && !empty($_POST['name']))){
	$error_fields[]="name";
}
if(!(isset($_POST['mail']) && filter_input(INPUT_POST, 'mail',FILTER_VALIDATE_EMAIL))){
	$error_fields[]="mail";
}
if(!(isset($_POST['password']) && strlen($_POST['password'])>5)){
	$error_fields[]="password";
}
if($error_fields){
	header("Location: form.php?error_fields".implode(".",$error_fields));
	exit;
}
//open conection 
$conn=mysqli_connect("localhost","root","","blog");
if(! $conn){
     echo mysqli_connect_error();
     exit();
}

//do the opration (select,insert....)
/*$query="SELECT * FROM users";
$result=mysqli_query($conn,$query);
while ($row=mysqli_fetch_assoc($result)) {
	echo "Id :".$row['id']."<br/>";
	echo "Name :".$row['name']."<br/>";
	echo "mail :".$row['mail']."<br/>";
	echo str_repeat(".", 50)."
	<br />";
}*/
//escape any sepcial char to avoid sql injection
$name=mysqli_escape_string($conn,$_POST['name']);
$mail=mysqli_escape_string($conn,$_POST['mail']);
$password=mysqli_escape_string($conn,$_POST['password']);
// insert
$query="INSERT INTO 'users' ('name','mail','password') VALUES ('".$name."','".$mail."','".$password."')";
if(mysqli_query($conn,$query)){
	echo "thank you your information has been seved";
}else{
	echo $query;
	echo mysqli_error($conn);
}
//closed
// mysqli_free_result($result);
mysqli_close($conn);
