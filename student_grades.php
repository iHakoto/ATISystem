<?php
 include 'auth.php';
 include 'database/db_connect.php';
 $student_id = $_SESSION['login_Student_Id']; 
 $class_id = $_SESSION['login_stud_class_id']; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php echo $_SESSION['system']['name'] ?></title>
</head>

<body >

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
                    <h4><b id="quarterHeading">Grades</b></h4>
                    </div>
                    <div class="mb-0 mt-3 ml-3">
                            <label for="classfilter">Class Filter:</label>
                            <select id="classfilter" class="form-select">
                            <option value="">Select option</option>
                            <option value="All">All</option>
                                <?php  
                                //  $faculty_id = $_SESSION['login_Faculty_Id']; 
                                $class = $connection->query("WITH RankedClasses AS (
                                SELECT 
                                    c.*, 
                                    CONCAT(glevel.Gradelevel, '-', c.Section, '-', s.Subject) AS `class`, 
                                    cs.Id AS class_id,
                                    ROW_NUMBER() OVER (
                                        PARTITION BY CONCAT(glevel.Gradelevel, '-', c.Section, '-', s.Subject)
                                        ORDER BY c.added_at DESC
                                    ) AS row_num
                                FROM 
                                    `class` c
                                INNER JOIN 
                                    gradelevel glevel 
                                    ON glevel.Id = c.Gradelevel_Id
                                LEFT JOIN 
                                    class_subjects cs 
                                    ON cs.class_id = c.Id
                                LEFT JOIN 
                                    subjects s 
                                    ON s.Id = cs.subject_id
                                LEFT JOIN 
                                    students stud 
                                    ON stud.class_id = cs.class_id
                                WHERE 
                                    cs.class_id = $class_id
                            )
                            SELECT 
                                *
                            FROM 
                                RankedClasses
                            WHERE 
                                row_num = 1
                            ORDER BY 
                                `class` ASC;
                            ");
                                while($row=$class->fetch_assoc()):                           
                                ?>         
                                <option value="<?php echo $row['class_id'] ?>"><?php echo $row['class'] ?></option>
                                <?php endwhile; ?>               
                            </select>
                        </div> 
                    <div class="table-responsive">
                        <div class="card-body">
                            <table id="myTable" class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center" >First Quarter Grade</th>
                                        <th class="text-center" >Second Quarter Grade</th>
                                        <th class="text-center" >Third Quarter Grade</th>
                                        <th class="text-center" >Fourth Quarter Grade</th>
                                        <th class="text-center">Final Grade</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <td colspan="7" class="text-center">Please select a class to view the grades.</td>
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
<div class="modal fade" id="transactionModal" tabindex="-1" role="dialog" aria-labelledby="transactionModalLabel" aria-hidden="true">

<div class="modal-dialog" role="document">
    <div class="modal-content">
        <!-- <div class="modal-header">
            <h5 class="modal-title" id="transactionModalLabel">LOTUS</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div> -->
<div class="modal-body">
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
$(document).on('click', '.transaction-link', function (e) {
    e.preventDefault();
    var transactionId = $(this).data('transaction-id');
    
    // Proceed with AJAX as before
    $.ajax({
        type: 'POST',
        url: 'fetch_selected_grade.php',
        data: { transaction_id: transactionId },
        dataType: 'html',
        success: function (response) {
            $('#transactionModal .modal-body').html(response);
        },
        error: function () {
            alert('Error fetching transaction details.');
        }
    });
});
</script>

<script>
var s_id = <?php echo json_encode($student_id); ?>; // Pass the PHP variable to JavaScript
</script>

<script>
   

    $(document).ready(function() {
        
        var selectedClass = null;
        var selectedQuarter = null;

        // Event listener for class filter
        $('#classfilter').change(function() {
            selectedClass = $(this).val(); // Get selected class ID
            $('#cs_id').val(selectedClass); // Set the value of the hidden input
            fetchGrades(); // Call function to fetch grades based on both filters
        });


        // Function to fetch grades based on both filters
        function fetchGrades() {
            if (selectedClass) { // Ensure both filters are selected
                $.ajax({
                    url: 'fetch_studentgrades.php', // PHP file to fetch data
                    type: 'POST',
                    data: { 
                        id: selectedClass,
                        s_id: s_id // Assuming f_id is available globally
                    },
                    success: function(response) {
                        $('#myTable tbody').html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }
        }
        setInterval(fetchGrades, 1000);
    });
</script>
