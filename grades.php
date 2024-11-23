<?php
 include 'auth.php';
 include 'database/db_connect.php';
 $faculty_id = $_SESSION['login_Faculty_Id']; 

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php echo $_SESSION['system']['name'] ?></title>
  
</head>

<body >
    
   <!-- Add Modal -->
   <div class="modal fade" id="gradeAddModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><b>Add Grade</b></h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form id="save_grade" onsubmit="return validateInput()">
                <div class="modal-body">

                    <div id="errorMessage" class="alert alert-warning d-none"></div>
                    <div class="mb-3">
                        <input type="hidden" name="faculty_id"  id="faculty_id" value="<?php echo $faculty_id; ?>" class="form-control" />
                        <input type="hidden" name="student_id" class="form-control" id="student_id" />
                        <input type="hidden" name="cs_id" id="cs_id" class="form-control" />
                        <input type="hidden" name="quarter_id" id="quarter_id" class="form-control" />
                    </div>
                    <div class="row">

        <label for="written_total">Written work</label>
    <div class="col">
        <label for="ww_score1">ww 1</label>
        <input type="number" name="ww_score1" id="ww_score1" class="form-control score-input" min="0" />
    </div>
    <div class="col">
        <label for="ww_score2">ww 2</label>
        <input type="number" name="ww_score2" id="ww_score2" class="form-control score-input" min="0" />
    </div>
    <div class="col">
        <label for="ww_score3">ww 3</label>
        <input type="number" name="ww_score3" id="ww_score3" class="form-control score-input" min="0" />
    </div>
    <div class="col">
        <label for="ww_score4">ww 4</label>
        <input type="number" name="ww_score4" id="ww_score4" class="form-control score-input" min="0" />
    </div>
    <div class="col">
        <label for="ww_score5">ww 5</label>
        <input type="number" name="ww_score5" id="ww_score5" class="form-control score-input" min="0" />
    </div>
</div>

    <div class="mb-3">
        <input type="number" name="written_total" id="written_total" class="form-control" min="0" step="0.01" readonly />
    </div>

    <br><br>

    <div class="row mb-3">
        <div class="col">
            <label for="score1">pt 1</label>
            <input type="number" name="pt_score1" id="pt_score1" class="form-control pt-score-input" min="0" />
        </div>
        <div class="col">
            <label for="score2">pt 2</label>
            <input type="number" name="pt_score2" id="pt_score2" class="form-control pt-score-input" min="0" />
        </div>
        <div class="col">
            <label for="score3">pt 3</label>
            <input type="number" name="pt_score3" id="pt_score3" class="form-control pt-score-input" min="0" />
        </div>
        <div class="col">
            <label for="score4">pt 4</label>
            <input type="number" name="pt_score4" id="pt_score4" class="form-control pt-score-input" min="0" />
        </div>
        <div class="col">
            <label for="score5">pt 5</label>
            <input type="number" name="pt_score5" id="pt_score5" class="form-control pt-score-input" min="0" />
        </div>
    </div>

        <div class="mb-3">
            <label for="performance_task">Performance task</label>
            <input type="number" name="performance_task" id="performance_task" class="form-control" min="0" step="0.01" readonly />
        </div>
        <div class="row mb-3">
    <!-- Quarterly Assessment Section -->
    <div class="col">
        <label for="qa_score1">qa 1</label>
        <input type="number" name="qa_score1" id="qa_score1" class="form-control qa-score-input" min="0" />
    </div>
</div>
<div class="mb-3">
    <label for="quarter_assesment">Quarterly Assessment</label>
    <input type="number" name="quarter_assesment" id="quarter_assesment" class="form-control" min="0" step="0.01" readonly />
</div>

                    <div class="mb-3">
                        <label for="">Quarterly Grade</label>
                        <input type="number" name="quarter_grade" id="quarter_grade" class="form-control" value="0" readonly/>
                    </div>   
                    <div class="mb-3">
                        <label for="comment">Comment/Remarks</label>
                        <textarea name="comment" id="comment" class="form-control" rows="4" placeholder="Comment or Remarks"></textarea>
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

  <!-- Add Modal -->

