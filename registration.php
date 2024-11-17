<?php 

    require ('database/db_connect.php');
    session_start();

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    function sendmail($email,$reset_token){
        
        require ('PHPMailer-master/src/PHPMailer.php');
        require ('PHPMailer-master/src/Exception.php');
        require ('PHPMailer-master/src/SMTP.php');

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;            
            $mail->Username   = 'jcgmdz@gmail.com';
            $mail->Password   = 'abqlscqwnkdzirld';                    
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;   
            $mail->Port       = 465;                           

            $mail->setFrom('jcgmdz@gmail.com');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Password Reset link from ATIS System Login Forget Password Form (If Link does not apper check spam)';
            $mail->Body    = "The System got a request form you to reset Password! <br>Click the link bellow: <br>
            <a href='http://localhost/Capstone-Project/updatePassword.php?email=$email&reset_token=$reset_token'>reset password</a>";

            $mail->send();
                return true;
        } catch (Exception $e) {
                return false;
        }
    }

    if (isset($_POST['send-link'])) {
        
        $email = $_POST['email'];

        $sql="SELECT * FROM users WHERE username = '$email'";
        $result = $connection->query($sql);

        if ($result) {
            
            if ($row = $result->fetch_assoc()) {
                
                $reset_token=bin2hex(random_bytes(16));
                $sql = "UPDATE users SET resettoken ='$reset_token' WHERE username = '$email'";

                if (($connection->query($sql)===TRUE) && sendmail($email,$reset_token )===TRUE) {
                        echo "
                            <script>
                                alert('Password reset link send to mail.');
                                window.location.href='index.php'    
                            </script>"; 
                    }

            }else if(($connection->query($sql)===false) && sendmail($email,$reset_token )===false){
                echo "
                    <script>
                        alert('Email Address Not Found');
                        window.location.href='forgotPassword.php'
                    </script>";
            } else{
                echo "
                    <script>
                        alert('Something got Wrong');
                        window.location.href='forgotPassword.php'
                    </script>";
            }  
            }
        }else{
            echo "
                <script>
                    alert('Server Down');
                    window.location.href='forgotPassword.php'
                </script>";
        }
    
 ?>