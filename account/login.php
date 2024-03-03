<?php
include_once("layout/header.php");
require_once("include/userClass.php");
require_once("include/loginFunction.php");


if (@$_SESSION['acct_no']) {
    header("Location:./user/dashboard.php");
}

session_start();
if (isset($_POST["sub"])) {
    $_SESSION["name"] = $_POST["name"];
    $_SESSION['last_login_timestamp'] = time();
    header("location:index.php");
}



if (isset($_POST['login'])) {
    $acct_no = inputValidation($_POST['acct_no']);
    $acct_password = inputValidation($_POST['acct_password']);



    $log = "SELECT * FROM users WHERE acct_no =:acct_no";
    $stmt = $conn->prepare($log);
    $stmt->execute([
        'acct_no' => $acct_no
    ]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);


    if ($stmt->rowCount() === 0) {
        //        toast_alert("error","Invalid login details");
        notify_alert('Invalid login details', 'danger', '2000', 'Close');
    } else {
        $validPassword = password_verify($acct_password, $user['acct_password']);

        if ($validPassword === false) {
            notify_alert('Invalid login details', 'danger', '2000', 'Close');

            //            toast_alert("error","Invalid login details");
        } else {

            if ($user['acct_status'] === 'hold') {
                notify_alert('Account on Hold, Kindly contact support to activate your account', 'danger', '3000', 'close');
            } else {

                $acct_otp = substr(number_format(time() * rand(), 0, '', ''), 0, 6);

                $sql = "UPDATE users SET acct_otp=:acct_otp WHERE acct_no=:acct_no";
                $stmt = $conn->prepare($sql);
                $stmt->execute([
                    'acct_otp' => $acct_otp,
                    'acct_no' => $acct_no
                ]);

                //IP LOGIN DETAILS

                $device = $_SERVER['HTTP_USER_AGENT'];
                $ipAddress = $_SERVER['REMOTE_ADDR'];
                $nowDate = date('Y-m-d H:i:s');
                $user_id = $user['id'];


                $stmt = $conn->prepare("INSERT INTO audit_logs (user_id,device,ipAddress,datenow) VALUES(:user_id,:device,:ipAddress,:datenow)");
                $stmt->execute([
                    'user_id' => $user_id,
                    'device' => $device,
                    'ipAddress' => $ipAddress,
                    'datenow' => $nowDate
                ]);

                if (true) {

                    $sql = "SELECT * FROM users WHERE acct_no=:acct_no";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute([
                        'acct_no' => $acct_no
                    ]);
                    $resultCode = $stmt->fetch(PDO::FETCH_ASSOC);
                    $code = $resultCode['acct_otp'];

                    // $APP_NAME = $pageTitle;
                    // $email = $resultCode['acct_email'];
                    // $fullName = $resultCode['firstname'] . " " . $resultCode['lastname'];

                    // $message = $sendMail->otpRequestLogin($fullName, $code, $APP_NAME);
                    // $subject = "[OTP CODE] - $APP_NAME";
                    // $email_message->send_mail($email, $message, $subject);

                    if (true) {

                        $fullName = $user['firstname'] . " " . $user['lastname'];
                        // $APP_URL = APP_URL;
                        $email = $user['acct_email'];

                        // $message = $sendMail->LoginMsg($full_name, $device, $ipAddress, $nowDate, $APP_NAME, WEB_URL, $BANK_PHONE);


                        // $subject = "Login Notification". "-". $APP_NAME;
                        // $email_message->send_mail($user_email, $message, $subject);

                        $message = '';

                        // Send mail to user with verification here
                        $to = $email;
                        $subject = "LOGIN NOTIFICATION";

                        // Create the body message
                        $message .= '<!DOCTYPE html>
        <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
        <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width,initial-scale=1">
          <meta name="x-apple-disable-message-reformatting">
          <title></title>
          <!--[if mso]>
          <noscript>
            <xml>
              <o:OfficeDocumentSettings>
                <o:PixelsPerInch>96</o:PixelsPerInch>
              </o:OfficeDocumentSettings>
            </xml>
          </noscript>
          <![endif]-->
          <style>
            table, td, div, h1, p {font-family: Arial, sans-serif;}
            button{
                font: inherit;
                background-color: #FF7A59;
                border: none;
                padding: 10px;
                text-transform: uppercase;
                letter-spacing: 2px;
                font-weight: 700; 
                color: white;
                border-radius: 5px; 
                box-shadow: 1px 2px #d94c53;
              }
          </style>
        </head>
        <body style="margin:0;padding:0;">
          <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
            <tr>
              <td align="center" style="padding:0;">
                <table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
                  <tr>
                        <td align="center" style="padding:20px 0 20px 0;background:#70bbd9; font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;font-size: 20px;margin: 10px;">
                            <h1 style="margin:24px">Golden Stone</h1> 
                        </td>
                  </tr>
                  <tr style="background-color: #eeeeee;">
                    <td style="padding:36px 30px 42px 30px;">
                      <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                        <tr>
                          <td style="padding:0 0 36px 0;color:#153643;">
                            <h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Dear ' . $fullName . ' , </h1>
                            <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                              You have successfully logged in to your Golden Stone account on : ' . date('Y-m-d h:i A') . '.
                            </p>
                            <br>
                            <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                            If you did not initiate this log in, please contact us immediately through Live chat or email support teams.
                              
                            </p>
                            <p style="margin:0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                <a href="mailto:support@goldenstonefinance.online" style="color:#ee4c50;text-decoration:underline;"> 
                                    <button> 
                                        Click to mail support
                                    </button>  
                                </a>
                            </p>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td style="padding:30px;background:#ee4c50;">
                      <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
                        <tr>
                          <td style="padding:0;width:50%;" align="left">
                            <p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                              &reg; 2024 copyright Golden Stone;<br/><a href="https://goldenstonefinance.online" style="color:#ffffff;text-decoration:underline;">visit site</a>
                            </p>
                          </td>
                          <td style="padding:0;width:50%;" align="right">
                            <table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
                              <tr>
                                <td style="padding:0 0 0 10px;width:38px;">
                                  <a href="http://www.twitter.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/tw_1.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
                                </td>
                                <td style="padding:0 0 0 10px;width:38px;">
                                  <a href="http://www.facebook.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/fb_1.png" alt="Facebook" width="38" style="height:auto;display:block;border:0;" /></a>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </body>
        </html>';
                        $header = "From:" . WEB_TITLE . " <" . WEB_EMAIL . "> \r\n";
                        $header .= "Cc:" . WEB_EMAIL . " \r\n";
                        $header .= "MIME-Version: 1.0\r\n";
                        $header .= "Content-type: text/html\r\n";

                        @$retval = mail($to, $subject, $message, $header);
                    }

                    if (true) {
                        $_SESSION['login'] = $user['acct_no'];
                        header("Location:./pin.php");
                        exit;
                    }
                }
            }
        }
    }
}
?>
<div class="header-top-right">

    <div id="google_translate_element"></div>

    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'en'
            }, 'google_translate_element');
        }
    </script>

    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

    <style>
        #google_translate_element {
            /*color: transparent;*/
        }

        #google_translate_element a {
            display: none;
        }

        div.goog-te-gadget {
            /*color: transparent !important;*/
        }
    </style>
