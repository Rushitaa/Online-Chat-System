<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    
    <title>Chat</title>
    
    <link rel="stylesheet" href="style-chatbox.css" type="text/css" />
    
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script type="text/javascript" src="chat.js"></script>
    <script type="text/javascript">
    
       var name = $('#name-area').html() ;
      
        if (!name || name == ' ') {
           name = "Guest";  
        }
        
        $("#name-area").html("You are: <span>" + name + "</span>");
        
        // Initiate the chat
        var chat =  new Chat();
        $(function() {
        
             chat.getState(); 
             
             
             $("#sendie").keydown(function(event) {  
             
                 var key = event.which;  
           
                 if (key >= 33) {
                   
                     var maxLength = $(this).attr("maxlength");  
                     var length = this.value.length;  
                     
                    
                     if (length >= maxLength) {  
                         event.preventDefault();  
                     }  
                  }  
               });
             
             $('#sendie').keyup(function(e) {   
                                 
                  if (e.keyCode == 13) { 
                  
                    var text = $(this).val();
                    var maxLength = $(this).attr("maxlength");  
                    var length = text.length; 
                     
                    if (length <= maxLength + 1) 
                    { 
                         
                        // chat.send(text, $('#name-area').html());  
                        chat.send(text, $('#name-area').html());
                          $(this).val("");
                        
                    } else {
                    
                        $(this).val(text.substring(0, maxLength));
                        
                    }   
                    
                    
                  }
             });
            
        });
    </script>


</head>
<body onload="setInterval('chat.update()', 1000)" >

    <div id="page-wrap">
    
        <?php 
            session_start();
            echo "<h2>".'Fun Chat with '. $_SESSION['FriendName']. '!'."</h2>";
            echo "<form method='post' action='connectivity.php'>
            <input id='button' name='submit' type='submit' value='Logout' >
            </form>";
            echo "<p id='name-area'>" . $_SESSION['userName'] . "</p>" ;
            
        ?>
        
        <div id="chat-wrap"><div id="chat-area"></div></div>
        
        <form id="send-message-area">
            <textarea id="sendie" maxlength = '100' ></textarea>
            <p><b>SEND</b></p>
        </form>
    
    </div>

</body>

</html>