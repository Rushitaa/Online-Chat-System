<style type='text/css'>

body 
{
background: url(images/bg.png);
}

h1
{
color: orange ;
font-family: 'Trocchi', 
serif; 
font-size: 45px;
font-weight: normal;
line-height: 48px; 
margin-top:50px; 
text-align: center;
}

#table 
{ 
color: #333;
font-family: Helvetica, Arial, sans-serif;
width: 500px; 
border-collapse: collapse; 
border-spacing: 0;
}

#table1 
{ 
color: #333;
font-family: Helvetica, Arial, sans-serif;
width: 500px; 
border-collapse: collapse; 
border-spacing: 0;
}

td, th 
{ 
border: 1px solid transparent; 
height: 30px; 
transition: all 0.3s;  
}

th
{
background: #DFDFDF;  /* Darken header a bit */
font-weight: bold;
}

td 
{
background: #FAFAFA;
text-align: center;
}

.firstFrame
{
margin-left: 20px;
width: 1300px;
float:left;
z-index:1;
position:absolute;
top:200px;
left:0;
}

.sub1
{
width: 785px;
height: 230px;
max-width:785px;
max-height:230px;
z-index:2;
position:absolute;
top:5px;
left:100px;
}

.sub2
{
width: 500px;
height: 230px;
max-width:500px;
max-height:230px;
z-index:3;
position:absolute;
top:5px;
left:700px;
float:right;
}

#logoutBtn
{
float:right;
margin-right: 130px;
border-radius:10px;
width:150px; 
height:30px; 
background:light-grey; 
font-weight:bold; 
font-size:20px;
text-align: center;
}

#button
{
border-radius:10px;
width:150px; 
height:30px; 
background:light-grey; 
font-weight:bold; 
font-size:20px;
text-align: center;
}

#addFriendButton
{
border-radius:10px;
width:150px; 
height:30px; 
background:light-grey; 
font-weight:bold; 
font-size:20px;
text-align: center;
margin-top: 7px;
margin-bottom: -7px;
}


#friendButton
{
border:1px solid transparent;
width:150px; 
height:30px; 
background:white; 
font-weight:bold; 
font-size:20px;
text-align: center;
margin-top:7px;
margin-bottom: -7px;
}

#deletefriend
{
border:1px solid transparent;
background:white; 
margin-top:10px;
}


#btn
{
border-radius:10px;
width:400px; 
height:30px; 
background:light-grey; 
font-weight:bold; 
font-size:20px;
margin-left: 500px;
text-align: center;
}

/* Cells in even rows (2,4,6...) are one color */ 
tr:nth-child(even) td 
{ 
background: #F1F1F1;
}   

/* Cells in odd rows (1,3,5...) are another (excludes header cells)  */ 
tr:nth-child(odd) td 
{ 
background: #FEFEFE; 
}  

/* Hover cell effect! */
tr td:hover 
{ 
background: #666; 
color: #FFF; 
} 

</style>



<?php 
//Beginning of PHP code
/*

PHP code with the following functionalities:
1. Sign in existing user
2. Sign Up new user
3. Logout current user
4. Add new friends
5. Delete existing friends
6. Display existing friends
7. Click on friend name to begin chat

*/
include('connect.php');
$flag = 0;

function SignIn()
{  

    global $con;

    session_start(); //starting the session for user profile page 

    $checkLogin = mysqli_query($con,"SELECT * FROM login");
    $res = mysqli_fetch_array($checkLogin);

 	  if(!empty($_POST['user']) && $_POST['user']!= $res['loginName']) //checking the 'user' name which is from Sign-In.html, is it empty or have some text 
 	 { 
     $insertLogin = mysqli_query($con,"INSERT INTO login(loginName) VALUES ('$_POST[user]')");

      $query = mysqli_query($con,"SELECT * FROM UserName where userName = '$_POST[user]' AND pass = '$_POST[pass]'");//or die(mysqli_connect_error()); 
      $row = mysqli_fetch_array($query);
 	    if(!empty($row['userName']) AND !empty($row['pass'])) 
 	    { 
 	 	    $_SESSION['userName'] = $row['userName']; 
 	 	    DisplayFriends();
      } 
 	    else
      { echo "<script>
        alert('WRONG CREDENTIALS..Try Again!');
        window.location.href='Sign-In.html';
        </script>"; 
 	    }
 	}

    else
   {
      echo "<script>
      alert('User already logged in..Try Again!');
      window.location.href='Sign-In.html';
      </script>";
   } 

}


function NewUser() 
{ 
     global $con;
     $userName =  $_POST['user'];  
     $password = $_POST['pass']; 
     $query = "INSERT INTO UserName(userName,pass) VALUES ('$userName','$password')"; 
     $data = mysqli_query ($con,$query); 

     if($data) 
     { 
     	  echo "<script>
        alert('SUCCESS! YOUR REGISTRATION IS COMPLETED..');
        window.location.href='Sign-In.html';
        </script>";
     }
} 


function SignUp() 
{ 
    global $con;
   	session_start();

    if(!empty($_POST['user'])) 

    { 
      $query = mysqli_query($con,"SELECT * FROM UserName WHERE userName = '$_POST[user]' AND pass = '$_POST[pass]'"); 

      if(!$row = mysqli_fetch_array($query))
 	    { 
 		    NewUser();
      } 
      else 
 	    { 
     		echo "<script>
        alert('USER ALREADY EXISTS..TRY AGAIN!');
        window.location.href='Sign-Up.html';
        </script>";
    	}
    } 
}


