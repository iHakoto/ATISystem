<?php
include 'auth.php';
 include 'database/db_connect.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php echo $_SESSION['system']['name'] ?></title>     
</head>

<body > 
   <!-- Add Modal -->
   <div class="modal fade" id="studentAddModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
           <h5 class="modal-title" id="exampleModalLabel"><b>Add Student</b></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <form id="saveStudent">
            <div class="modal-body">
                <div id="errorMessage" class="alert alert-warning d-none"></div>
                <center><img  src="img/Img.png" class="border border-dark" width= "25%" height="25%" alt="Student Image" id="stud_img"></center>
                <div class="mb-3">
                    <label for="">Image</label>
                    <input type="file" class="form-control" name="stud_image" onchange="displayImg(this,$(this))"/>
                </div>
                <div class="mb-3">
                    <label for="">First Name</label>
                    <input type="text" name="firstname" class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="">Middle Name</label>
                    <input type="text" name="middlename" class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="">Last Name</label>
                    <input type="text" name="lastname" class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="">Parents Email</label>
                    <input type="email" name="email" class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="">Parent Phone number</label>
                    <input type="text" name="phonenumber" class="form-control" placeholder="Ex. 09*********" maxlength="11" />
                </div>
                <div class="mb-3">
                    <label for="">Class</label>
                                  <select name="class_id" id="class_id" class="custom-select">
                                 <option value="">select class</option>
                                <?php 
                                $gradelevel = $connection->query("SELECT c.*,concat(glevel.Gradelevel,'-',c.Section) as `class` FROM `class` c inner join gradelevel glevel on glevel.Id = c.Gradelevel_Id order by 
                                concat(glevel.Gradelevel,' ','-',c.Section) asc");
                                while($row=$gradelevel->fetch_assoc()):           
                                ?>
                                <option value="<?php echo $row['Id'] ?>"><?php echo $row['class'] ?></option>
                            <?php endwhile; ?>
                            </select>
                </div>                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="bi bi-x-octagon"></i> Cancel</button>
                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Save Student</button>
            </div>
        </form>
        </div>
    </div>
</div>
  <!-- Add Modal -->

<!-- EDIT POP UP FORM (Bootstrap MODAL) -->
<div class="modal fade" id="studentEditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"> <b>Edit Student </b> </h5>
                     <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
        </div>
        <form id="updateStudent">
            <div class="modal-body">
                <div id="errorMessageUpdate" class="alert alert-warning d-none"></div>
                <input type="hidden" name="student_id" id="student_id" >
               <center><img id ="stud_image" src="" class="border border-dark"  width= "100px" alt="Student Image"></center> 
               <br>
                <div class="mb-3">
                  
                <input type="file" class="form-control" name="stud_image" onchange="displayImgEdit(this,$(this))"/>

                    <input type="hidden" name="stud_image_old" id="stud_image_old" class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="">First Name</label>
                    <input type="text" name="firstname" id="firstname" class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="">Middle Name</label>
                    <input type="text" name="middlename" id="middlename" class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="">Last Name</label>
                    <input type="text" name="lastname" id="lastname" class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="">Parent Email</label>
                    <input type="email" name="email" id="email" class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="">Parent Phone Number</label>
                    <input type="number" name="phonenumber" id ="phonenumber" maxlenght="11" class="form-control" />
                </div>     
                <div class="mb-3">
                 <label for="">Class</label>
                                  <select name="class_Id" id="class_Id" class="custom-select">
                                 <option value="">select class</option>
                                <?php 
                                $gradelevel = $connection->query("SELECT c.*,concat(glevel.Gradelevel,'-',c.Section) as `class` FROM `class` c inner join gradelevel glevel on glevel.Id = c.Gradelevel_Id order by 
                                concat(glevel.Gradelevel,' ','-',c.Section) asc");
                                while($row=$gradelevel->fetch_assoc()):           
                                ?>
                                <option value="<?php echo $row['Id'] ?>"><?php echo $row['class'] ?></option>
                            <?php endwhile; ?>
                            </select>
                </div>     
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-x-octagon"></i> Cancel</button>
                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Update</button>
            </div>
        </form>
        </div>
    </div>
</div>
<!-- END EDIT POP UP FORM (Bootstrap MODAL) -->

<!-- View Student Modal -->
<div class="modal fade" id="studentViewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"> <b> View Student</b></h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
        </div>
            <div class="modal-body">
            <div class="mb-3">
                   
             <center><img id ="img" src="" class="border border-dark"  width= "100px" alt="Student Image"></center>  
        
                </div>
                <div class="mb-3">
                    <label for="">First Name</label>
                    <p id="view_firstname" class="form-control"></p>
                </div>
                <div class="mb-3">
                    <label for="">Middle Name</label>
                    <p id="view_middlename" class="form-control"></p>
                </div>
                <div class="mb-3">
                    <label for="">Last Name</label>
                    <p id="view_lastname" class="form-control"></p>
                </div>
                <div class="mb-3">
                    <label for="">Parent Email</label>
                    <p id="view_email" class="form-control"></p>
                </div>
                <div class="mb-3">
                    <label for="">Parent Phone number</label>
                  <p id="view_phone_number" class="form-control"></p> 
                </div>     
                <div class="mb-3">
                 <label for="">Class</label>           
                                  <select name="view_class_Id" id="view_class_Id" class="custom-select">
                                 <option value="">select class</option>
                                <?php 
                                $gradelevel = $connection->query("SELECT c.*,concat(glevel.Gradelevel,'-',c.Section) as `class` FROM `class` c inner join gradelevel glevel on glevel.Id = c.Gradelevel_Id order by 
                                concat(glevel.Gradelevel,' ','-',c.Section) asc");
                                while($row=$gradelevel->fetch_assoc()):           
                                ?>
                              <option value="<?php echo $row['Id'] ?>"><?php echo $row['class'] ?></option>
                            <?php endwhile; ?>
                            </select>               
                </div> 
              
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-x-octagon"></i> Close</button>
            </div>
        </div>
    </div>
</div>




<div class="container-fluid">
	
	<div class="col-lg-12">
	
		<div class="row">
			<!-- FORM Panel -->

			<!-- Table Panel -->
			<div class="col-md-12">
				<div class="card ">
					<div class="card-header" >
                    <h4><b >List of Student</b></h4>
                    <span class="float:right"><button type="button" class="btn btn-primary btn-block btn-sm col-sm-2 float-right" data-toggle="modal" data-target="#studentAddModal">
						<i class="fas fa-user-plus"></i> New Student</button></span>
					</div>
                    <div class="mb-0 mt-3 ml-3">
                            <label for="classfilter">Class Filter:</label>
                            <select id="classfilter" class="form-select">
                                <option value="">All Class</option>
                                <?php  
                                $class = $connection->query("SELECT c.*,concat(glevel.Gradelevel,'-',c.Section) as `class` FROM `class` c inner join gradelevel glevel on glevel.Id = c.Gradelevel_Id order by 
                                concat(glevel.Gradelevel,' ','-',c.Section) asc");
                                while($row=$class->fetch_assoc()):                           
                                ?>         
                                <option value="<?php echo $row['class'] ?>"><?php echo $row['class'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    <div class="table-responsive">
					<div class="card-body">
						<table id ="myTable"class="table table-sm table-hover">
							<thead>
								<tr class="">	        
									<th class="text-center" >Id</th>
                                    <th class="text-center" >Image</th>
                                    <th  class="text-center" >Full Name</th>
                                    <th class="text-center" >Email</th>
                                    <th class="text-center" >Class</th>
									<th class="text-center" >Action</th>                                 
								</tr>
							</thead>
							<tbody>
                                
																						
							</tbody>
						</table>
                        </div>
					</div>
				</div>
			</div>
			<!-- Table Panel -->
		</div>
	</div>	
</div>
</body>
</html>





<style>
	
td{
		vertical-align: middle !important;
	}
	td p{
		margin: unset
	}
    
	</style>


<script>
$(document).ready(function () {
    // Initialize the table only once
    fetchStudents();
    
    // Initialize the DataTable after the data is loaded
    var table;
    
    function fetchStudents() {
        $.ajax({
            url: 'fetch_students.php', // Your PHP script to fetch data
            type: 'POST',
            data: { fetch: 'fetch' },
            success: function (response) {
                // Populate table body with new data
                $('#myTable tbody').html(response);

                // Initialize DataTable only once (if it's not already initialized)
                if (!$.fn.DataTable.isDataTable('#myTable')) {
                    table = $('#myTable').DataTable({
                        responsive: true,
                        paging: true,
                        searching: true,
                        ordering: true,
                        "order": [[4, "asc"]],  // Sort by "Class" column (index 4)
                    });
                } else {
                    // If the table already exists, just redraw it
                    table.clear().rows.add($('#myTable').DataTable().rows().data()).draw();
                }
            },
            error: function (xhr, status, error) {
                console.error('Error fetching data:', error);
            },
        });
    }

    // Listen for changes in the filter dropdown
    $('#classfilter').on('change', function () {
        var selectedClass = $(this).val();  // Get the selected class value

        // If no class is selected, show all rows (reset the search)
        if (selectedClass === "") {
            table.column(4).search('').draw();  // Clear the filter
        } else {
            // Filter the table based on the selected class
            table.column(4).search(selectedClass).draw();
        }
    });
});

</script>


<script>
    function displayImg(input,_this) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
        	$('#stud_img').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
function displayImgEdit(input,_this) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
        	$('#stud_image').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}


    $(document).on('submit', '#saveStudent', function (e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_student", true);

            $.ajax({
                type: "POST",
                url: "function.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {                   
                    var res = jQuery.parseJSON(response);
                    if(res.status == 422 || res.status == 300 || res.status == 301 || res.status == 421) {
                        $('#errorMessage').removeClass('d-none');
                        $('#errorMessage').text(res.message);
                        $("#errorMessage").fadeTo(2000, 500).slideUp(500, function(){
                        $("#errorMessage").slideUp(1000);
                        });
                    }
                    else if(res.status == 200){                    
                        alertify.set('notifier','position', 'top-right');
                        alertify.success(res.message);
                        $('#studentAddModal').modal('hide');
                        $('#saveStudent')[0].reset();
                        setTimeout(function(){
						location.reload()
					},500)
                    }else if(res.status == 500) {
                        alert(res.message);
                    }
                }
            });
        });


 $(document).on('click', '.editStudentBtn', function () {

var student_id = $(this).val();
$.ajax({
    type: "GET",
    url: "function.php?student_id=" + student_id,
    success: function (response) {

        var res = jQuery.parseJSON(response);
        if(res.status == 404) {

            alert(res.message);
        }else if(res.status == 200){

            $('#student_id').val(res.data.Id);
            $('#firstname').val(res.data.Firstname);
            $('#middlename').val(res.data.Middlename);
            $('#lastname').val(res.data.Lastname);
            $('#email').val(res.data.Email);
            $('#stud_image_old').val(res.data.Student_img);
            $('#class_Id').val(res.data.class_id); 
            $('#stud_image').attr('src',"Student_img/" + res.data.Student_img);   
            $('#phonenumber').val(res.data.phonenumber);  
            $('#studentEditModal').modal('show');
        }
  }
});
});

$(document).on('submit', '#updateStudent', function (e) {
e.preventDefault();
var formData = new FormData(this);
formData.append("update_student", true);
$.ajax({
    type: "POST",
    url: "function.php",
    data: formData,
    processData: false,
    contentType: false,
    success: function (response) {  
        var res = jQuery.parseJSON(response);
        if(res.status == 422 || res.status == 421 || res.status == 423) {
            // $('#errorMessageUpdate').removeClass('d-none');
            // $('#errorMessageUpdate').text(res.message);
            alertify.set('notifier','position', 'top-right');
            alertify.warning(res.message); 

        }else if(res.status == 201){
      
            alertify.set('notifier','position', 'top-right');
            alertify.success(res.message); 
            $('#studentEditModal').modal('hide');
            $('#updateStudent')[0].reset();
            setTimeout(function() {
                                fetchStudents();
                            }, 500);
        }else if(res.status == 500) {
            alert(res.message);
        }
    }
});
});
$(document).on('submit', '#delete_Stud', function (e) {
            e.preventDefault();

            if(confirm('Are you sure you want to delete this data?'))
            {
                
                var formData = new FormData(this);
                formData.append("delete_student", true);
                $.ajax({
                    type: "POST",
                    url: "function.php",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {

                        var res = jQuery.parseJSON(response);
                        if(res.status == 500) {

                            alert(res.message);
                        }else{
                            alertify.set('notifier','position', 'top-right');
                            alertify.success(res.message);
                            setTimeout(function() {
                                fetchStudents();
                            }, 500);

                        }
                    }
                });
            }
        });


$(document).on('click', '.viewStudentBtn', function () {

var student_id = $(this).val();
$.ajax({
    type: "GET",
    url: "function.php?student_id=" + student_id,
    success: function (response) {

        var res = jQuery.parseJSON(response);
        if(res.status == 404) {

            alert(res.message);
        }else if(res.status == 200){     
            $('#view_firstname').text(res.data.Firstname);
            $('#view_middlename').text(res.data.Middlename);
            $('#view_lastname').text(res.data.Lastname); 
            $('#view_email').text(res.data.Email);     
            $('#view_class_Id').val(res.data.class_id);    
            $('#img').attr('src',"Student_img/" + res.data.Student_img);   
            $('#view_phone_number').text(res.data.phonenumber);         
            $('#studentViewModal').modal('show');
        }
    }
});
});

$('#studentAddModal').on('hidden.bs.modal', function () {
    $(this).find('form').trigger('reset');
})
</script>	

