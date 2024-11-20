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
        background-color: #f4f4f4;
    }

    .login-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        max-width: 900px;
        width: 100%;
        height: 100%;
    }

    /* Image container: Set it to be square and fill the height */
    .login-image {
        flex: 1;
        height: 100%; /* Make the image take the full height of the container */
        width: 350px; /* Set a fixed width to make it a square */
        background: url('../images/alta.jpg') no-repeat center center;
        background-size: cover;
        border-radius: 12px 0 0 12px;  /* Rounded corners for left side */
    }

    .login-container {
        flex: 1;
        background-color: rgba(255, 255, 255, 0.9); /* Semi-transparent white background */
        border-radius: 0 12px 12px 0; /* Rounded corners for right side */
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        padding: 40px;
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

    /* Default state of the login button */
    .login-btn {
        width: 100%;
        padding: 10px;
        margin-top: 20px;
        font-size: 18px;
        background-color: #800000;
        border: none;
        color: white;
        border-radius: 8px;
        cursor: pointer;
        transition: 0.3s ease;
        letter-spacing: 1px;
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
    }

    /* Button hover effect */
    .login-btn:hover {
        background-color: #6A0000; /* Maroon color when hovered */
        transform: translateY(-3px); /* Slight lift effect */
    }

    /* Button active state */
    .login-btn:active {
        transform: translateY(0); /* Return to normal on click */
    }

    .forgot-password {
        text-align: center;
        margin-top: 20px;
    }

    .forgot-password a {
        color: #800000;
        font-weight: bold;
        text-decoration: none;
    }

    .forgot-password a:hover {
        color: #6A0000;
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
        .login-wrapper {
            flex-direction: column;
        }

        .login-image {
            height: 250px; /* Smaller image on mobile */
            width: 100%;
            border-radius: 12px;
        }

        .login-container {
            padding: 20px;
            max-width: 100%;
        }
    }
</style>

<body>
    <div class="login-wrapper">
        <div class="login-image"></div> <!-- Image on left -->
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
