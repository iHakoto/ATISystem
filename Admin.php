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
    <div class="modal fade" id="adminAddModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"> <b>Add Admin</b></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <form id="saveadmin">
            <div class="modal-body">

                <div id="errorMessage" class="alert alert-warning d-none"></div>
                <center><img id ="admin_image" src="img/Img.png" class="border border-dark" width= "25%" height="25%" alt="Admin Image"></center>
                <div class="mb-3">
                    <label for="">Image</label>
                    <input type="file" class="form-control" name="admin_img" onchange="displayImg(this,$(this))"/>
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
                    <label for="">Admin Email</label>
                    <input type="email" name="email" class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="">Admin Phone number</label>
                    <input type="text" name="phonenumber" class="form-control" placeholder="Ex. 09*********" maxlength="11" />
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="bi bi-x-octagon"></i> Cancel</button>
                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Save Admin</button>
            </div>
        </form>
        </div>
    </div>
</div>
  <!-- Add Modal -->

<!-- EDIT POP UP FORM (Bootstrap MODAL) -->
<div class="modal fade" id="adminEditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"> <b>Edit Admin</b></h5>

                     <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
        </div>
        <form id="updateAdmin">
            <div class="modal-body">
                <div id="errorMessageUpdate" class="alert alert-warning d-none"></div>
                <input type="hidden" name="admin_id" id="admin_id" >
                <center><img id ="editimg" src=""  class="border border-dark" width= "100px" alt="Admin Image"></center> 
                <br>
                <div class="mb-3">
                <input type="file" class="form-control" name="admin_img" onchange="displayImgEdit(this,$(this))"/>
            
                    <input type="hidden" name="admin_img_old" id="admin_image_old" class="form-control"/>                  
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
                    <input type="text" name="email" id="email" class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="">Phone number</label>
                    <input type="text" name="phonenumber" id="phonenumber" class="form-control" />
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

<!-- View Student Modal -->
<div class="modal fade" id="adminViewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"> <b>View Admin</b> </h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
        </div>
            <div class="modal-body">
            <center><img id ="img" src=""  class="border border-dark" width= "100px" alt="Admin Image"></center>  
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
                    <h4><b >List of Admin</b></h4>
                    <span class="float:right"><button type="button" class="btn btn-primary btn-block btn-sm col-sm-2 float-right" data-toggle="modal" data-target="#adminAddModal">
						<i class="fas fa-user-plus"></i> New Admin</button></span>
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


<script>
        // Function to fetch grades based on both filters
        function fetchAdmin() {
                $.ajax({
                    url: 'fetch_admin.php', // PHP file to fetch data
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
        fetchAdmin(); // Automatically fetch data when the page loads
    });
</script>
<style>
td{
		vertical-align: middle !important;
	}
	td p{
		margin: unset
	}
    
	</style>


<script>
    function displayImg(input,_this) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
        	$('#admin_image').attr('src', e.target.result);
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
    $(document).ready(function () {
	$('#myTable').dataTable();
})
    $(document).on('submit', '#saveadmin', function (e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_admin", true);

            $.ajax({
                type: "POST",
                url: "function.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    
                    var res = jQuery.parseJSON(response);
                    if(res.status == 422 || res.status == 421) {
                        alertify.set('notifier','position', 'top-right');
                        alertify.warning(res.message); 
                    }else if(res.status == 199){

                        // $('#errorMessage').addClass('d-none');
                     
                        alertify.set('notifier','position', 'top-right');
                        alertify.success(res.message);
                        $('#adminAddModal').modal('hide');
                        $('#saveadmin')[0].reset();
                        setTimeout(function(){
						location.reload()
					},500)
                    }else if(res.status == 500) {
                        alert(res.message);
                    }
                }
            });

        });


 $(document).on('click', '.editAdminBtn', function () {

var admin_id = $(this).val();
$.ajax({
    type: "GET",
    url: "function.php?admin_id=" + admin_id,
    success: function (response) {

        var res = jQuery.parseJSON(response);
        if(res.status == 404) {

            alert(res.message);
        }else if(res.status == 200){

            $('#admin_id').val(res.data.Id);
            $('#firstname').val(res.data.Firstname);
            $('#middlename').val(res.data.Middlename);
            $('#lastname').val(res.data.Lastname);
            $('#email').val(res.data.Email);
            $('#admin_image_old').val(res.data.Admin_img);
            $('#phonenumber').val(res.data.phonenumber);
            $('#editimg').attr('src',"Admin_img/" + res.data.Admin_img);    
            $('#adminEditModal').modal('show');
        }
  }
});
});

$(document).on('submit', '#updateAdmin', function (e) {
e.preventDefault();
var formData = new FormData(this);
formData.append("update_admin", true);

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

            // $('#errorMessageUpdate').addClass('d-none');

            alertify.set('notifier','position', 'top-right');
            alertify.success(res.message);
            
            $('#adminEditModal').modal('hide');
            $('#updateAdmin')[0].reset();

            setTimeout(function() {
                                fetchAdmin();
                            }, 500);

        }else if(res.status == 500) {
            alert(res.message);
        }
    }
});
});

$(document).on('submit', '#delete_Admin', function (e) {
            e.preventDefault();

            if(confirm('Are you sure you want to delete this data?'))
            {
                var formData = new FormData(this);
                formData.append("delete_admin", true);
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
                                fetchAdmin();
                            }, 500);
                        }
                    }
                });
            }
        });


$(document).on('click', '.viewAdminBtn', function () {

var admin_id = $(this).val();
$.ajax({
    type: "GET",
    url: "function.php?admin_id=" + admin_id,
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
            $('#img').attr('src',"Admin_img/" + res.data.Admin_img);                          
            $('#adminViewModal').modal('show');
        }
    }
});
});

$('#adminAddModal').on('hidden.bs.modal', function () {
    $(this).find('form').trigger('reset');
})
</script>	

