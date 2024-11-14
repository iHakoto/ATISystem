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
   <div class="modal fade" id="class_subjectAddModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><b>Add Class Subject</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form id="saveclass_subject">
                <div class="modal-body">

                    <div id="errorMessage" class="alert alert-warning d-none"></div>

                    <div class="mb-3">
                        <label for="">Class</label>
                        <select name="class_id" id="class_id" class="custom-select">
                            <option value="">Select class</option>
                            <?php 
                            $gradelevel = $connection->query("SELECT c.*,concat(glevel.Gradelevel,'-',c.Section) as `class` FROM `class` c inner join gradelevel glevel on glevel.Id = c.Gradelevel_Id order by 
                            concat(glevel.Gradelevel,' ','-',c.Section) asc");
                            while($row=$gradelevel->fetch_assoc()):           
                            ?>
                            <option value="<?php echo $row['Id'] ?>"><?php echo $row['class'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Faculty</label>
                        <select name="faculty_id" id="faculty_id" class="custom-select">
                            <option value="">Select faculty</option>
                            <?php 
                            $faculty = $connection->query("SELECT * FROM faculty");
                            while($row=$faculty->fetch_assoc()):
                            ?>
                            <option value="<?php echo $row['Id'] ?>"><?php echo $row['Firstname'] ?> <?php echo $row['Middlename'] ?> <?php echo $row['Lastname'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="">Subject</label>
                        <select name="subject_id" id="subject_id" class="custom-select">
                            <option value="">Select subject</option>
                            <?php 
                            $subject = $connection->query("SELECT * FROM subjects order by Id asc");
                            while($row=$subject->fetch_assoc()):
                            ?>
                            <option value="<?php echo $row['Id'] ?>"><?php echo $row['Subject'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <!-- Start and End Time Inputs -->
                    <div class="mb-3">
                        <label for="start_time">Start Time</label>
                        <input type="time" id="start_time" name="start_time" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="end_time">End Time</label>
                        <input type="time" id="end_time" name="end_time" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="">Day</label>
                        <select name="day_of_week" id="day_of_week" class="custom-select">
                            <option value="">Select Day</option>
                            <?php 
                            $subject = $connection->query("SELECT * FROM days order by Id asc");
                            while($row=$subject->fetch_assoc()):
                            ?>
                            <option value="<?php echo $row['Id'] ?>"><?php echo $row['day'] ?></option>
                            <?php endwhile; ?>
                        </select>
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
<div class="modal fade" id="class_subjectEditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"> <b>Edit Class Subject</b> </h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
        </div>
        <form id="updateclass_subject">
            <div class="modal-body">
        
                <!-- <div id="errorMessage" class="alert alert-warning d-none"></div> -->
                <input type="hidden" name="class_subject_Id" id="class_subject_Id" >
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
               <div class="mb-3">
                <label >Faculty</label>
                    <select name="faculty_Id" id="faculty_Id" class="custom-select">
                    <option value="">select faculty</option>
                                <?php 
                                $faculty = $connection->query("SELECT * FROM faculty ");
                                while($row=$faculty->fetch_assoc()):
                                ?>
                                <option value="<?php echo $row['Id'] ?>"><?php echo $row['Firstname'] ?> <?php echo $row['Middlename'] ?> <?php echo $row['Lastname'] ?></option>
                            <?php endwhile; ?>
                    </select>
                 </div>
                 <div class="mb-3">
                <label for="">Subject</label>
                     <select name="subject_Id" id="subject_Id" class="custom-select">
                    <option value="">select subject</option>
                                <?php 
                                $subject = $connection->query("SELECT * FROM subjects order by Id asc");
                                while($row=$subject->fetch_assoc()):
                                ?>
                                <option value="<?php echo $row['Id'] ?>"><?php echo $row['Subject'] ?></option>
                            <?php endwhile; ?>
                            </select>
                </div>
            <!-- Start and End Time Inputs -->
            <div class="mb-3">
                        <label for="start_time">Start Time</label>
                        <input type="time" id="edit_start_time" name="edit_start_time" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="end_time">End Time</label>
                        <input type="time" id="edit_end_time" name="edit_end_time" class="form-control">
                    </div>
                    <div class="mb-3">
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
                    </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-x-octagon"></i> Cancel</button>
                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Save</button>
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
                        <h4><b >Class Schedule</b></h4>
                        <?php if($_SESSION['login_access'] == 3){?>  
                        <span class="float:right"><button type="button" class="btn btn-primary btn-block btn-sm col-sm-2 float-right" data-toggle="modal" data-target="#class_subjectAddModal">
                        <i class="fa fa-list-alt"></i> New Entry</button></span>
                        <?php } ?> 
                    </div>
                    <?php if(($_SESSION['login_access'] == 2)  ){ ?>
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
                        <?php } ?> 
                    <div class="table-responsive">
					<div class="card-body">
						<table id ="myTable"class="table table-sm table-hover">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="text-center">Class</th>
									<th class="text-center">Subject</th>
									<th class="text-center">Faculty</th>
                                    <th class="text-center">Schedule</th>
                                  <?php if($_SESSION['login_access'] == 3){?>   
									<th class="text-center">Action</th>
                                    <?php } ?> 
								</tr>
							</thead>
							<tbody>
                            <?php 
                                $faculty_id = $_SESSION['login_Faculty_Id'];  // Retrieve the faculty ID from session

                                // Check the login access level
                                if ($_SESSION['login_access'] == 2) {
                                    // Prepare the SQL statement for faculty-specific subjects
                                    $stmt = $connection->prepare("
                                        SELECT cs.*, 
                                            CONCAT(g.Gradelevel, '-', c.Section) AS `class`,
                                            s.Subject AS subject, 
                                            CONCAT(f.Firstname, ' ', f.Middlename, ' ', f.Lastname) AS fullname,
                                            CONCAT('(', d.day, ') ', 
                                                    DATE_FORMAT(cs.start_time, '%l:%i %p'), '-', 
                                                    DATE_FORMAT(cs.end_time, '%l:%i %p')) AS `schedule` 
                                        FROM class_subjects cs 
                                        LEFT JOIN `class` c ON c.Id = cs.class_id 
                                        INNER JOIN gradelevel g ON g.Id = c.Gradelevel_Id 
                                        LEFT JOIN faculty f ON f.Id = cs.faculty_id 
                                        LEFT JOIN subjects s ON s.Id = cs.subject_id 
                                        LEFT JOIN days d ON d.Id = cs.day 
                                        WHERE f.Id = ? 
                                        ORDER BY CONCAT(g.Gradelevel, '-', c.Section) ASC;
                                    ");
                                    // Bind the faculty ID to the placeholder and execute the statement
                                    $stmt->bind_param("i", $faculty_id); // 'i' indicates that $faculty_id is an integer
                                } elseif($_SESSION['login_access'] == 1){
                                    $student_id = $_SESSION['login_Student_Id'];
                                    $student_class_id = $_SESSION['login_stud_class_id'];

                                    $stmt = $connection->prepare("
                                    SELECT cs.*, 
                                        CONCAT(g.Gradelevel, '-', c.Section) AS `class`,
                                        s.Subject AS subject, 
                                        CONCAT(f.Firstname, ' ', f.Middlename, ' ', f.Lastname) AS fullname,
                                        CONCAT('(', d.day, ') ', 
                                                DATE_FORMAT(cs.start_time, '%l:%i %p'), '-', 
                                                DATE_FORMAT(cs.end_time, '%l:%i %p')) AS `schedule` 
                                    FROM class_subjects cs 
                                    LEFT JOIN `class` c ON c.Id = cs.class_id 
                                    INNER JOIN gradelevel g ON g.Id = c.Gradelevel_Id 
                                    LEFT JOIN faculty f ON f.Id = cs.faculty_id 
                                    LEFT JOIN subjects s ON s.Id = cs.subject_id 
                                    LEFT JOIN days d ON d.Id = cs.day 
                                    WHERE cs.class_id = ? 
                                    ORDER BY CONCAT(g.Gradelevel, '-', c.Section) ASC;
                                ");
                                // Bind the faculty ID to the placeholder and execute the statement
                                $stmt->bind_param("i", $student_class_id); // 'i' indicates that $faculty_id is an integer

                                }else {
                                    // Prepare the SQL statement for all subjects
                                    $stmt = $connection->prepare("
                                        SELECT cs.*, 
                                            CONCAT(g.Gradelevel, '-', c.Section) AS `class`,
                                            s.Subject AS subject, 
                                            CONCAT(f.Firstname, ' ', f.Middlename, ' ', f.Lastname) AS fullname,
                                            CONCAT('(', d.day, ') ', 
                                                    DATE_FORMAT(cs.start_time, '%l:%i %p'), '-', 
                                                    DATE_FORMAT(cs.end_time, '%l:%i %p')) AS `schedule` 
                                        FROM class_subjects cs 
                                        LEFT JOIN `class` c ON c.Id = cs.class_id 
                                        INNER JOIN gradelevel g ON g.Id = c.Gradelevel_Id 
                                        LEFT JOIN faculty f ON f.Id = cs.faculty_id 
                                        LEFT JOIN subjects s ON s.Id = cs.subject_id 
                                        LEFT JOIN days d ON d.Id = cs.day 
                                        ORDER BY CONCAT(g.Gradelevel, '-', c.Section) ASC;
                                    ");
                                }

                                // Execute the statement
                                $stmt->execute();
                                // Initialize the $i variable to start numbering the rows
                                $i = 1;
                                // Get the result of the query
                                $result = $stmt->get_result();

                                // Fetch and loop through the results
                                while($row = $result->fetch_assoc()):
                                ?>
                            <tr>
                                <td class="text-center"><?php echo $i++; ?></td> <!-- Increment $i after displaying -->
                                <td class="text-center">
                                    <b><p> <?php echo $row['class'] ?></p></b>
                                </td>
                                <td class="text-center">
                                    <b><p> <?php echo $row['subject'] ?></p></b>
                                </td>
                                <td class="text-center">
                                    <b><p> <?php echo $row['fullname'] ?></p></b>
                                </td>
                                <td class="text-center">
                                    <b><p> <?php echo $row['schedule'] ?></p></b>
                                </td>
                                <?php if($_SESSION['login_access'] == 3){?>   
                                <td class="text-center">
                                    <button type="button" value="<?=$row['Id'];?>" class="edit_class_subject btn btn-success btn-sm"><i class="fa fa-edit"></i></button>
                                    <button type="button" value="<?=$row['Id'];?>" class="deleteClass_subjectBtn btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                                </td>
                                <?php } ?> 
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

<script></script>

<script>

$(document).ready(function () {
    var table = $('#myTable').DataTable({"order": [[1, "asc"]]});

    $('#classfilter').on('change', function () {
        var selectedclass = $(this).val();
        table.column(1).search(selectedclass).draw();
    });
});

    $(document).on('submit', '#saveclass_subject', function (e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_class_subject", true);

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
                        $('#class_subjectAddModal').modal('hide');
                        $('#saveclass_subject')[0].reset();
                        setTimeout(function(){
                        location.reload()
                    },500)
                    }else if(res.status == 500) {
                        alert(res.message);
                    }
                }
            });

        });

 $(document).on('click', '.edit_class_subject', function () {
var class_subject_Id = $(this).val();
$.ajax({
    type: "GET",
    url: "function.php?class_subject_Id=" + class_subject_Id,
    success: function (response) {

        var res = jQuery.parseJSON(response);
        if(res.status == 404) {

            alert(res.message);
        }else if(res.status == 200){

            $('#class_subject_Id').val(res.data.Id);
            $('#class_Id').val(res.data.class_id);
            $('#subject_Id').val(res.data.subject_id);
            $('#faculty_Id').val(res.data.faculty_id);
            $('#edit_start_time').val(res.data.start_time);
            $('#edit_end_time').val(res.data.end_time);
            $('#edit_day_of_week').val(res.data.day);
            $('#class_subjectEditModal').modal('show');
        }
  }
});
});

$(document).on('submit','#updateclass_subject', function (e) {
e.preventDefault();
var formData = new FormData(this);
formData.append("update_class_subject", true);

$.ajax({
    type: "POST",
    url: "function.php",
    data: formData,
    processData: false,
    contentType: false,
    success: function (response) {  
        var res = jQuery.parseJSON(response);
        if(res.status == 421 || res.status == 422) {
            // $('#errorMessageUpdate').removeClass('d-none');
            // $('#errorMessageUpdate').text(res.message);
            alertify.set('notifier','position', 'top-right');
            alertify.warning(res.message);
        }else if(res.status == 199){
            alertify.set('notifier','position', 'top-right');
            alertify.success(res.message); 
            $('#class_subjectEditModal').modal('hide');
            $('#updateclass_subject')[0].reset();

            setTimeout(function(){
						location.reload()
					},500)
        }else if(res.status == 499) {
            alert(res.message);
        }
    }
});
});

$(document).on('click', '.deleteClass_subjectBtn', function (e) {
            e.preventDefault();

            if(confirm('Are you sure you want to delete this data?'))
            {
                var class_subject_Id = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "function.php",
                    data: {
                        'delete_class_subject': true,
                        'class_subject_Id': class_subject_Id
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

        $('#class_subjectAddModal').on('hidden.bs.modal', function () {
    $(this).find('form').trigger('reset');
})
</script>   

