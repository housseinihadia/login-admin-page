<?php
require '../models/userclass.php';
session_start();
if(isset($_SESSION['id'])){
	echo '<p> welcome' .$_SESSION['mail'] . '<a href="/logout.php">Logout</a></p>';
}else{
	header("Location:/login.php");
	exit;
}
$user =new user();
$users= $user->getUsers();





//search to name or mail
if(isset($_GET['search'])){
	$users=$user->searchUsers($_GET['search']);
	//$search=mysqli_escape_string($conn,$_GET['search']);
	//$query.= " WHERE 'users'.'name' LIKE '%".$search ."%' OR 'users' . 'mail' LIKE '%" .$search ."%' ";
}
$conn=mysqli_connect("localhost","root","","blog");
if(! $conn){
	echo mysqli_connect_error();
	exit;
}

 //select all users
$query="SELECT * FROM  users ";

$result=mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
	<title> Admin :: list users</title>
</head>
<body>
  <h1>List users</h1>
  <form method="GET">
  	<input type="text" name="search" placeholder="Enter {name} or {mail} to search">
  	<input type="submit" value="search">
  </form>
  <table>
  	<thead>
  		<tr>
  			<th>Id</th>
  			<th>Name</th>
  			<th>Mail</th>
  			<th>Admin</th>
  			<th>Actions</th>
  		</tr>
  	</thead>
<?php 
// loop on the rowset 
     foreach ($users as $row) {
     	
     
     //while ($row=mysqli_fetch_assoc($result)){
?>   
   <tr>
   	   <td><?=$row['id']?></td>
       <td><?=$row['name']?></td>
       <td><?=$row['mail']?></td> 
       <td><?=$row['admin']? 'Yes':'No'?></td>
       <td><a href="edit.php?id=<?=$row['id']?>">Edit</a> | <a href="delet.php?id=<?=$row['id']?>">Delet</a></td> 
   </tr>
   <?php 
        }
    ?>
   <tfoot>
   	  <tr>
   	  	<td colspan="2" style="text-align: center"><?= count($users)?>users</a></td>
   	  	<td colspan="3" style="text-align:center "><a href="add.php">Add user</a></td>
   	  </tr>
   </tfoot>

  </table>
</body>
</html>
<?php
//mysqli_free_result($result);
mysqli_close($conn);