<?php
 include 'auth.php';
 include 'database/db_connect.php';
 
?>
<?php
$loginId = null;

// Check if either the Admin or Faculty session ID is set
if (isset($_SESSION['login_Admin_Id']) && $_SESSION['login_Admin_Id'] != 0) {
    $loginId = $_SESSION['login_Admin_Id']; // Assign Admin ID if set and not zero
} elseif (isset($_SESSION['login_Faculty_Id']) && $_SESSION['login_Faculty_Id'] != 0) {
    $loginId = $_SESSION['login_Faculty_Id']; // Assign Faculty ID if set and not zero
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php echo $_SESSION['system']['name'] ?></title>
</head>

<body >
    
   <!-- Add Modal -->
    <div class="modal fade" id="announcementAddModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"> <b>Add Announcement</b> </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <form id="saveannouncement">
            <div class="modal-body">

                <div id="errorMessage" class="alert alert-warning d-none"></div>
                <input type="hidden" name="type" value ="School" class="form-control" />
                <input type="hidden" name="ID" value="<?= $loginId ?>" />

                <div class="mb-3">
                    <label for="">Title</label>
                    <input type="text" name="title" class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="">Description</label>
                    <input type="text" name="description" class="form-control" />
                </div>
                <!-- <div class="mb-3">
                        <label for="">Day</label>
                        <select name="edit_day_of_week" id="edit_day_of_week" class="custom-select">
                            <option value="">Select Day</option>
                            <?php 
                            $subject = $connection->query("SELECT * FROM days order by Id asc");
                            while($row=$subject->fetch_assoc()):
                            ?>
                            <option value="<?php echo $row['Id'] ?>"><?php echo $row['day'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div> -->
                <div class="mb-3">
                        <label for="start_time">Start Time</label>
                        <input type="time" id="start_time" name="start_time" class="form-control">
                </div>
                    <div class="mb-3">
                        <label for="end_time">End Time</label>
                        <input type="time" id="end_time" name="end_time" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="date">Select Date</label>
                        <input type="date" name="announce_date" class="form-control" />
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


<div class="modal fade" id="announcementEditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"> <b>Edit Announcement</b> </h5>

                     <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
        </div>
        <form id="updateannouncement">
            <div class="modal-body">

                <!-- <div id="errorMessageUpdate" class="alert alert-warning d-none"></div> -->
                <input type="hidden" name="announcement_id" id="announcement_id" >
                <div class="mb-3">
                    <label for="">Title</label>
                    <input type="text" name="edit_title" id="edit_title" class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="">Description</label>
                    <input type="text" name="edit_description" id="edit_description" class="form-control" />
                </div>
                <div class="mb-3">
                        <label for="start_time">Start Time</label>
                        <input type="time" name="edit_start_time" id="edit_start_time" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="end_time">End Time</label>
                        <input type="time" name="edit_end_time" id="edit_end_time" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="date">Select Date</label>
                        <input type="date" name="edit_announce_date" id="edit_announce_date" class="form-control" />
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
	
		<div class="row">
			<!-- FORM Panel -->

			<!-- Table Panel -->
			<div class="col-md-12">
				<div class="card ">
					<div class="card-header" >
						<h4><b >Announcement</b></h4>
						<span class="float:right"><button type="button" class="btn btn-primary btn-block btn-sm col-sm-2 float-right" data-toggle="modal" data-target="#announcementAddModal">
						<i class="bi bi-book"></i> Add Announcement</button></span>
					</div>
                    <div class="table-responsive">
					<div class="card-body">
						<table id ="myTable"class="table table-sm table-hover">
							<thead>
								<tr>							
									<th class="text-center">#</th>
                                    <th class="text-center">Announcement</th>
                                    <th class="text-center">Date</th>
                                    <th class="text-center">Time</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
                            <?php $i = 1; 
                            $sql = $connection->query("SELECT Id,title,announce_date, concat(DATE_FORMAT(start_time, '%l:%i %p'),'-',DATE_FORMAT(end_time, '%l:%i %p')) as `time` FROM announcement ORDER BY start_time ASC");
                            while($row = $sql->fetch_assoc()):
                             ?>
                             
                                <tr>
					      
								<td class="text-center"><?php echo $i++; ?></td>
                        		 <td class="text-center">
                                    <p><b><?php echo ucwords($row['title']) ?></b></p>
                                    </td>        
                                    <td class="text-center">
                                    <p><b><?php echo date('l, F j, Y', strtotime($row['announce_date'])); ?></b></p>
                                    </td>               
                                    <td class="text-center">
                                    <p><b><?php echo ucwords($row['time']) ?></b></p>
                                    </td> 
                       			  <td class="text-center">                                  
                                     <button type="button" value="<?=$row['Id'];?>" class="editannouncementBtn btn btn-success btn-sm"><i class="fa fa-edit"></i></button>
                                     <button type="button" value="<?=$row['Id'];?>" class="deleteannouncementBtn btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>							
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
    $(document).on('submit', '#saveannouncement', function (e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_announcement", true);

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
                        $('#announcementAddModal').modal('hide');
                        $('#saveannouncement')[0].reset();
                        setTimeout(function(){
						location.reload()
					},500)
                    }else if(res.status == 500) {
                        alert(res.message);
                    }
                }
            });

        });


 $(document).on('click', '.editannouncementBtn', function () {

var announcement_id = $(this).val();
$.ajax({
    type: "GET",
    url: "function.php?announcement_id=" + announcement_id,
    success: function (response) {

        var res = jQuery.parseJSON(response);
        if(res.status == 404) {

            alert(res.message);
        }else if(res.status == 200){

            $('#announcement_id').val(res.data.Id);
            $('#edit_title').val(res.data.title);
            $('#edit_description').val(res.data.description);
            $('#edit_start_time').val(res.data.start_time);
            $('#edit_end_time').val(res.data.end_time);
            $('#edit_announce_date').val(res.data.announce_date);
            $('#announcementEditModal').modal('show');
        }

  }
});

});

$(document).on('submit', '#updateannouncement', function (e) {
e.preventDefault();
var formData = new FormData(this);
formData.append("update_announcement", true);

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
            
            $('#announcementEditModal').modal('hide');
            $('#updateannouncement')[0].reset();

            setTimeout(function(){
						location.reload()
					},500)

        }else if(res.status == 500) {
            alert(res.message);
        }
    }
});
});

$(document).on('click', '.deleteannouncementBtn', function (e) {
            e.preventDefault();

            if(confirm('Are you sure you want to delete this data?'))
            {
                var announcement_id = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "function.php",
                    data: {
                        'delete_announcement': true,
                        'announcement_id': announcement_id
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

        $('#announcementAddModal').on('hidden.bs.modal', function () {
    $(this).find('form').trigger('reset');
})
</script>	

