  <?php

// Program: chatScriptClient.php
// Copyright (c) 2012 R. Wade Schuette
// Function -- a working skeleton of a client to the Chatbot Server
// NOTES:   Be sure to put in your correct host, port, username, and bot name below !

//     Be sure to to change the file suffix to php instead of txt

// Credits:  This program is derived from a sample client script by Alejandro Gervasio
//   posted here:  www dot devshed dot com/c/a/PHP/An-Introduction-to-Sockets-in-PHP/ 

// The legalese is shamelessly copied from Bruce Wilcox's chatbot file header.

// Caveats:   This worked for me, but has no real error handling  
//            There's no way to deal with a gambit PUSHED by the server.



// LEGAL STUFF:
// Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal
// in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, or sell
// copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

// The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

// THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
// FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
// WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
//*********************************************************************************/
// Revisions
// Nov 3,2012 -- tested this and it seems to work correctly for me(rws)





//  =============  user values ====
$host = "127.0.0.1";  //  <<<<<<<<<<<<<<<<< YOUR CHATSCRIPT SERVER IP ADDRESS GOES HERE 
$port = 1024;     // <<<<<<< your portnumber if different from 1024
$user = "wade";   // <<<<<< your username, or "guest"
$bot  = "harry";  // <<<<<<< desired botname, or "" for default bot
$null = "\x00";
//=========================
// Note - the top part (PHP) is skipped on the first display of this form, but fires on each loop after that.

if($_POST['send']){
    // open client connection to TCP server
    //  echo "<p> Here goes </p>";

    $msg=$_POST['message'];
    $message = $user.$null.$bot.$null.$msg.$null;

    echo "<p>User $user told bot $bot this: </p>";
    echo '<h2>'.$msg.'</h2>';
  
    // fifth parameter in fsockopen is timeout in seconds
    if(!$fp=fsockopen($host,$port,$errstr,$errno,30)){
        trigger_error('Error opening socket',E_USER_ERROR);
    }
    // echo "<p> made it past fsockopen ok <p>";

    // write message to socket server
    fputs($fp,$message);
    // get server response
    $ret=fgets($fp,$port);
    // close socket connection
    fclose($fp);
    
    echo "Chatbot $bot replied to $user:";
    echo '<h2>'.$ret.'</h2>';
//    exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>TESTING TCP SOCKET SERVER</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-
8859-1" />
</head>
<body>
<p>Enter your message to your chatbot below:</p>
<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
<input type="text" name="message" size="70" /><br />
<input type="submit" name="send" value="Send Value" />
</form>
</body>
</html>

