<?php
/**
var_dump($_POST);
echo "<br>";
echo $_POST['username'];**/
if(isset($_POST['email']) && !empty($_POST['email'])){
	echo $_POST['email'];
}else{
	echo " plase enter your email";
}