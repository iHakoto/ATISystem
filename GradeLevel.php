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
    <div class="modal fade" id="gradelevelAddModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"> <b>Add GradeLevel</b> </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <form id="savegradelevel">
            <div class="modal-body">

                <div id="errorMessage" class="alert alert-warning d-none"></div>
                <div class="mb-3">
                    <label for="">Grade Level</label>
                    <input type="text" name="gradelevel" class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="">Description</label>
                    <input type="text" name="description" class="form-control" />
                </div>
          
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="bi bi-x-octagon"></i> Cancel</button>
                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Save</button>
            </div>
        </form>
        </div>
    </div>
</div>
  <!-- Add Modal -->


<!-- EDIT POP UP FORM (Bootstrap MODAL) -->


<div class="modal fade" id="gradelevelEditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"> <b>Edit Grade Level</b> </h5>

                     <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
        </div>
        <form id="updateGradelevel">
            <div class="modal-body">

                <!-- <div id="errorMessageUpdate" class="alert alert-warning d-none"></div> -->
                <input type="hidden" name="gradelevel_id" id="gradelevel_id" >
                <div class="mb-3">
                    <label for="">Grade Level</label>
                    <input type="text" name="gradelevel" id="firstname" class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="">Description</label>
                    <input type="text" name="description" id="middlename" class="form-control" />
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
						<h4><b >Grade Levels</b></h4>
						<span class="float:right"><button type="button" class="btn btn-primary btn-block btn-sm col-sm-2 float-right" data-toggle="modal" data-target="#gradelevelAddModal">
						<i class="bi bi-book"></i> Add Grade level</button></span>
					</div>
                    <div class="table-responsive">
					<div class="card-body">
						<table id ="myTable"class="table table-sm table-hover">
							<thead>
								<tr>							
									<th class="text-center">#</th>
                                    <th class="text-center">Grade Level</th>
                                 
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
                            <?php $i = 1; 
                            $sql = $connection->query("SELECT * FROM gradelevel ORDER BY Gradelevel ASC");
                            while($row = $sql->fetch_assoc()):
                             ?>
                             
                                <tr>
					      
								<td class="text-center"><?php echo $i++; ?></td>
                        		 <td class="text-center">
                                    <p><b><?php echo ucwords($row['Gradelevel']) ?></b></p>
										<small><i><?php echo $row['Description'] ?></i></small>
                                    </td>                       
                       			  <td class="text-center">                                  
                                     <button type="button" value="<?=$row['Id'];?>" class="editGradelevelBtn btn btn-success btn-sm"><i class="fa fa-edit"></i></button>
                                     <button type="button" value="<?=$row['Id'];?>" class="deleteGradelevelBtn btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>							
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

<script></script>


<script>
    $(document).ready(function () {
	$('#myTable').dataTable();
})
    $(document).on('submit', '#savegradelevel', function (e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_gradelevel", true);

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
                        $('#gradelevelAddModal').modal('hide');
                        $('#savegradelevel')[0].reset();
                        setTimeout(function(){
						location.reload()
					},500)
                    }else if(res.status == 500) {
                        alert(res.message);
                    }
                }
            });

        });


 $(document).on('click', '.editGradelevelBtn', function () {

var gradelevel_id = $(this).val();
$.ajax({
    type: "GET",
    url: "function.php?gradelevel_id=" + gradelevel_id,
    success: function (response) {

        var res = jQuery.parseJSON(response);
        if(res.status == 404) {

            alert(res.message);
        }else if(res.status == 200){

            $('#gradelevel_id').val(res.data.Id);
            $('#firstname').val(res.data.Gradelevel);
            $('#middlename').val(res.data.Description);
            $('#gradelevelEditModal').modal('show');
        }

  }
});

});

$(document).on('submit', '#updateGradelevel', function (e) {
e.preventDefault();
var formData = new FormData(this);
formData.append("update_gradelevel", true);

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

            //$('#errorMessageUpdate').addClass('d-none');

            alertify.set('notifier','position', 'top-right');
            alertify.success(res.message);
            
            $('#gradelevelEditModal').modal('hide');
            $('#updateGradelevel')[0].reset();

            setTimeout(function(){
						location.reload()
					},500)

        }else if(res.status == 500) {
            alert(res.message);
        }
    }
});
});

$(document).on('click', '.deleteGradelevelBtn', function (e) {
            e.preventDefault();

            if(confirm('Are you sure you want to delete this data?'))
            {
                var gradelevel_id = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "function.php",
                    data: {
                        'delete_gradelevel': true,
                        'gradelevel_id': gradelevel_id
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

        $('#gradelevelAddModal').on('hidden.bs.modal', function () {
    $(this).find('form').trigger('reset');
})
</script>	

