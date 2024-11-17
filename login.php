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
    @media screen and (min-width:768px) and (max-width: 980px) {
	.card {
		width: 50% !important;
		display: initial;
	}
}

*{
    padding: 0;
    margin: 0;
    box-sizing: border-box;
   }
   body{
        font-family: "Times New Roman", Times, serif;
    }
    h1{
        text-align:center;
    }
.img{
    overflow: auto;
}
    /* Login */
    .login-container{
        margin: 0 auto;
        width: 30%;
        margin-top: 10vh;
    }
 
    .login-container h2{
        text-align: center;
        font-size: 35px;
      padding-top: 0;

    }
    .form-element{
        width: 100%;
    }
    .form-element label{
        display: block;
        font-size: 18px;
        margin-top: 1rem;
    }
    .form-element input[type=text],input[type=password]{
        font-size: 18px;
        width: 100%;
        padding: 12px;
        border: 1px solid black;
        border-radius: 4px;     
    }
    .card button{
        width: 100%;
        letter-spacing: 6px;
        border-radius: 4px;
        margin-top: 2rem;
        font-size: 18px;
        padding: 1rem;
        background-color: rgb(2, 110, 165);
        border: none;
        color: white;
        cursor: pointer;
    }
    .card button:hover{
        background-color: rgb(50, 216, 218);
    }
    .card{
        background-color: rgba(128, 128, 128,.90);
        border: 1px solid grey;
        border-radius: 4px;
        /* height: 550px; */
        height: auto;
        padding: 2rem;
        box-shadow: 5px 6px 18px #888888;        
    }
    .form-logo{
    width: 100%;
    height: auto;
    text-align: center;
    }
    #formlogin{
        background-image: url('images/bg.jpg');
        background-repeat: no-repeat;
        background-size: cover;
    }

</style>

<body id="formlogin">
<div
    class="d-flex flex-column min-vh-100 justify-content-center align-items-center"
    id="template-bg-3">
    <div class="card mb-5 p-5 text-white col-md-4">
        <div class="card-header text-center">
        <h3 id=systemname><b><?php echo $_SESSION['system']['name'] ?></b></h3>
        </div>
        <form id = "login-form" action ="" method="post">
        <div class="form-element">
        <label >Username</label>
        <input type="text" name="username" id="username" autocomplete="off" placeholder ="Enter Username" required>
        </div>

        <div class="form-element">
        <label >Password</label>
        <input type="password" name="password" id="password" placeholder ="Enter Password" required>
        <input type="radio" onclick="myFunction()">Show Password
        </div>
        
        <div class="text-center">
                    <input type="submit" value="Login"
                        class="btn btn-warning mt-3 w-100 p-2"
                        name="login">
                </div>
                <div class="text-center">
            <a href="forgotPassword.php" class="text-white">Forget password?</a>
        </div>
</form>  
</div>
</div>
</body>

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
		e.preventDefault()
		$('#login-form button[type="button"]').attr('disabled',true).html('Logging in...');
		if($(this).find('.alert-danger').length > 0 )
			$(this).find('.alert-danger').remove();
		$.ajax({
			url:'ajax.php?action=login',
			method:'POST',
			data:$(this).serialize(),
			error:err=>{
				console.log(err)
		$('#login-form button[type="button"]').removeAttr('disabled').html('Login');

			},
			success:function(resp){
				if(resp == 1){
					location.href ='index.php?page=home';
				}else{
					$('#login-form').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>')
					$('#login-form button[type="button"]').removeAttr('disabled').html('Login');
				}
			}
		})
	})

</script>	
</html>