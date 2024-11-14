
<div class="modal fade" id="userEditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Update Password</h5>

                     <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
        </div>
        <form id="ownupdate_user">
            <div class="modal-body">

                <div id="errorMessageUpdate" class="alert alert-warning d-none"></div>
                <input type="hidden" name="user_id" id="user_id" >
                <?php 
                
                
                if($_SESSION['login_access'] == 3){?>
				<?php $sql = $connection->query("SELECT Admin_img FROM admin ".($_SESSION['login_Admin_Id'] ? " WHERE Id ={$_SESSION['login_Admin_Id']} ":"")."");
				while($row = $sql->fetch_assoc()):
				?>
				<center><img src="<?php echo "Admin_img/".$row['Admin_img'];?>" alt="Admin Image" id="profile_img" ></center>
				<?php endwhile; ?>	
				<?php }?> 
				
				<?php if($_SESSION['login_access'] == 2){?>
				<?php $sql = $connection->query("SELECT Faculty_img FROM faculty ".($_SESSION['login_Faculty_Id'] ? " WHERE Id ={$_SESSION['login_Faculty_Id']} ":"")."");
				while($row = $sql->fetch_assoc()):
				?>
				<center><img src="<?php echo "Faculty_img/".$row['Faculty_img'];?>" alt="Faculty Image" width= "100px" height ="90vh" id="profile_img" ></center>
				<?php endwhile; ?>	
				<?php }?> 

				<?php if($_SESSION['login_access'] == 1){?>
				<?php $sql = $connection->query("SELECT Student_img FROM students ".($_SESSION['login_Student_Id'] ? " WHERE Id ={$_SESSION['login_Student_Id']} ":"")."");
				while($row = $sql->fetch_assoc()):
				?>
				<center><img src="<?php echo "Student_img/".$row['Student_img'];?>" alt="Student Image" width= "100px" height ="90vh" id="profile_img" ></center>
				<?php endwhile; ?>	
				<?php }?> 
                <div class="mb-3">
                    <label for="">User Name</label>
                    <input type="text" name="username" id="username" class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="">Old Password</label>
                    <input type="password" name="oldpassword" id="password" class="form-control" />
                    <small><i>Leave this blank if you don't want to change password.</i></small><br>
                    <input type="radio" onclick="myFunction()">Show Password
                </div>
                <div class="mb-3">
                    <label for="">Password</label>
                    <input type="password" name="password" id="password1" class="form-control" />
                    <small><i>Leave this blank if you don't want to change password.</i></small><br>
                    <input type="radio" onclick="myFunction1()">Show Password
                </div>
                <div class="mb-3">
                    <label for="">Confirm Password</label>
                    <input type="password" name="cpassword" id="password2" class="form-control" />
                    <small><i>Leave this blank if you don't want to change password.</i></small><br>
                    <input type="radio" onclick="myFunction2()">Show Password
                </div>
                <input type="hidden" name="access_id" id="access_id" >
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Update Password</button>
            </div>
        </form>
        </div>
    </div>
</div>
<div class="wrapper d-flex align-items-stretch">
			<nav id="sidebar" class="active">
        <ul class="list-unstyled components mb-5">
        
          <li class="active">
    
            <a href="index.php?page=home" class="nav-item nav-home"><span class='icon-field'><i class="fas fa-home"></i></span>Dashboard</a>
              </li>
      <?php if($_SESSION['login_access'] == 3){?>    
      <li >
      <a class="nav-item nav-home" class='icon-field' ><i class="bi bi-person-fill-add"></i> Manage User
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16">
  <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
</svg>
      </a>
      <div class="dropdown-container">
       <a href="index.php?page=Students" class="nav-item nav-students"><span class='icon-field'><i class="fas fa-child"></i></span> Students</a>
       <a href="index.php?page=Faculty" class="nav-item nav-faculty"><span class='icon-field'><i class="fas fa-user-tie"></i></span> Faculty</a>                      
       <a href="index.php?page=Admin" class="nav-item nav-users"><span class='icon-field'><i class="fas fa-user-lock"></i></span> Admin</a>
      </div> 
      <a class="nav-item nav-home"> <i class="bi bi-book-half"></i> Class and Schedule
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16">
        <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
      </svg>
      </a>
      <div class="dropdown-container">      
         <a href="index.php?page=GradeLevel" class="nav-item nav-gradelevel"><span class='icon-field'><i class="fas fa-server"></i></span> Grade Level</a>       
         <a href="index.php?page=Subjects" class="nav-item nav-subjects"><span class='icon-field'><i class="fas fa-book-open"></i></span> Subject</a>        
        <a href="index.php?page=Class" class="nav-item nav-class"><span class='icon-field'><i class="fas fa-table"></i></span> Class</a>        
        <a href="index.php?page=Class_Subject" class="nav-item nav-class_subject"><span class='icon-field'><i class="fas fa-scroll"></i></i></span> Class Schedule</a>        
      </div>
      <?php }?> 
      <?php if(($_SESSION['login_access'] == 2) || ($_SESSION['login_access'] == 1 )){ ?> 
        <li>

        <a href="index.php?page=Class_Subject" class="nav-item nav-class_subject"><span class='icon-field'><i class="fas fa-scroll"></i></i></span> Class Schedule</a>  
       
        </li>
        <?php } ?>
        
        <?php if(($_SESSION['login_access'] == 2)  ){ ?>
          <li>
          <a href="index.php?page=grades" class="nav-item nav-grades"><span class='icon-field'><i class="fas fa-calendar"></i></i></span>Grades</a>
          <?php } ?> 
          </li>
          
        <?php if($_SESSION['login_access'] == 3) { ?> 
    <li>
        <a href="index.php?page=announcement" class="nav-item nav-announcement">
            <span class='icon-field'><i class="fas fa-bullhorn"></i></span> Announcement
        </a>
    </li>
<?php } elseif($_SESSION['login_access'] == 2) { ?> 
    <li>
        <a href="index.php?page=teacher_announcement" class="nav-item nav-announcement">
            <span class='icon-field'><i class="fas fa-bullhorn"></i></span> Announcement
        </a>
    </li>
<?php } ?>


        <?php if($_SESSION['login_access'] == 3){?>
        <li>
        <a href="index.php?page=users" class="nav-item nav-users"><span class='icon-field'><i class="fas fa-users-cog"></i></i></i></span> Users</a>
        </li>
        <?php } ?> 
     
    
          <?php if(($_SESSION['login_access'] == 1)  ){ ?>
          <li>
          <a href="index.php?page=student_grades" class="nav-item nav-grades"><span class='icon-field'><i class="fas fa-calendar"></i></i></span>Grades</a>
          <?php } ?> 
          </li>
        </ul>      				  
        				  

        <div class="footer">
        	<p>
					  Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This Capstone Project is made by the Students of STI Carmona
					</p>
        </div>
    </nav>
        <!-- Page Content  -->
      <div id="content" class="p-5 p-md-2">
          <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <button type="button" id="sidebarCollapse" class="btn btn-primary">
                  <i class="fa fa-bars"></i>
                  <span class="sr-only">Toggle Menu</span>
                </button>
                <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