<!-- EDIT POP UP FORM (Bootstrap MODAL) -->
<div class="modal fade" id="gradeEditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"> <b>Edit Grade</b> </h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
        </div>
        <form id="updategrade">
            <div class="modal-body">

            <div id="errorMessage" class="alert alert-warning d-none"></div>
                    <div class="mb-3">
                        <input type="hidden" name="grade_Id" id="grade_Id" class="form-control" />
                    </div>
                    <div class="row mb-3">
    <!-- Enhanced Written Works Section -->
    <div class="col">
        <label for="eww_score1">ww 1</label>
        <input type="number" name="eww_score1" id="eww_score1" class="form-control eww-score-input" min="0" />
    </div>
    <div class="col">
        <label for="eww_score2">ww 2</label>
        <input type="number" name="eww_score2" id="eww_score2" class="form-control eww-score-input" min="0" />
    </div>
    <div class="col">
        <label for="eww_score3">ww 3</label>
        <input type="number" name="eww_score3" id="eww_score3" class="form-control eww-score-input" min="0" />
    </div>
    <div class="col">
        <label for="eww_score4">ww 4</label>
        <input type="number" name="eww_score4" id="eww_score4" class="form-control eww-score-input" min="0" />
    </div>
    <div class="col">
        <label for="eww_score5">ww 5</label>
        <input type="number" name="eww_score5" id="eww_score5" class="form-control eww-score-input" min="0" />
    </div>
</div>
<div class="mb-3">
    <label for="ewritten_work">Written Work</label>
    <input type="text" name="ewritten_work" id="ewritten_work" class="form-control" readonly/>
</div>

<div class="row mb-3">
    <!-- Enhanced Performance Task Section -->
    <div class="col">
        <label for="ept_score1">pt 1</label>
        <input type="number" name="ept_score1" id="ept_score1" class="form-control ept-score-input" min="0" />
    </div>
    <div class="col">
        <label for="ept_score2">pt 2</label>
        <input type="number" name="ept_score2" id="ept_score2" class="form-control ept-score-input" min="0" />
    </div>
    <div class="col">
        <label for="ept_score3">pt 3</label>
        <input type="number" name="ept_score3" id="ept_score3" class="form-control ept-score-input" min="0" />
    </div>
    <div class="col">
        <label for="ept_score4">pt 4</label>
        <input type="number" name="ept_score4" id="ept_score4" class="form-control ept-score-input" min="0" />
    </div>
    <div class="col">
        <label for="ept_score5">pt 5</label>
        <input type="number" name="ept_score5" id="ept_score5" class="form-control ept-score-input" min="0" />
    </div>
</div>
<div class="mb-3">
    <label for="eperformance_task">Performance Task</label>
    <input type="text" name="eperformance_task" id="eperformance_task" class="form-control" readonly />
</div>

<div class="row mb-3">
    <!-- Enhanced Quarterly Assessment Section -->
    <div class="col">
        <label for="eqa_score1">qa 1</label>
        <input type="number" name="eqa_score1" id="eqa_score1" class="form-control eqa-score-input" min="0" />
    </div>
</div>
<div class="mb-3">
    <label for="equarter_assesment">Quarterly Assessment</label>
    <input type="text" name="equarter_assesment" id="equarter_assesment" class="form-control" readonly />
