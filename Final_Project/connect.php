<?php 

/*
*** Database connectivity ***
Username: root
Password: rush
Db_Name: chatsystem
*/

$con=mysqli_connect("localhost","root","rush","chatsystem");

if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

 ?>