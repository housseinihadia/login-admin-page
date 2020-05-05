<?php

// we will use it for storing the singed in user data

  session_start();
  if($_SERVER['REQUEST_METHOD']=='POST'){
  	//conect database
  	$conn=mysqli_connect("localhost","root","","blog");
  	if(!$conn){
  		echo mysqli_connect_error();
  		exit;
  	}
  	//ESCAPE ANY sepcial char to avoid sql injection
  $mail=mysqli_escape_string($conn,$_POST['mail']);
  $password=sha1($_POST['password']);

  //sha1 collison http://security.googleblog.com/2017/02/annoucing.first.sha1.collision.html
  //password_hash($password ,PASSWORD_DEFAULT);
  // then check with password_verify()
  //the password column in db should be changed th char(60) if

  //select
  $query="SELECT * FROM 'users' WHERE 'mail' = '".$mail."' and 'password' = '".$password."' LIMIT 1 ";
  }
  $result=mysqli_query($conn,$query);
  if($row=mysqli_fetch_assoc($result)){
  	$_SESSION['id']=$row['id'];
  	$_SESSION['mail']=$row['mail'];
  	header("Location:admin/users/list.php");
  	exit;
  }else{
  	$error="invalid mail or password ";
  }
  //colse the connection
//mysqli_free_result($result);
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
</head>
<body>
 <?php if(isset($error))echo $error; ?>
  <form method="POST">
  	<label for='mail'>MAIL</label>
    <input type="mail" name="mail" id="mail" value="<?=(isset($_POST['mail']))? $_POST['mail']:''?>"/><br/>
    <label for='password'>Password</label>
    <input type="password" name="password" id="password"/><br />
    <input type="submit" name="submit" value="Login"/>
  </form>
</body>
</html>