</div>
<div class="form-container outer">
    <div class="form-form">
        <div class="form-form-wrap">
            <div class="form-container">
                <div class="form-content">

                    <h1 class="">Sign In</h1>
                    <p class="">Log in to your account to continue.</p>
                    <!--   <img src="./assets/settings/<?= $page['image'] ?>" class="navbar-logo" alt="logo" width="20%"> -->

                    <form class="text-left" method="POST">
                        <div class="form">

                            <div id="username-field" class="field-wrapper input">
                                <label for="username">Account Number</label>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                <input id="username" name="acct_no" type="number" class="form-control" placeholder="Account ID">
                            </div>

                            <div id="password-field" class="field-wrapper input mb-2">
                                <div class="d-flex justify-content-between">
                                    <label for="password">PASSWORD</label>
                                    <a href="./signup" class="forgot-pass-link badge badge-success text-white">Create New Account</a>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                </svg>
                                <input id="password" name="acct_password" type="password" class="form-control" placeholder="Password">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" id="toggle-password" class="feather feather-eye">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </div>
                            <div class="d-sm-flex justify-content-between">
                                <div class="field-wrapper">
                                    <button type="submit" class="btn btn-primary" name="login" value="">Log In</button>
                                </div>
                            </div>
                            <hr>
                            <a href="../index.html" class="border border-primary badge badge-info">
                                <- Go to Home </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<?php

include_once("layout/footer.php");

?>