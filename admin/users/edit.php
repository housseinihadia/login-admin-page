<?php
$error_fields=array();
// conection to database 
$conn=mysqli_connect("localhost","root","","blog");
if(! $conn){
     echo mysqli_connect_error();
     exit();
}
//select the user
//edit.php?id=1 =>$_GET['id']

$id=filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$select="SELECT * FROM 'users' WHERE 'users' . 'id' =" .$id. "LIMIT 1";
$result=mysqli_query($conn,$select);
$row=mysqli_fetch_assoc($result);

if($_SERVER['REQUEST_METHOD']=='POST'){

if(!(isset($_POST['name']) && !empty($_POST['name']))){
	$error_fields[]="name";
}
if(!(isset($_POST['mail']) && filter_input(INPUT_POST, 'mail',FILTER_VALIDATE_EMAIL))){
	$error_fields[]="mail";
}

if(!$error_fields){
	//escape any sepcial char to avoid sql injection
$name=mysqli_escape_string($conn,$_POST['name']);
$mail=mysqli_escape_string($conn,$_POST['mail']);
$password=sha1($_POST['password']);
$admin=(isset($_POST['admin'])) ? 1:0 ;
// insert
$query="UPDATE  'users' SET 'name' ='".$name."' ,'mail'='".$mail."' , 'password'='".$password."' . 'admin'=".$admin." WEHER 'users' .'id'=" .$id;
if(mysqli_query($conn,$query)){
	header("Location:list.php");
	exit;
}else{
//	echo $query;
	echo mysqli_error($conn);
}
//closed
// mysqli_free_result($result);
mysqli_close($conn);

}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Admin :: Edit user</title>
</head>
<body>
   <form  method="POST">
     
        <label for="name">Name</label>
        <input type="hidden" name="id" id="id" value="<?=isset($row['id']) ? $row['id']:''?>" />
       
       <label for="name">Name</label>
       <input type="text" name="name" id="name" value="<?=(isset($_POST['name']))? $_POST['name']:'' ?>"><?php if(in_array("name",$error_fields )) echo "*place enter your name";?> <br />

       <label for="mail">mail</label>
       <input type="mail" name="mail" id="mail" value="<?=(isset($_POST['mail']))? $_POST['mail']:'' ?>"><?php if(in_array("mail",$error_fields )) echo "*place enter your mail";?> <br />

       <label for="password">passwoed</label>
       <input type="password" name="password" id="password"/><?php if(in_array("password",$error_fields )) echo "*place enter your password not less than 6 char";?> <br />
       <input type="checkbox" name="admin" <?=(isset($_POST['admin'])) ? 'checkbox': ''?>/>Admin
       <input type="submit" name="submit" value="Add user" />
    </form>
</body>
</html>