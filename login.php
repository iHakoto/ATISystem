<!DOCTYPE html>
<html lang="en">
<?php 
session_start();
include('database/db_connect.php');
include('./header.php');
ob_start();
if(!isset($_SESSION['system'])){
    $system = $connection->query("SELECT * FROM system_settings limit 1")->fetch_array();
    foreach($system as $k => $v){
        $_SESSION['system'][$k] = $v;
    }
}
ob_end_flush();
?>
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title><?php echo $_SESSION['system']['name'] ?></title>  
</head>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: "Times New Roman", Times, serif;
        background-color: #f4f7fa;
    }

    h1 {
        text-align: center;
    }

    .login-container {
        width: 100%;
        max-width: 400px;
        margin: 10vh auto;
        padding: 20px;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 8px;
        box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1);
        animation: fadeIn 1.5s ease-out;
    }

    .login-container h2 {
        text-align: center;
        font-size: 30px;
        margin-bottom: 20px;
        color: #333;
    }

    .form-element {
        margin-bottom: 20px;
    }

    .form-element label {
        font-size: 16px;
        margin-bottom: 8px;
        display: block;
        color: #333;
    }

    .form-element input[type="text"],
    .form-element input[type="password"] {
        width: 100%;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
        transition: all 0.3s ease;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    }

    .form-element input[type="text"]:focus,
    .form-element input[type="password"]:focus {
        border-color: #4CAF50;
        outline: none;
        box-shadow: 0px 0px 10px rgba(76, 175, 80, 0.4);
    }

    .card button {
        width: 100%;
        font-size: 18px;
        padding: 12px;
        background-color: #007bff;
        border: none;
        border-radius: 4px;
        color: white;
        cursor: pointer;
        letter-spacing: 2px;
        transition: all 0.3s ease;
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
    }

    .card button:hover {
        background-color: #0056b3;
        transform: translateY(-3px);
    }

    .card button:active {
        transform: translateY(0);
    }

    .card {
        background-color: rgba(128, 128, 128, 0.9);
        border-radius: 8px;
        padding: 25px;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
        animation: slideIn 1s ease-out;
    }

    .form-logo {
        width: 100%;
        height: auto;
        text-align: center;
    }

    #formlogin {
        background-image: url('images/bg.jpg');
        background-size: cover;
        background-position: center;
        height: 100vh;
        animation: backgroundAnimation 5s infinite alternate;
    }

    .text-center {
        margin-top: 20px;
    }

    /* Animation */
    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    @keyframes slideIn {
        from {
            transform: translateY(-50px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    @keyframes backgroundAnimation {
        0% {
            background-position: 0% 50%;
        }
        100% {
            background-position: 100% 50%;
        }
    }

    /* Customizing the links */
    a {
        text-decoration: none;
        color: #007bff;
        font-weight: bold;
    }

    a:hover {
        color: #0056b3;
    }

    /* Media Query for responsiveness */
    @media screen and (max-width: 768px) {
        .login-container {
            width: 80%;
            padding: 15px;
        }

        .card {
            padding: 20px;
        }
    }
</style>

<body id="formlogin">
<div class="d-flex flex-column min-vh-100 justify-content-center align-items-center" id="template-bg-3">
    <div class="login-container">
        <div class="card mb-5 p-5 text-white">
            <div class="card-header text-center">
                <h3><b><?php echo $_SESSION['system']['name'] ?></b></h3>
            </div>
            <form id="login-form" action="" method="post">
                <div class="form-element">
                    <label>Username</label>
                    <input type="text" name="username" id="username" autocomplete="off" placeholder="Enter Username" required>
                </div>

                <div class="form-element">
                    <label>Password</label>
                    <input type="password" name="password" id="password" placeholder="Enter Password" required>
                    <input type="radio" onclick="myFunction()"> Show Password
                </div>

                <div class="text-center">
                    <button type="submit" name="login">Login</button>
                </div>
                
                <div class="text-center">
                    <a href="forgotPassword.php" class="text-white">Forgot password?</a>
                </div>
            </form>  
        </div>
    </div>
</div>

<script>
function myFunction() {
  var x = document.getElementById("password");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}

$('#login-form').submit(function(e){
    e.preventDefault();
    $('#login-form button[type="submit"]').attr('disabled',true).html('Logging in...');
    if ($(this).find('.alert-danger').length > 0)
        $(this).find('.alert-danger').remove();

    $.ajax({
        url: 'ajax.php?action=login',
        method: 'POST',
        data: $(this).serialize(),
        error: function(err) {
            console.log(err);
            $('#login-form button[type="submit"]').removeAttr('disabled').html('Login');
        },
        success: function(resp) {
            if (resp == 1) {
                location.href = 'index.php?page=home';
            } else {
                $('#login-form').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>');
                $('#login-form button[type="submit"]').removeAttr('disabled').html('Login');
            }
        }
    });
});
</script>
</body>
</html>
