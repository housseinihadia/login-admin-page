<?php
//check for errors
$errors_arr=array();
if(isset($_GET['error_fields'])){
	$errors_arr=explode(".", $_GET['error_fields']);
}
?>



<!DOCTYPE html>
<html>
<head>
	<title>form element</title>
</head>
<body>
	<!--
      method   ==>  POST
                    send data to be processed
                     GET
                     requists data form resource
	-->
    <form  method="POST" action="conn.php" >
     
       <label for="name">Name</label>
       <input type="text" name="name" id="name"/><?php if(in_array("name",$errors_arr )) echo "*place enter your name";?> <br />

       <label for="mail">mail</label>
       <input type="mail" name="mail" id="mail"/><?php if(in_array("mail",$errors_arr )) echo "*place enter your mail";?> <br />

       <label for="password">passwoed</label>
       <input type="password" name="password" id="password"/><?php if(in_array("password",$errors_arr )) echo "*place enter your password not less than 6 char";?> <br />
 
       <label for="gender">Gender</label>
       <input type="radio" name="radio"  value="male"/> male
       <input type="radio" name="radio"  value="female"/>female </br>
       <input type="submit" name="submit" value="register" />
    </form>
</body>
</html>