<!-- Navigation bar content -->
<div class="collapse navbar-collapse" id="navbarSupportedContent">
    <B><a>Alta Tierra Integrated School, Inc.</a></B>
    <!-- Added a span to display the time next to the school name -->
    <span id="current-time" style="margin-left: 20px; font-size: 18px; font-weight: bold; color: #007bff;"></span> 
    <ul class="nav navbar-nav ml-auto">
        <li class="nav-item active">
            <a class="nav-link" href="ajax.php?action=logout"><i class="fa fa-power-off text-danger"></i> Logout</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="javascript:void(0)" id="manage_my_account"><i class="fa fa-cog"></i> Manage Account</a>
        </li>
    </ul>
</div>

<script>
    // Function to update the time
    function updateTime() {
        var currentTime = new Date();
        var hours = currentTime.getHours();
        var minutes = currentTime.getMinutes();
        var seconds = currentTime.getSeconds();
        
        // Format time to always show two digits for minutes and seconds
        minutes = minutes < 10 ? '0' + minutes : minutes;
        seconds = seconds < 10 ? '0' + seconds : seconds;
        
        // Build the time string (HH:MM:SS)
        var timeString = hours + ":" + minutes + ":" + seconds;

        // Set the text content of the #current-time span
        document.getElementById('current-time').textContent = timeString;
    }

    // Update the time every second
    setInterval(updateTime, 1000);

    // Call updateTime function immediately when page loads to show the initial time
    updateTime();
</script>

                
          </nav>
        <main id="view-panel" >
        <?php $page = isset($_GET['page']) ? $_GET['page'] :'announcement'; ?>
        <?php include $page.'.php' ?>
        </div>
      </div>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
<script>
  $('#manage_my_account').click(function() {

//var user_id = $(this).val();
$.ajax({
    type: "GET",
    url: "function.php?update_user_id=<?php echo $_SESSION['login_Id']?>",
    success: function (response) {
        var res = jQuery.parseJSON(response);
        if(res.status == 404) {
            alert(res.message);
        }else if(res.status == 200){
            $('#user_id').val(res.data.Id);
            $('#username').val(res.data.username);
            $('#access_id').val(res.data.access);
            $('#userEditModal').modal('show');
            $('#userEditModal')[0].reset();
        }
  }
});
});

$(document).on('submit', '#ownupdate_user', function (e) {
e.preventDefault();
var formData = new FormData(this);
formData.append("ownupdate_user", true);

$.ajax({
    type: "POST",
    url: "function.php",
    data: formData,
    processData: false,
    contentType: false,
    success: function (response) {  
        var res = jQuery.parseJSON(response);
        if(res.status == 422) {
            $('#errorMessageUpdate').removeClass('d-none');
            $('#errorMessageUpdate').text(res.message);

        }else if(res.status == 201){

            alertify.set('notifier','position', 'top-right');
            alertify.success(res.message);
            
            $('#userEditModal').modal('hide');
            $('#userEditModal')[0].reset();

            setTimeout(function(){
						location.reload()
					},500)

        }else if(res.status == 500) {
            alert(res.message);
        }
    }  
});
});
var dropdown = document.getElementsByClassName("nav-item nav-home");
var i;

for (i = 0; i < dropdown.length; i++) {
  dropdown[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var dropdownContent = this.nextElementSibling;
    if (dropdownContent.style.display === "block") {
      dropdownContent.style.display = "none";
    } else {
      dropdownContent.style.display = "block";
    }
  });
}
function myFunction() {
  var x = document.getElementById("password");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}

function myFunction1() {
  var x = document.getElementById("password1");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}

function myFunction2() {
  var x = document.getElementById("password2");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}

</script>

<style>
 .bi-caret-down-fill{
  float: right;
}
  #profile_img{
height:25%;
width: 25%;
  }

.active {
  color: white;
}

.dropdown-container {
  display: none;
  padding-left: 8px;
}

.nav-item:hover {
    color: black !important;
  }
  #sidebar.active .nav-item {
    font-size: 11px;      /* Adjust font size as needed */
    font-weight: bold;    /* Adjust font weight */ 
}
</style>