<?php
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

  $regex = '1234567890';
  $code = substr(str_shuffle($regex), 0, 6); #Generate random numbers to make a unique order no.

  sendMail($code);

  function sendMail($code) {
    $subject = 'OTP CODE';                                  #Subject header
    $name = "Localized Fruit Basket";                       #Name of website or any
    $address = "Minapasuk";                                 #Address/location
    $from = 'mswisa02@gmail.com';                           #Sender email
    $to = $_GET['email'];                                   #Receiver email
    $password = 'nblcjaelukgujlhu';                         #Password
    

    require 'vendor/PHPMailer/src/Exception.php';
    require 'vendor/PHPMailer/src/PHPMailer.php';
    require 'vendor/PHPMailer/src/SMTP.php';
          
    $mail = new PHPMailer();

    #SMTP settings
    $mail->isSMTP();                                      #Send using SMTP
    #$mail->SMTPDebug = 3;                                 #For debugging, keep this commented
    $mail->Host = 'smtp.gmail.com';                       #Host
    $mail->SMTPAuth = true;                               #SMTP authentication
    $mail->Username = $from;                              #Sender email
    $mail->Password = $password;                          #Password
    $mail->SMTPSecure = 'tls';                            #Enable implicit TLS encryption. Choose from: tls/ssl
    $mail->Port = 587;                                    #TCP port to connect. Port: 587/465
    $mail->smtpConnect([
      'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
      ]
    ]);

    #Receipients
    $mail->setFrom($from, $name);                         #Send from
    $mail->addAddress($to);                               #Send to
    $mail->addReplyTo($from);                             #Add reply
    
    #Content settings
    $mail->isHTML(true);
    $mail->Subject = $subject;                            #Email subject
    $mail->Body = "
    <!DOCTYPE html>
    <html style='font-family: 'Nunito Sans', Helvetica, Arial, sans-serif;'>
    <head>
      <meta name='viewport' content='width=device-width, initial-scale=1.0' />
      <meta name='x-apple-disable-message-reformatting' />
      <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
      <meta name='color-scheme' content='light dark' />
      <meta name='supported-color-schemes' content='light dark' />
      <title>Receipt Preview</title>
      <style type='text/css' rel='stylesheet' media='all'>
        @import url('https://fonts.googleapis.com/css?family=Nunito+Sans:400,700&display=swap');
      </style>
    </head>
    <body style='background-color: #F2F4F6; color: #51545E;'>
      <table style='width: 100%; margin: 0; padding: 0; -premailer-width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; background-color: #F2F4F6;' width='100%' cellpadding='0' cellspacing='0' role='presentation'>
          <table style='width: 100%; margin: 0; padding: 0;' width='100%' cellpadding='0' cellspacing='0' role='presentation'>
            <tr>
              <td style='padding: 40px 0; text-align: center; word-break: break-word;'>
                <a href='https://bdfpstore.ml' style='font-size: 16px; font-weight: bold; color: #333333; text-decoration: none; text-shadow: 0 1px 0 white; background: #A8AAAF; border-radius: 10px; padding: 10px'>
                  $name
                </a>
              </td>
            </tr>
            <tr>
              <td style='width: 100%; margin: 0; padding: 0; word-break: break-word;' width='570' cellpadding='0' cellspacing='0'>
                <table style='width: 570px; margin: 0 auto; padding: 0; background-color: #FFFFFF;' align='center' width='570' cellpadding='0' cellspacing='0' role='presentation'>
                  <tr>
                    <td style='padding: 45px; word-break: break-word;'>
                      <div>
                        <h4 style='margin-top: 0; color: #333333; font-size: 22px; font-weight: bold; text-align: left;'>Hi, here is your OTP code. PLEASE DO NOT ENTER YOUR OTP TO ANY SITE OR SHARE IT TO ANYONE.</h4>
                        <p>Your OTP code request is <strong>$code</strong></p>
                      </div>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td>
                <table style='width: 570px; margin: 0 auto; padding: 0; text-align: center;' align='center' width='570' cellpadding='0' cellspacing='0' role='presentation'>
                  <tr>
                    <td style='padding: 45px;' align='center'>
                      <p style='font-size: 13px; color: #A8AAAF;'>$address</p>
                      <p style='font-size: 13px; color: #A8AAAF;'>© Copyright $name. All Rights Reserved</p>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </table>
      </body>
    </html>";
    $mail->send();                                        #Send email
  }

  return $code;
?>