</div>
                <div class="mb-3">
                    <label for="equarter_grade">Quarterly Grade</label>
                    <input type="number" name="equarter_grade" id="equarter_grade" class="form-control" value="0"  readonly/>
                </div>

                <div class="mb-3">
                        <label for="ecomment">Comment/Remarks</label>
                        <textarea name="ecomment" id="ecomment" class="form-control" rows="4" placeholder="Comment or Remarks"></textarea>
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
                    <h4><b id="quarterHeading">Select Quarter</b></h4>
                    </div>
                    <div class="mb-0 mt-3 ml-3">
    <label for="classfilter">Class Filter:</label>
    <select id="classfilter" class="form-select">
        <option value="">Select Class</option>
        <?php  
        // Check if faculty_id is set and not empty
        $faculty_id = isset($_SESSION['login_Faculty_Id']) ? $_SESSION['login_Faculty_Id'] : null;

        // Define the query based on the presence of faculty_id
        if (empty($faculty_id)) {
            $classQuery = "
             WITH RankedClasses AS ( SELECT c.*, CONCAT(glevel.Gradelevel, '-', c.Section, '-', s.Subject, '-', f.Firstname,' ', f.Middlename ,' ', f.Lastname) AS class, cs.Id AS class_id, cs.faculty_id AS cs_faculty, ROW_NUMBER() OVER ( PARTITION BY cs.faculty_id, CONCAT(glevel.Gradelevel, '-', c.Section, '-', s.Subject) ORDER BY c.added_at ASC, cs.Id ASC ) AS row_num FROM class c INNER JOIN gradelevel glevel ON glevel.Id = c.Gradelevel_Id LEFT JOIN class_subjects cs ON cs.class_id = c.Id LEFT JOIN subjects s ON s.Id = cs.subject_id LEFT JOIN faculty f ON f.Id = cs.faculty_id ) SELECT * FROM RankedClasses WHERE row_num = 1 ORDER BY class ASC;

            ";
        } else {
            $classQuery = "
                WITH RankedClasses AS (
    SELECT 
        c.*, 
        CONCAT(glevel.Gradelevel, '-', c.Section, '-', s.Subject) AS class, 
        cs.Id AS class_id,
        ROW_NUMBER() OVER (
            PARTITION BY CONCAT(glevel.Gradelevel, '-', c.Section, '-', s.Subject)
            ORDER BY c.added_at ASC
        ) AS row_num
    FROM 
        class c
    INNER JOIN 
        gradelevel glevel 
        ON glevel.Id = c.Gradelevel_Id
    LEFT JOIN 
        class_subjects cs 
        ON cs.class_id = c.Id
    LEFT JOIN 
        subjects s 
        ON s.Id = cs.subject_id
    WHERE 
        cs.faculty_id = $faculty_id
)
SELECT 
    *
FROM 
    RankedClasses
WHERE 
    row_num = 1
ORDER BY 
    class ASC;

            ";
        }

        // Execute the query
        $class = $connection->query($classQuery);

        // Generate the options for the dropdown
        while ($row = $class->fetch_assoc()):                          
        ?>
            <option value="<?php echo $row['class_id'] ?>"><?php echo $row['class'] ?></option>
        <?php endwhile; ?>               
    </select>
</div>

                        <div class="mb-0 mt-3 ml-3">
                            <label for="quarter">Quarter Filter:</label>
                            <select id="quarter" class="form-select">
                            <option value="">Select option</option>
                                <?php  
                                //  $faculty_id = $_SESSION['login_Faculty_Id']; 
                                $class = $connection->query("SELECT * FROM quarters");
                                while($row=$class->fetch_assoc()):                           
                                ?>         
                                <option value="<?php echo $row['Id'] ?>"><?php echo $row['quarter'] ?></option>
                                <?php endwhile; ?>               
                            </select>
                        </div> 
                    <div class="table-responsive">
                        <div class="card-body">
                            <table id="myTable" class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">Name</th>
                                        <th class="text-center" id="quarterGradeHeader">First Quarter Grade</th>
                                        <th class="text-center" id="quarterGradeHeader">Comment/Remarks</th>
                                        <th class="text-center" id="quarterGradeHeader">Last modified date</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <td colspan="3" class="text-center">Please select a class to view the grades.</td>
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
    // Select the input fields
    const ewrittenWorkInput = document.getElementById('ewritten_work');
    const eperformanceTaskInput = document.getElementById('eperformance_task');
    const equarterAssesmentInput = document.getElementById('equarter_assesment');
    const equarterGradeInput = document.getElementById('equarter_grade');

    // Function to calculate the total grade
    function calculateQuarterlyGrade1() {
        let ewrittenWork = parseFloat(ewrittenWorkInput.value) || 0;
        let eperformanceTask = parseFloat(eperformanceTaskInput.value) || 0;
        let equarterAssesment = parseFloat(equarterAssesmentInput.value) || 0;

        // Sum up the input values
        let totalGrade = (ewrittenWork + eperformanceTask + equarterAssesment).toFixed(2);
        
        // Update the Quarterly Grade input field
        equarterGradeInput.value = totalGrade;
    }

    // Add event listeners to each input field to trigger the calculation
    ewrittenWorkInput.addEventListener('input', calculateQuarterlyGrade);
    eperformanceTaskInput.addEventListener('input', calculateQuarterlyGrade);
    equarterAssesmentInput.addEventListener('input', calculateQuarterlyGrade);
