<?php
include 'database/db_connect.php';


function displayGrades($written_work, $performance_task, $quarterly_assessment, $quarterly_grade, $comment,
 $ww1, $ww2
, $ww3, $ww4
, $ww5, $pt1
, $pt2, $pt3
, $pt4, $pt5
, $qa) {
    echo '<div class="table-responsive">';
    echo '<dl class="row">';
    
    echo '<dt class="col-sm-6">Written Work Scores:</dt>';
    echo '<dd class="col-sm-6 d-flex justify-content-between">';
    echo '<span>' . $ww1 . '</span>';
    echo '<span>' . $ww2 . '</span>';
    echo '<span>' . $ww3 . '</span>';
    echo '<span>' . $ww4 . '</span>';
    echo '<span>' . $ww5 . '</span>';
    echo '</dd>';
    
    echo '<dt class="col-sm-6">Written Work WS:</dt>';
    echo '<dd class="col-sm-6">' . $written_work . '</dd>';
    
    echo '<dt class="col-sm-6">Performance Task Scores:</dt>';
    echo '<dd class="col-sm-6 d-flex justify-content-between">';
    echo '<span>' . $pt1 . '</span>';
    echo '<span>' . $pt2 . '</span>';
    echo '<span>' . $pt3 . '</span>';
    echo '<span>' . $pt4 . '</span>';
    echo '<span>' . $pt5 . '</span>';
    echo '</dd>';

    echo '<dt class="col-sm-6">Performance Task WS:</dt>';
    echo '<dd class="col-sm-6">' . $performance_task . '</dd>';
    
    echo '<dt class="col-sm-6">Quarterly Assessment Scores:</dt>';
    echo '<dd class="col-sm-6 d-flex justify-content-between">';
    echo '<span>' . $qa . '</span>';

    echo '<dt class="col-sm-6">Quarterly Assessment WS:</dt>';
    echo '<dd class="col-sm-6">' . $quarterly_assessment . '</dd>';
    
    echo '<div class="col-12"><hr></div>';
    
    echo '<dt class="col-sm-6">Quarterly Grade:</dt>';
    echo '<dd class="col-sm-6">' . $quarterly_grade . '</dd>';
    
    echo '<dt class="col-sm-6">Comment/Remarks:</dt>';
    echo '<dd class="col-sm-6">' . $comment . '</dd>';
    
    echo '</dl>';
    echo '</div>';
    
}




if (isset($_POST['transaction_id'])) {
    $transactionId = $_POST['transaction_id'];

    // Corrected SQL syntax
    $sql = "SELECT * FROM grades WHERE Id = '$transactionId'";
    $result = $connection->query($sql);

    if ($result && $result->num_rows > 0) {
        echo '<div class="container">';
        echo '<h3 class="centered-text">Summary of grades</h3>';

        while ($row = $result->fetch_assoc()) {
            displayGrades(
                $row['written_work'],
                $row['performance_task'],
                $row['quarterly_assesment'],
                $row['quarterly_grade'],
                $row['comment'],
                $row['ww1'],
                $row['ww2'],
                $row['ww3'],
                $row['ww4'],
                $row['ww5'],
                $row['pt1'],
                $row['pt2'],
                $row['pt3'],
                $row['pt4'],
                $row['pt5'],
                $row['qa']

            );
        }
        echo '</div>';
    } else {
        echo 'Grade not found.';
    }
} else {
    echo 'Invalid request.';
}
?>
