<?php
require_once('email_config.php');
require('phpmailer/PHPMailer/PHPMailerAutoload.php');
$mail = new PHPMailer;
$mail->SMTPDebug = 0;                               // Enable verbose debug output
$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = EMAIL_USER;                 // SMTP username
$mail->Password = EMAIL_PASS;                 // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to
$options = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);
if(isset($_POST)){
    $sendOk = false;
    $name = $_POST["name"];
    $email = $_POST["email"];

    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
        $response = [
            'success' => false,
            'message' => "Only letters and white space allowed."
        ];
        print(json_encode($response));
        exit();
    }

    //remove all illegal characters from email
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    if(!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $sendOk = true;
    } else {
        $response = [
            'success' => false,
            'message' => "Invalid email address."
        ];
        print(json_encode($response));
    }
    if($sendOk) {
        $mail->smtpConnect($options);
        $mail->From = EMAIL_USER;//your email sending account
        $mail->FromName = $_POST['name'];//your email sending account name
        $mail->addAddress('jeesoo2002@gmail.com');     // Add a recipient
        //$mail->addAddress('ellen@example.com');               // Name is optional
        $mail->addReplyTo($_POST['email']);
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');
        //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = "Message from Jeesookim.com";
        $mail->Body    = $_POST['message'];
        //$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
        //message from $_POST['name'] at $_SERVER['REMOTE_ADDRESS'];  to see sender's ip address
        //print("This is POST test: ");
        //print_r($_POST);
        if(!$mail->send()) {
            $response = [
                'success' => false,
                'message' => 'Mailer Error: ' . $mail->ErrorInfo
            ];
        } else {
            $response =  [
                'success' => true,
                'message' => 'Message has been sent'
            ];
        }
        echo json_encode($response);
    }
};
?>