</script>
<script>
    // Select the input fields
    const writtenTotalInput = document.getElementById('written_total');
    const performanceTaskInput = document.getElementById('performance_task');
    const quarterAssesmentInput = document.getElementById('quarter_assesment');
    const quarterGradeInput = document.getElementById('quarter_grade');

    // Function to calculate the total grade
    function calculateQuarterlyGrade() {
        let writtenTotal = parseFloat(writtenTotalInput.value) || 0;
        let performanceTask = parseFloat(performanceTaskInput.value) || 0;
        let quarterAssesment = parseFloat(quarterAssesmentInput.value) || 0;

        // Sum up the input values
        let totalGrade = (writtenTotal + performanceTask + quarterAssesment).toFixed(2);
        
        // Update the Quarterly Grade input field
        quarterGradeInput.value = totalGrade;
    }

    // Add event listeners to each input field to trigger the calculation
    writtenTotalInput.addEventListener('input', calculateQuarterlyGrade);
    performanceTaskInput.addEventListener('input', calculateQuarterlyGrade);
    quarterAssesmentInput.addEventListener('input', calculateQuarterlyGrade);
</script>

<script>
var f_id = <?php echo json_encode($faculty_id); ?>; // Pass the PHP variable to JavaScript
</script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Enhanced Written Works Calculation
        const ewwInputs = document.querySelectorAll('.eww-score-input');
        const ewrittenWorkInput = document.getElementById('ewritten_work');

        const calculateEWrittenResult = () => {
            let total = 0;
            ewwInputs.forEach(input => {
                const value = parseFloat(input.value) || 0;
                total += value;
            });

            const result = total * 2 * 0.30;
            ewrittenWorkInput.value = result.toFixed(2);
            calculateQuarterlyGrade1();
        };

        ewwInputs.forEach(input => {
            input.addEventListener('input', calculateEWrittenResult);
        });

        // Enhanced Performance Task Calculation
        const eptInputs = document.querySelectorAll('.ept-score-input');
        const eperformanceTaskInput = document.getElementById('eperformance_task');

        const calculateEPerformanceResult = () => {
            let total = 0;
            eptInputs.forEach(input => {
                const value = parseFloat(input.value) || 0;
                total += value;
            });

            const result = total * 2 * 0.50;
            eperformanceTaskInput.value = result.toFixed(2);
            calculateQuarterlyGrade1();
        };

        eptInputs.forEach(input => {
            input.addEventListener('input', calculateEPerformanceResult);
        });

        // Enhanced Quarterly Assessment Calculation
        const eqaInputs = document.querySelectorAll('.eqa-score-input');
        const equarterAssessmentInput = document.getElementById('equarter_assesment');

        const calculateEQuarterlyResult = () => {
            let total = 0;
            eqaInputs.forEach(input => {
                const value = parseFloat(input.value) || 0;
                total += value;
            });

            const result = total * 0.20;
            equarterAssessmentInput.value = result.toFixed(2);
            calculateQuarterlyGrade1();
        };

        eqaInputs.forEach(input => {
            input.addEventListener('input', calculateEQuarterlyResult);
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Written Works Calculation
        const writtenInputs = document.querySelectorAll('.score-input');
        const writtenTotalInput = document.getElementById('written_total');

        const calculateWrittenResult = () => {
            let total = 0;
            writtenInputs.forEach(input => {
                const value = parseFloat(input.value) || 0;
                total += value;
                
            });

            const result = total * 2 * 0.30;
            writtenTotalInput.value = result.toFixed(2);
            calculateQuarterlyGrade(); 
        };

        writtenInputs.forEach(input => {
            input.addEventListener('input', calculateWrittenResult);
        });

        // Performance Task Calculation
        const performanceInputs = document.querySelectorAll('.pt-score-input');
        const performanceTaskInput = document.getElementById('performance_task');

        const calculatePerformanceResult = () => {
            let total = 0;
            performanceInputs.forEach(input => {
                const value = parseFloat(input.value) || 0;
                total += value;
            });

            const result = total * 2 * 0.50;
            performanceTaskInput.value = result.toFixed(2);
            calculateQuarterlyGrade(); 
        };

        performanceInputs.forEach(input => {
            input.addEventListener('input', calculatePerformanceResult);
        });
 // Quarterly Assessment Calculation
 const quarterlyInputs = document.querySelectorAll('.qa-score-input');
        const quarterAssessmentInput = document.getElementById('quarter_assesment');

        const calculateQuarterlyResult = () => {
            let total = 0;
            quarterlyInputs.forEach(input => {
                const value = parseFloat(input.value) || 0;
                total += value;
            });

            const result = total * 0.20;
            quarterAssessmentInput.value = result.toFixed(2);
            calculateQuarterlyGrade(); 
        };

        quarterlyInputs.forEach(input => {
            input.addEventListener('input', calculateQuarterlyResult);
        });

    });
