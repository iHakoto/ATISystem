<?php
include 'auth.php';
if(!isset($_SESSION)){
    session_start();
}
 include 'database/db_connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $_SESSION['system']['name'] ?></title>
</head>
<body >  
<!-- EDIT POP UP FORM (Bootstrap MODAL) -->
<div class="modal fade" id="editUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <form id="updateUser">
            <div class="modal-body">
                <div id="errorMessageUpdate" class="alert alert-warning d-none"></div>
                <input type="hidden" name="update_user_id" id="update_user_id" >
                <div class="mb-3">
                    <label for="">User Name</label>
                    <input type="text" name="update_username" id="update_username" class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="">Password</label>
                    <input type="password" name="update_password" id="update_password" class="form-control" />
                    <small><i>Leave this blank if you don't want to change password.</i></small>
                </div>
                <input type="hidden" name="update_access_id" id="update_access_id" >
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Update Password</button>
            </div>
        </form>
        </div>
    </div>
</div>
<!-- END EDIT POP UP FORM (Bootstrap MODAL) -->

<!-- View Student Modal -->
<div class="modal fade" id="userViewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">View Admin</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
        </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="">User Name</label>
                    <p id="view_username" class="form-control"></p>
                </div>
                           
                <div class="mb-3">
                 <label for="">Access</label>           
                <select name="view_access_id" id="view_access_id" class="custom-select">
                    <option value="">select class</option>
                        <?php 
                        $access = $connection->query("SELECT * FROM access");
                        while($row=$access->fetch_assoc()):           
                        ?>
                        <option value="<?php echo $row['Id'] ?>"><?php echo $row['Access'] ?></option>
                    <?php endwhile; ?>
                </select>               
                </div> 
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
			<div class="col-md-12">
				<div class="card ">
					<div class="card-header" >
						<h4><b >List of Users</b></h4>
					</div>
					<div class="table-responsive">
					<div class="card-body">
						<table id ="myTable"class="table table-sm table-hover">
							<thead>
								<tr>							
									<th class="text-center">Id</th>
                                    <th>User Name</th>     
                                    <th>Access</th>   
                                    <th>Action</th>         
									<!-- <th class="text-center">Action</th> -->
								</tr>
							</thead>
							<tbody>
                            <?php
                             $i = 1;
                             $sql = $connection->query("SELECT u.*, a.Access FROM users u inner join access a on u.access = a.Id");
                             while($row = $sql->fetch_assoc()): ?>
                                <tr>
								<td class="text-center"><?php echo $i++; ?></td>
                        		 <td>  <?php echo $row ['username'];?></td>
                                 <td>  <?php echo $row ['Access'];?></td>
                       			<td class="text-center">
                                     <!-- <button type="button" value="<?=$row['Id']?>" class="viewUserBtn btn btn-info btn-sm"><i class="bi bi-eye"></i> View</button>	  -->
                                     <button type="button" value="<?=$row['Id'];?>" class="editUser btn btn-success btn-sm"><i class="fa fa-edit"></i> Edit</button>
                                </td>
                                     <!-- <button type="button" value="<?=$row['Id'];?>" class="deleteUserBtn btn btn-danger btn-sm"><i class="bi bi-trash"></i> Delete</button>							 -->
								
                                    </tr>
                                 <?php endwhile; ?>																									
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
	$('#myTable').dataTable();
})
    
 $(document).on('click', '.editUser', function () {
var update_user_id = $(this).val();
console.log(update_user_id);
$.ajax({
    type: "GET",
    url: "function.php?update_user_id=" + update_user_id,
    success: function (response) {
        console.log(response);
        var res = jQuery.parseJSON(response);
        if(res.status == 404) {
            alert(res.message);
        }else if(res.status == 200){
            $('#update_user_id').val(res.data.Id);
            $('#update_username').val(res.data.username);
            $('#update_access_id').val(res.data.access);
            $('#editUser').modal('show');
        }
  }
});
});

$(document).on('submit', '#updateUser', function (e) {
e.preventDefault();
var formData = new FormData(this);
formData.append("update_user", true);

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

            $('#errorMessageUpdate').addClass('d-none');

            alertify.set('notifier','position', 'top-right');
            alertify.success(res.message);
            
            $('#userEditModal').modal('hide');
            $('#updateUser')[0].reset();

            setTimeout(function(){
						location.reload()
					},500)

        }else if(res.status == 500) {
            alert(res.message);
        }
    }
});
});

$(document).on('click', '.deleteUserBtn', function (e) {
            e.preventDefault();

            if(confirm('Are you sure you want to delete this data?'))
            {
                var user_id = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "function.php",
                    data: {
                        'delete_user': true,
                        'user_id': user_id
                    },
                    success: function (response) {

                        var res = jQuery.parseJSON(response);
                        if(res.status == 500) {

                            alert(res.message);
                        }else{
                            alertify.set('notifier','position', 'top-right');
                            alertify.success(res.message);
                           setTimeout(function(){
						location.reload()
					},500)
                        }
                    }
                });
            }
        });


$(document).on('click', '.viewUserBtn', function () {

var user_id = $(this).val();
$.ajax({
    type: "GET",
    url: "function.php?user_id=" + user_id,
    success: function (response) {

        var res = jQuery.parseJSON(response);
        if(res.status == 404) {

            alert(res.message);
        }else if(res.status == 200){     
            $('#view_details_id').text(res.data.details_id);           
            $('#view_username').text(res.data.username);
            $('#view_access_id').val(res.data.access);                      
            $('#userViewModal').modal('show');
        }
    }
});
});
</script>	

