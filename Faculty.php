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
   <div class="modal fade" id="facultyAddModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"> <b> Add Faculty </b></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <form id="savefaculty">
            <div class="modal-body">

                <div id="errorMessage" class="alert alert-warning d-none"></div>
                <center><img src="img/Img.png" class="border border-dark" width= "25%" height="25%" alt="Faculty Image" id ="fac_img"></center>
                <div class="mb-3">
                    <label for="">Image</label>
                    <input type="file" class="form-control" name="faculty_img" onchange="displayImg(this,$(this))"/>
                    
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
                    <label for="">Email</label>
                    <input type="email" name="email" class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="">Phone number</label>
                    <input type="text" name="phonenumber" class="form-control" placeholder="Ex. 09*********" maxlength="11" />
                </div>
              
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="bi bi-x-octagon"></i> Cancel</button>
                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Save Faculty</button>
            </div>
        </form>
        </div>
    </div>
</div>
  <!-- Add Modal -->


<!-- EDIT POP UP FORM (Bootstrap MODAL) -->


<div class="modal fade" id="facultyEditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"> <b>Edit Faculty</b></h5>

                     <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
        </div>
        <form id="updateFaculty">
            <div class="modal-body">

                <div id="errorMessageUpdate" class="alert alert-warning d-none"></div>
                <input type="hidden" name="faculty_id" id="faculty_id" >

                <center><img id ="editimg" src="" class="border border-dark" width= "100px" alt="Faculty Image"></center> 
                <br>
                <div class="mb-3">
                <input type="file" class="form-control" name="faculty_image" onchange="displayImgEdit(this,$(this))"/>
                   
                    <input type="hidden" name="faculty_image_old" id="faculty_image_old" class="form-control" />
                   
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
                    <label for="">Email</label>
                    <input type="email" name="email" id="email" class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="">Phone number</label>
                    <input type="number" name="phonenumber" id="phonenumber" class="form-control" />
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-x-octagon"></i> Cancel</button>
                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Update Faculty</button>
            </div>
        </form>
        </div>
    </div>
</div>
<!-- END EDIT POP UP FORM (Bootstrap MODAL) -->

<!-- View Faculty Modal -->
<div class="modal fade" id="facultyViewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"> <b> View Faculty</b></h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
        </div>
            <div class="modal-body">
            <center><img id ="img" src="" class="border border-dark" width= "100px" alt="Faculty Image" width= "100px" height ="90vh"></center>  
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
                    <label for="">Email</label>
                    <p id="view_email" class="form-control"></p>
                </div>
                <div class="mb-3">
                    <label for="">Phone number</label>
                  <p id="view_phone_number" class="form-control"></p> 
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
		<div class="row mb-1 mt-1">
			<div class="col-md-12">
				
			</div>
		</div>
		<div class="row">
			<!-- FORM Panel -->

			<!-- Table Panel -->
			<div class="col-md-12">
				<div class="card ">
					<div class="card-header" >
						<h4><b >List of Faculty</b></h4>
						<span class="float:right"><button type="button" class="btn btn-primary btn-block btn-sm col-sm-2 float-right" data-toggle="modal" data-target="#facultyAddModal">
						<i class="fas fa-user-plus"></i> New Faculty</button></span>
					</div>
                    <div class="table-responsive">
					<div class="card-body">
						<table id ="myTable"class="table table-sm table-hover">
							<thead>
								<tr class="">
							
									<th class="text-center">Id</th>
                                    <th class="text-center">Image</th>
                                    <th class="text-center">Full Name</th>
                                    <th class="text-center">Email</th>
									<th class="text-center">Action</th>
                                   
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