</script>
<script>
$('#gradeAddModal').on('hidden.bs.modal', function () {
    // Reset specific fields
    $('#written_total').val('');         // Clear the written_total field
    $('#performance_task').val('');      // Clear the performance_task field
    $('#quarter_assesment').val(''); 
    $('#comment').val('');    // Clear the quarter_assessment field
    $('#quarter_grade').val('');    
    // Add other fields here if needed
});
function openGradeAddModal(studentId) {
        // Set the student ID in the hidden input inside the modal
        $('#student_id').val(studentId);

        // Show the modal
        $('#gradeAddModal').modal('show');
    }

    // jQuery to capture button click and pass student ID to the function
    $(document).on('click', '.btn.btn-primary.btn-sm', function() {
        var studentId = $(this).data('student-id');
        openGradeAddModal(studentId);
    });

    $(document).ready(function() {
        
        var selectedClass = null;
        var selectedQuarter = null;

        // Event listener for class filter
        $('#classfilter').change(function() {
            selectedClass = $(this).val(); // Get selected class ID
            $('#cs_id').val(selectedClass); // Set the value of the hidden input
            fetchGrades(); // Call function to fetch grades based on both filters
        });

        // Event listener for quarter filter
        $('#quarter').change(function() {
            selectedQuarter = $(this).val(); // Get selected quarter ID
            $('#quarter_id').val(selectedQuarter); // Set the value of the hidden input

            // Update quarter heading and grade table header
            var selectedQuarterText = $(this).find("option:selected").text();
            $('#quarterHeading').text(selectedQuarterText || "Select a Quarter");
            $('#quarterGradeHeader').text(selectedQuarterText ? selectedQuarterText + " Grade" : "Quarterly Grade");

            fetchGrades(); // Call function to fetch grades based on both filters
        });

        // Function to fetch grades based on both filters
        function fetchGrades() {
            if (selectedClass && selectedQuarter) { // Ensure both filters are selected
                $.ajax({
                    url: 'fetch_grades.php', // PHP file to fetch data
                    type: 'POST',
                    data: { 
                        id: selectedClass,
                        quarter_id: selectedQuarter,
                        f_id: f_id // Assuming f_id is available globally
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
        function validateQuarterGrade() {
            const quarter_grade = document.getElementById("quarter_grade");
            
            if (parseFloat(quarter_grade.value) < 75) {
                quarter_grade.style.borderColor = "red";  // Change border color to red
                alert("Quarter Grade should not be less than 75.");
                return false;
            } else {
                quarter_grade.style.borderColor = "";  // Reset border color
            }
            return true;
        }

        function validateWritten() {
            const writtenTotal = document.getElementById("written_total");

            // Check if the value exceeds 30
            if (parseFloat(writtenTotal.value) > 30) {
                writtenTotal.style.borderColor = "red";  // Change border color to red
                alert("Written Works should not exceed in 30.");
                return false;
            } else {
                writtenTotal.style.borderColor = "";  // Reset border color
            }
            return true;
        }
        function validateTP() {
            const performance_task = document.getElementById("performance_task");

            // Check if the value exceeds 30
            if (parseFloat(performance_task.value) > 50) {
                performance_task.style.borderColor = "red";  // Change border color to red
                alert("Taskperformance should not in exceed 50.");
                return false;
            } else {
                performance_task.style.borderColor = "";  // Reset border color
            }
            return true;
        }

        function validateQA() {
            const quarter_assesment = document.getElementById("quarter_assesment");

            // Check if the value exceeds 30
            if (parseFloat(quarter_assesment.value) > 20) {
                quarter_assesment.style.borderColor = "red";  // Change border color to red
                alert("Taskperformance should not in exceed 20.");
                return false;
            } else {
                quarter_assesment.style.borderColor = "";  // Reset border color
            }
            return true;
        }



        // Save Grade Form Submission
        $(document).on('submit', '#save_grade', function (e) {
            e.preventDefault();

                // Call validateInput function to check the input
        if (!validateWritten()) {
            return; // Stop form submission if validation fails
        }
        if (!validateQuarterGrade()) {
            return; // Stop form submission if validation fails
        }
        if (!validateTP()) {
            return; // Stop form submission if validation fails
        }
        if (!validateQA()) {
            return; // Stop form submission if validation fails
        }


            var formData = new FormData(this);
            formData.append("save_grade", true);

            $.ajax({
                type: "POST",
                url: "function.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    var res = jQuery.parseJSON(response);
                    if(res.status == 422 || res.status == 421) {
                        $('#errorMessage').removeClass('d-none').text(res.message);
                        $("#errorMessage").fadeTo(2000, 500).slideUp(500);
                    } else if(res.status == 201) {
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);
                        $('#gradeAddModal').modal('hide');
                        $('#written_total').val('');
                        $('#performance_task').val('');
                        $('#quarter_assesment').val('');
                        $('#comment').val('');
                        $('#quarter_grade').val('');
                        setTimeout(function() {
                            setTimeout(fetchGrades, 500);
                        }, 500);
                    } else if(res.status == 500) {
                        alert(res.message);
                    }
                }
            });
        });

        // Edit Grade Button Click
        $(document).on('click', '.edit_grade', function () {

            var grade_Id = $(this).val();
            $.ajax({
                type: "GET",
                url: "function.php?grade_Id=" + grade_Id,
                success: function (response) {
                    var res = jQuery.parseJSON(response);
                    if(res.status == 404) {
                        alert(res.message);
                    } else if(res.status == 200) {
                        $('#grade_Id').val(res.data.Id);
                        $('#ewritten_work').val(res.data.written_work);
                        $('#eperformance_task').val(res.data.performance_task);
                        $('#equarter_assesment').val(res.data.quarterly_assesment);
                        $('#equarter_grade').val(res.data.quarterly_grade);
                        $('#equarter_assesment').val(res.data.quarterly_assesment);
                        $('#ecomment').val(res.data.comment);
                        $('#eww_score1').val(res.data.ww1);
                        $('#eww_score2').val(res.data.ww2);
                        $('#eww_score3').val(res.data.ww3);
                        $('#eww_score4').val(res.data.ww4);
                        $('#eww_score5').val(res.data.ww5);
                        $('#ept_score1').val(res.data.pt1);
                        $('#ept_score2').val(res.data.pt2);
                        $('#ept_score3').val(res.data.pt3);
                        $('#ept_score4').val(res.data.pt4);
                        $('#ept_score5').val(res.data.pt5);
                        $('#eqa_score1').val(res.data.qa);
                        $('#gradeEditModal').modal('show');
                    }
                }
            });
        });

        // Update Grade Form Submission
        $(document).on('submit','#updategrade', function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            formData.append("update_grade", true);

            $.ajax({
                type: "POST",
                url: "function.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {  
                    var res = jQuery.parseJSON(response);
                    if(res.status == 421 || res.status == 422) {
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.warning(res.message);
                    } else if(res.status == 200) {
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message); 
                        $('#gradeEditModal').modal('hide');
                        $('#updategrade')[0].reset();
                        setTimeout(function() {
                            setTimeout(fetchGrades, 500);
                        }, 500);
                    } else if(res.status == 499) {
                        alert(res.message);
                    }
                }
            });
        });
    });

    
</script>