function DisplayFriends()
{ 
	  global $con;
    $sql = "SELECT friend FROM FriendList where user = '$_POST[user]' ORDER BY friend ASC";
    $result = mysqli_query($con,$sql);

    echo"<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js'></script>
    <script type='text/javascript'>
    jQuery(document).ready(function($) {
       $('.clickable-row').click(function() {
           window.document.location = $(this).data('href');
       });
    });
    </script>";
    echo "<body>";
    echo "<h1>Welcome ".$_SESSION['userName'] ."!!</h1>";
    echo "<form method='post' action='connectivity.php'>
          <input id='logoutBtn' name='submit' type='submit' value='Logout' >
          </form>";
    echo "<div class = 'firstframe'>";
    echo "<div class = 'sub1'>";
    echo "<table id ='table'>";
    echo "<tr><th colspan='2'>My Friend List</th></tr>";

    while($row = mysqli_fetch_array($result))
    {
      $name = $row['friend'];
  

      echo "<tr>
            <td style='width: 200px;'><form method='post' action='connectivity.php?name=".$name."'>
            <input id='friendButton' name='chatbox' type='submit' value=".$name." >
            </form></td>
            <td style='width: 200px;'><form method='post' action='connectivity.php?friend=".$name."'>
            <button id='deletefriend' type='submit' name='submit' value='delete'><img src='images/delete.png' alt='delete'></button>
            </form></td>
            </tr>";
    } 
      echo "</table>";
      echo "</div>";

      $sql1 = "SELECT username FROM UserName WHERE username != '$_POST[user]' ORDER BY username ASC";
      $result = mysqli_query($con,$sql1);

      echo "<div class = 'sub2'>";
      echo "<table id = 'table1'>";
      echo "<tr><th colspan='2'>Make New Friends</th></tr>";

    while($row = mysqli_fetch_array($result))
    {
  
      $user1 = $row['username'];
 
 

      echo "<tr><td style='width: 200px;'>".$user1."</td>
            <td style='width: 200px;'><form method='post' action='connectivity.php?user=".$user1."'>
            <input id='addFriendButton' name='submit' type='submit' value='Add Friend' >
            </form></td></tr>";

 
    } 
      echo "</table>";
      echo "</div>";
      echo "</div>";
      echo "</body>";

}

function AddFriends()
{ 
    session_start();
    $a = $_SESSION['userName'];
    $user = $_GET['user'];

    global $con;
    global $flag;

    $sql1 = "SELECT friend FROM FriendList where user = '$a'";
    $result1 = mysqli_query($con,$sql1);

    while($row = mysqli_fetch_array($result1))
    {
        $friend = $row['friend'];
        if($user == $friend)
          { $flag = 1;
          }
    }

    if($flag == 1)
    {
        $deleteLogin = mysqli_query($con,"DELETE FROM login WHERE loginName = '$a'");
        echo "<h1>"."Already an Existing Friend.". "</h1>";

        echo "<form method='post' action='Sign-In.html'>
        <input id = btn name='submit' type='submit' value='Sign-In To Verify Your Idendity'>
        </form>";
    }
    else
    {
        $sql = "INSERT INTO FriendList(user,friend) VALUES ('$a','$user')";
        $sql1 = "INSERT INTO FriendList(user,friend) VALUES ('$user','$a')";
        $result = mysqli_query($con,$sql);
        $result1 = mysqli_query($con,$sql1);
        $deleteLogin = mysqli_query($con,"DELETE FROM login WHERE loginName = '$a'");
        echo "<h1>"."Awesome!! New Friend Added Successfully.". "</h1>"; 
        echo "<form method='post' action='Sign-In.html'>
            <input id = btn name='submit' type='submit' value='Sign-In Again To Access New Friend List'>
           </form>";
    }
  
}

function DeleteFriend()
{ 
    session_start();
    $user = $_SESSION['userName'];
    $friend = $_GET['friend'];
    global $con;
    $sql = "DELETE FROM FriendList WHERE user = '$user' AND friend = '$friend'";
    $sql1 = "DELETE FROM FriendList WHERE user = '$friend' AND friend = '$user'";
    $result = mysqli_query($con,$sql);
    $result1 = mysqli_query($con,$sql1);
    echo "<h1>"."Friend Deleted Successfully!". "</h1>";
}
 
function chat_with_friend()
{ 
    session_start();
    $chatName = $_GET['name'];
    $_SESSION['FriendName'] = $chatName;
    header("Location:mainchat.php");
    exit;
}

function logout()
{ 
    session_start();
    $a = $_SESSION['userName'];
    global $con;
    $deleteLogin = mysqli_query($con,"DELETE FROM login WHERE loginName = '$a'");
    unset($_SESSION['userName']);
    session_destroy();
    header("Location:Sign-In.html");
    exit;
}


if(isset($_POST['submit'])) 
{
 	if($_POST['submit']=="Log-In")
 	{
   SignIn();
 	} 
 	elseif($_POST['submit']=="Sign-Up")
 	{
    SignUp();
 	}
  elseif($_POST['submit']=="delete")
  {
    DeleteFriend();
  }
 
 	elseif($_POST['submit']=="Add Friend")
 	{
 		AddFriends();
 	}
    elseif($_POST['submit']=="Logout")
  {
    logout();
  }
 
 }

if(isset($_POST['chatbox']))
{
  chat_with_friend();
}


?>