<!-- <script>
        // Function to fetch grades based on both filters
        function fetchFaculty() {
                $.ajax({
                    url: 'fetch_faculty.php', // PHP file to fetch data
                    type: 'POST',
                    data: { 
                        fetch: 'fetch',
                    },
                    success: function(response) {
                        $('#myTable tbody').html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });    
        }
        $(document).ready(function() {
            fetchFaculty(); // Automatically fetch data when the page loads
    });
</script> -->

<script>

fetchFaculty();
    
    // Initialize the DataTable after the data is loaded
    var table;
    
    function fetchFaculty() {
    $.ajax({
        url: 'fetch_faculty.php', // Your PHP script to fetch data
        type: 'POST',
        data: { fetch: 'fetch' },
        success: function (response) {
            // If DataTable is already initialized, destroy it and reinitialize with new data
            if ($.fn.DataTable.isDataTable('#myTable')) {
                $('#myTable').DataTable().destroy(); // Destroy the existing DataTable instance
            }
            
            // Update the table body with new data
            $('#myTable tbody').html(response);

            // Reinitialize DataTable
            table = $('#myTable').DataTable({
                responsive: true,
                paging: true,
                searching: true,
                ordering: true,
                "order": [[2, "asc"]],  // Sort by "Class" column (index 2)
            });
        },
        error: function (xhr, status, error) {
            console.error('Error fetching data:', error);
        },
    });
}

</script>
<script>

    
    $(document).ready(function () {
	$('#myTable').dataTable();
})
function displayImg(input,_this) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
        	$('#fac_img').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
function displayImgEdit(input,_this) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
        	$('#editimg').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
    $(document).on('submit', '#savefaculty', function (e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_faculty", true);

            $.ajax({
                type: "POST",
                url: "function.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    
                    var res = jQuery.parseJSON(response);
                    if(res.status == 422 || res.status == 421) {
                        $('#errorMessage').removeClass('d-none');
                        $('#errorMessage').text(res.message);
                        $("#errorMessage").fadeTo(2000, 500).slideUp(500, function(){
                        $("#errorMessage").slideUp(1000);
                        });
                    }else if(res.status == 199){

                        // $('#errorMessage').addClass('d-none');
                     
                        alertify.set('notifier','position', 'top-right');
                        alertify.success(res.message);
                        $('#facultyAddModal').modal('hide');
                        $('#savefaculty')[0].reset();
                        setTimeout(function(){
						location.reload()
					},500)
                    }else if(res.status == 500) {
                        alert(res.message);
                    }
                }
            });

        });


 $(document).on('click', '.editFacultyBtn', function () {

var faculty_id = $(this).val();
$.ajax({
    type: "GET",
    url: "function.php?faculty_id=" + faculty_id,
    success: function (response) {

        var res = jQuery.parseJSON(response);
        if(res.status == 404) {

            alert(res.message);
        }else if(res.status == 200){

            $('#faculty_id').val(res.data.Id);
            $('#firstname').val(res.data.Firstname);
            $('#middlename').val(res.data.Middlename);
            $('#lastname').val(res.data.Lastname);
            $('#email').val(res.data.Email);
            $('#faculty_image_old').val(res.data.Faculty_img);
            $('#phonenumber').val(res.data.phonenumber);  
            $('#editimg').attr('src',"Faculty_img/" + res.data.Faculty_img);  
            $('#facultyEditModal').modal('show');
        }
  }
});
});

$(document).on('submit', '#updateFaculty', function (e) {
e.preventDefault();
var formData = new FormData(this);
formData.append("update_faculty", true);

$.ajax({
    type: "POST",
    url: "function.php",
    data: formData,
    processData: false,
    contentType: false,
    success: function (response) {  
        var res = jQuery.parseJSON(response);
        if(res.status == 422) {
            alertify.set('notifier','position', 'top-right');
            alertify.warning(res.message); 

        }else if(res.status == 200){

            $('#errorMessageUpdate').addClass('d-none');

            alertify.set('notifier','position', 'top-right');
            alertify.success(res.message);
            
            $('#facultyEditModal').modal('hide');
            $('#updateFaculty')[0].reset();

            fetchFaculty();

        }else if(res.status == 500) {
            alert(res.message);
        }
    }
});
});

$(document).on('submit', '#delete_Faculty', function (e) {
            e.preventDefault();

            if(confirm('Are you sure you want to delete this data?'))
            {
                var formData = new FormData(this);
                formData.append("delete_faculty", true);
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
                            fetchFaculty();
                        }
                    }
                });
            }
        });


$(document).on('click', '.viewFacultyBtn', function () {

var faculty_id = $(this).val();
$.ajax({
    type: "GET",
    url: "function.php?faculty_id=" + faculty_id,
    success: function (response) {

        var res = jQuery.parseJSON(response);
        if(res.status == 404) {

            alert(res.message);
        }else if(res.status == 200){     
            $('#view_firstname').text(res.data.Firstname);
            $('#view_middlename').text(res.data.Middlename);
            $('#view_lastname').text(res.data.Lastname);
            $('#view_email').text(res.data.Email); 
            $('#view_phone_number').text(res.data.phonenumber);  
            $('#img').attr('src',"Faculty_img/" + res.data.Faculty_img);                                  
            $('#facultyViewModal').modal('show');
        }
    }
});
});
$('#facultyAddModal').on('hidden.bs.modal', function () {
    $(this).find('form').trigger('reset');
   
})
</script>	
