<?php

 include 'database/db_connect.php';
 include 'auth.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php echo $_SESSION['system']['name'] ?></title>
</head>

<body >
   <!-- Add Modal -->
    <div class="modal fade" id="subjectAddModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"> <b>Add Subject</b></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <form id="savesubject">
            <div class="modal-body">

                <div id="errorMessage" class="alert alert-warning d-none"></div>
                <div class="mb-3">
                    <label for="">Grade Subject</label>
                    <input type="text" name="subject" class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="">Description</label>
                    <input type="text" name="description" class="form-control" placeholder ="Indicate Grade Level"/>
                    
                </div>
          
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="bi bi-x-octagon"></i> Cancel</button>
                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Save</button>
            </div>
        </form>
        </div>
    </div>
</div>
  <!-- Add Modal -->


<!-- EDIT POP UP FORM (Bootstrap MODAL) -->
<div class="modal fade" id="subjectEditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"> <b>Edit Subject</b></h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form id="updateSubject">
            <div class="modal-body">
                <!-- <div id="errorMessageUpdate" class="alert alert-warning d-none"></div> -->
                <input type="hidden" name="subject_id" id="subject_id" >
                <div class="mb-3">
                    <label for="">Subject</label>
                    <input type="text" name="subject" id="subject" class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="">Description</label>
                    <input type="text" name="description" id="description" class="form-control"  placeholder ="Indicate Grade Level"/>
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
						<h4><b >List of Subjects</b></h4>
						<span class="float:right"><button type="button" class="btn btn-primary btn-block btn-sm col-sm-2 float-right" data-toggle="modal" data-target="#subjectAddModal">
						<i class="fa fa-book"></i> Add Subject</button></span>
					</div>
                    <div class="table-responsive">
					<div class="card-body">
						<table id ="myTable"class="table table-sm table-hover">
							<thead>
								<tr>							
									<th class="text-center">#</th>
                                    <th class="text-center">Subject</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
                            <?php $i = 1; 
                            $sql = "SELECT * FROM subjects ORDER BY Id DESC";
                            $sql = $connection->query($sql) or die ($connection->error);
    
                            while($row = $sql->fetch_assoc()):?>
                                <tr>
                                <td class="text-center"><?php echo $i++; ?></td>
                        		 <td class="text-center">
                                    <p><b><?php echo ucwords($row['Subject']) ?></b></p>
										<small><i><?php echo $row['Description'] ?></i></small>
                                    </td>                       
                       			  <td class="text-center">                                  
                                     <button type="button" value="<?=$row['Id'];?>" class="editSubjectBtn btn btn-success btn-sm"><i class="fa fa-edit"></i></button>
                                     <button type="button" value="<?=$row['Id'];?>" class="deleteSubjectBtn btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>							
									</td>
                                    </tr>
                              <?php endwhile;?>																								
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
    $(document).on('submit', '#savesubject', function (e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_subject", true);

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
                    }else if(res.status == 201){

                        // $('#errorMessage').addClass('d-none');
                     
                        alertify.set('notifier','position', 'top-right');
                        alertify.success(res.message);
                        $('#subjectAddModal').modal('hide');
                        $('#savesubject')[0].reset();
                        setTimeout(function(){
						location.reload()
					},500)
                    }else if(res.status == 500) {
                        alert(res.message);
                    }
                }
            });

        });

        $(document).on('submit', '#updateSubject', function (e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("update_subject", true);

            $.ajax({
                type: "POST",
                url: "function.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    
                    var res = jQuery.parseJSON(response);
                    if(res.status == 422 || res.status == 421) {
                        // $('#errorMessageUpdate').removeClass('d-none');
                        // $('#errorMessageUpdate').text(res.message);

                        alertify.set('notifier','position', 'top-right');
                        alertify.warning(res.message);
                    }else if(res.status == 200){

                        // $('#errorMessage').addClass('d-none');
                     
                        alertify.set('notifier','position', 'top-right');
                        alertify.success(res.message);
                        $('#subjectAddModal').modal('hide');
                        $('#savesubject')[0].reset();
                        setTimeout(function(){
						location.reload()
					},500)
                    }else if(res.status == 500) {
                        alert(res.message);
                    }
                }
            });

        });
 $(document).on('click', '.editSubjectBtn', function () {

var subject_id = $(this).val();
$.ajax({
    type: "GET",
    url: "function.php?subject_id=" + subject_id,
    success: function (response) {

        var res = jQuery.parseJSON(response);
        if(res.status == 404) {

            alert(res.message);
        }else if(res.status == 200){

            $('#subject_id').val(res.data.Id);
            $('#subject').val(res.data.Subject);
            $('#description').val(res.data.Description);
            $('#subjectEditModal').modal('show');
        }
  }
});
});

$(document).on('click', '.deleteSubjectBtn', function (e) {
            e.preventDefault();
            if(confirm('Are you sure you want to delete this data?'))
            {
                var subject_id = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "function.php",
                    data: {
                        'delete_subject': true,
                        'subject_id': subject_id
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
        $('#subjectAddModal').on('hidden.bs.modal', function () {
            $(this).find('form').trigger('reset');
        })
</script>	

