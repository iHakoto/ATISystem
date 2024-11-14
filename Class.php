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
    <div class="modal fade" id="classAddModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"> <b>Add Class</b> </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <form id="saveclass">
            <div class="modal-body">

                <div id="errorMessage" class="alert alert-warning d-none"></div>

                
                <div class="mb-3">
                <label for="">Grade Level</label>
                    <select name="gradelevel_id" id="gradelevel_id" class="custom-select">
                    <option value="">select grade level</option>
                                <?php 
                                $gradelevel = $connection->query("SELECT * FROM gradelevel order by Gradelevel asc");
                                while($row=$gradelevel->fetch_assoc()):
                                ?>
                                <option value="<?php echo $row['Id'] ?>"><?php echo $row['Gradelevel'] ?></option>
                            <?php endwhile; ?>
                            </select>
                </div>
                <div class="mb-3">
                    <label for="">Section</label>
                    <input type="text" name="section" class="form-control" />
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

<div class="modal fade" id="classEditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"> <b>Edit Class</b> </h5>

                     <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
        </div>
        <form id="updateClass">
            <div class="modal-body">
                <!-- <div id="errorMessageUpdate" class="alert alert-warning d-none"></div> -->
                <input type="hidden" name="class_Id" id="class_Id" >
                <div class="mb-3">
                <label for="">Grade Level</label>
                    <select name="gradelevel_Id" id="gradelevel_Id" class="custom-select">
                                <option value="">select grade level</option>
                                <?php 
                              
                                $gradelevel = $connection->query("SELECT * FROM gradelevel order by Gradelevel asc");
                                while($row=$gradelevel->fetch_assoc()):
                                ?>
                                <option value="<?php echo $row['Id'] ?>"><?php echo $row['Gradelevel'] ?></option>
                            <?php endwhile; ?>
                            </select>
                </div>
                <div class="mb-3">
                    <label for="">Section</label>
                    <input type="text" name="Section" id="Section" class="form-control" />
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
                        <h4><b >List of Class</b></h4>
                        <span class="float:right"><button type="button" class="btn btn-primary btn-block btn-sm col-sm-2 float-right" data-toggle="modal" data-target="#classAddModal">
                        <i class="fa fa-list-alt"></i> Add Class</button></span>
                    </div>
                    <div class="table-responsive">
					<div class="card-body">
						<table id ="myTable"class="table table-sm table-hover">
                            <thead>
                                <tr>                            
                                    <th class="text-center">#</th>
                                    <th class="text-center">Class</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php   $i = 1;
                            $class = $connection->query("SELECT c.*,concat(glevel.Gradelevel,'-',c.Section) as `class` FROM `class` c inner join gradelevel glevel on glevel.Id = c.Gradelevel_Id order by 
                            concat(glevel.Gradelevel,' ','-',c.Section) asc");
                            while($row=$class->fetch_assoc()):                           
                            ?>                          
                                <tr>					      
								<td class="text-center"><?php echo $i++ ?></td>
                                 <td class="text-center"> <b> <?php echo $row ['class'];?></b></td>                       		                                                    
                       			  <td class="text-center">                           
                                     <button type="button" value="<?=$row['Id'];?>" class="editClassBtn btn btn-success btn-sm"><i class="fa fa-edit"></i></button>
                                     <button type="button" value="<?=$row['Id'];?>" class="deleteClassBtn btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>							
									</td>
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
    $('#myTable').dataTable();
})
    $(document).on('submit', '#saveclass', function (e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_class", true);

            $.ajax({
                type: "POST",
                url: "function.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    
                    var res = jQuery.parseJSON(response);
                    if(res.status == 422 ||res.status == 421) {
                        $('#errorMessage').removeClass('d-none');
                        $('#errorMessage').text(res.message);
                        $("#errorMessage").fadeTo(2000, 500).slideUp(500, function(){
                        $("#errorMessage").slideUp(1000);
                        });
                    }else if(res.status == 201){

                        // $('#errorMessage').addClass('d-none');
                     
                        alertify.set('notifier','position', 'top-right');
                        alertify.success(res.message);
                        $('#classAddModal').modal('hide');
                        $('#saveclass')[0].reset();
                        setTimeout(function(){
                        location.reload()
                    },500)
                    }else if(res.status == 500) {
                        alert(res.message);
                    }
                }
            });

        });

 $(document).on('click', '.editClassBtn', function () {
var class_id = $(this).val();
$.ajax({
    type: "GET",
    url: "function.php?class_id=" + class_id,
    success: function (response) {

        var res = jQuery.parseJSON(response);
        if(res.status == 404) {

            alert(res.message);
        }else if(res.status == 200){

            $('#class_Id').val(res.data.Id);
            $('#gradelevel_Id').val(res.data.Gradelevel_Id);
            $('#Section').val(res.data.Section);
            $('#classEditModal').modal('show');
        }
  }
});
});

$(document).on('submit', '#updateClass', function (e) {
e.preventDefault();
var formData = new FormData(this);
formData.append("update_class", true);

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

            $('#errorMessageUpdate').addClass('d-none');

            alertify.set('notifier','position', 'top-right');
            alertify.success(res.message);
            
            $('#classEditModal').modal('hide');
            $('#updateClass')[0].reset();

            setTimeout(function(){
						location.reload()
					},500)

        }else if(res.status == 499) {
            alert(res.message);
        }
    }
});
});

$(document).on('click', '.deleteClassBtn', function (e) {
            e.preventDefault();

            if(confirm('Are you sure you want to delete this data?'))
            {
                var class_id = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "function.php",
                    data: {
                        'delete_class': true,
                        'class_id': class_id
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

        $('#classAddModal').on('hidden.bs.modal', function () {
    $(this).find('form').trigger('reset');
})
</script>   

