<?php
//validation 
$error_fields=array();
if($_SERVER['REQUEST_METHOD']=='POST'){

if(!(isset($_POST['name']) && !empty($_POST['name']))){
	$error_fields[]="name";
}
if(!(isset($_POST['mail']) && filter_input(INPUT_POST, 'mail',FILTER_VALIDATE_EMAIL))){
	$error_fields[]="mail";
}
if(!(isset($_POST['password']) && strlen($_POST['password'])>5)){
	$error_fields[]="password";
}
if(!$error_fields){
	
//open conection 
$conn=mysqli_connect("localhost","root","","blog");
if(! $conn){
     echo mysqli_connect_error();
     exit();
}

//escape any sepcial char to avoid sql injection
$name=mysqli_escape_string($conn,$_POST['name']);
$mail=mysqli_escape_string($conn,$_POST['mail']);
$password=sha1($_POST['password']);
$admin=(isset($_POST['admin'])) ? 1:0 ;

//uplode
$uploads_dir=$_SERVER['DOCUMENT_ROOT'].'/uploads';
$avatar='';
if($_FILES['avatar']['error']==UPLOAD_ERR_OK){
	$tmp_name=$_FILES["avatar"]["tmp_name"];
	$avatar=basename($_FILES["avatar"]["name"]);
	move_uploaded_file($tmp_name,"$uploads_dir/$name.$avatar");
}else{
	echo "file cant be uploaded";
	exit;
}
// insert
$query="INSERT INTO 'users' ('name','mail','password','admin') VALUES (".$name.",".$mail.",".$password.",".$admin.")";
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
	<title>Admin :: add user</title>
</head>
<body>
   <form  method="POST" enctype="multipart/form.data" >
     
       <label for="name">Name</label>
       <input type="text" name="name" id="name" value="<?=(isset($_POST['name']))? $_POST['name']:'' ?>"><?php if(in_array("name",$error_fields )) echo "*place enter your name";?> <br />

       <label for="mail">mail</label>
       <input type="mail" name="mail" id="mail" value="<?=(isset($_POST['mail']))? $_POST['mail']:'' ?>"><?php if(in_array("mail",$error_fields )) echo "*place enter your mail";?> <br />

       <label for="password">passwoed</label>
       <input type="password" name="password" id="password"/><?php if(in_array("password",$error_fields )) echo "*place enter your password not less than 6 char";?> <br />
       <input type="checkbox" name="admin" <?=(isset($_POST['admin'])) ? 'checkbox': ''?>/>Admin
       <br/>
       <label for="avatar">Avatar</label>
       <input type="file" name="avatar" id="avatar">
       <br />
       <input type="submit" name="submit" value="Add user" />
    </form>
</body>
</html>


