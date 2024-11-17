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
    /* Resetting margins and paddings */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Arial', sans-serif;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .login-container {
        background-color: rgba(255, 255, 255, 0.9); /* Semi-transparent white background */
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        padding: 40px;
        width: 100%;
        max-width: 400px;
        animation: fadeIn 1s ease-out;
    }

    .login-container h2 {
        font-size: 28px;
        font-weight: 600;
        color: #333;
        margin-bottom: 30px;
        text-align: center;
    }

    .form-element {
        margin-bottom: 20px;
    }

    .form-element label {
        font-size: 16px;
        color: #333;
        font-weight: bold;
        margin-bottom: 8px;
        display: block;
    }

    .form-element input[type="text"],
    .form-element input[type="password"] {
        width: 100%;
        padding: 12px 15px;
        font-size: 16px;
        border: 1px solid #ddd;
        border-radius: 8px;
        transition: 0.3s ease;
        outline: none;
    }

    .form-element input[type="text"]:focus,
    .form-element input[type="password"]:focus {
        border-color: #FF7A00;
        box-shadow: 0 0 5px rgba(255, 122, 0, 0.5);
    }

    .show-password {
        display: flex;
        align-items: center;
        margin-top: 10px;
    }

    .show-password input {
        margin-left: 10px;
        cursor: pointer;
    }

    .login-btn {
        width: 100%;
        padding: 12px;
        font-size: 18px;
        background-color: #FF7A00;
        border: none;
        color: white;
        border-radius: 8px;
        cursor: pointer;
        transition: 0.3s ease;
        letter-spacing: 1px;
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
    }

    .login-btn:hover {
        background-color: #FF5722;
        transform: translateY(-3px);
    }

    .login-btn:active {
        transform: translateY(0);
    }

    .forgot-password {
        text-align: center;
        margin-top: 20px;
    }

    .forgot-password a {
        color: #FF7A00;
        font-weight: bold;
        text-decoration: none;
    }

    .forgot-password a:hover {
        color: #FF5722;
    }

    /* Animation for fade-in */
    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    /* Media Query for responsiveness */
    @media screen and (max-width: 768px) {
        .login-container {
            padding: 30px;
            width: 80%;
        }
    }
</style>

<body>
    <div class="login-container">
        <h2>Welcome to <?php echo $_SESSION['system']['name']; ?></h2>
        <form id="login-form" action="" method="post">
            <div class="form-element">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" autocomplete="off" placeholder="Enter Username" required>
            </div>

            <div class="form-element">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Enter Password" required>
            </div>

            <div class="show-password">
                <input type="checkbox" id="showPassword" onclick="togglePassword()"> Show Password
            </div>

            <button type="submit" name="login" class="login-btn">Login</button>

            <div class="forgot-password">
                <a href="forgotPassword.php">Forgot password?</a>
            </div>
        </form>
    </div>

    <script>
        // Show password toggle
        function togglePassword() {
            var passwordField = document.getElementById("password");
            var checkBox = document.getElementById("showPassword");
            if (checkBox.checked) {
                passwordField.type = "text";
            } else {
                passwordField.type = "password";
            }
        }

        // Handle form submission
        $('#login-form').submit(function(e){
            e.preventDefault();

            $('#login-form button[type="submit"]').attr('disabled', true).text('Logging in...');
            if ($(this).find('.alert-danger').length > 0) $(this).find('.alert-danger').remove();

            $.ajax({
                url: 'ajax.php?action=login',
                method: 'POST',
                data: $(this).serialize(),
                error: function(err) {
                    console.log(err);
                    $('#login-form button[type="submit"]').removeAttr('disabled').text('Login');
                },
                success: function(resp) {
                    if (resp == 1) {
                        location.href = 'index.php?page=home';
                    } else {
                        $('#login-form').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>');
                        $('#login-form button[type="submit"]').removeAttr('disabled').text('Login');
                    }
                }
            });
        });
    </script>
</body>
</html>
