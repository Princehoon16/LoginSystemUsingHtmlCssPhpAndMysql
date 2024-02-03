<?php 
$server="localhost:4306";
$username="root";
$password="";
$database="users1234";


$conn=mysqli_connect($server,$username,$password,$database);
if(!$conn){
//     echo "sucess";
// }
// else{
    die("Error".mysqli_connect_error());
}
?>