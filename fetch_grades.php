<?php
include 'auth.php';
include 'database/db_connect.php';

if (isset($_POST['id']) && isset($_POST['quarter_id'])) {
    $classId = $_POST['id'];
    $quarterId = $_POST['quarter_id'];
    $faculty_id = isset($_POST['f_id']) ? $_POST['f_id'] : null;

    // Determine the query based on whether $faculty_id is null or empty
    if (empty($faculty_id)) {
        // Query without faculty_id condition
        $stmt = $connection->prepare("
            SELECT s.*, CONCAT(s.Firstname, ' ', s.Middlename, ' ', s.Lastname) AS Fullname,  
                   g.quarterly_grade AS total_grades, g.Id as grade_id, g.comment as comment, g.added_At as added_date
            FROM students s 
            LEFT JOIN class c ON s.class_id = c.Id 
            LEFT JOIN class_subjects cs ON c.Id = cs.class_id 
            LEFT JOIN grades g ON cs.Id = g.class_subject_id 
                               AND s.Id = g.student_id 
                               AND g.quarter_id = ?
            WHERE cs.Id = ?;
        ");

        // Check for errors in preparing the statement
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($connection->error));
        }

        // Bind parameters and execute the statement
        $stmt->bind_param("ii", $quarterId, $classId);
    } else {
        // Query with faculty_id condition
        $stmt = $connection->prepare("
            SELECT s.*, CONCAT(s.Firstname, ' ', s.Middlename, ' ', s.Lastname) AS Fullname, 
                   g.quarterly_grade AS total_grades, g.Id as grade_id, g.comment as comment, g.added_At as added_date
            FROM students s 
            LEFT JOIN class c ON s.class_id = c.Id 
            LEFT JOIN class_subjects cs ON c.Id = cs.class_id 
            LEFT JOIN grades g ON cs.Id = g.class_subject_id 
                               AND s.Id = g.student_id 
                               AND g.quarter_id = ?
            WHERE cs.faculty_id = ? 
              AND cs.Id = ?;
        ");

        // Check for errors in preparing the statement
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($connection->error));
        }

        // Bind parameters and execute the statement
        $stmt->bind_param("iii", $quarterId, $faculty_id, $classId);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $output = ''; // To store the table rows
    $i = 1;
    while ($row = $result->fetch_assoc()) {
        $output .= '<tr>
                        <td class="text-center">' . $i++ . '</td> 
                        <td class="text-center">
                            <b><p>' . $row['Fullname'] . '</p></b>
                        </td>
                        <td class="text-center">
                            <b><p>' . $row['total_grades'] . '</p></b>
                        </td>
                        <td class="text-center">
                            <b><p>' . $row['comment'] . '</p></b>
                        </td>
                        <td class="text-center">
                            <b><p>' . $row['added_date'] . '</p></b>
                        </td>
                        <td class="text-center">
                            <div class="btn-group" role="group">';  // Add a wrapper for the buttons

        // Only display the "Add" button if there's no total grade
        if (empty($row['total_grades'])) {
            $output .= '<button type="button" class="btn btn-primary btn-sm mr-2"
                            data-student-id="' . $row['Id'] . '"
                            onclick="openGradeAddModal()">
                            <i class="fa fa-plus"></i>
                        </button>';
        }

        // Only display the "Edit" button if there are total grades
        if (!empty($row['total_grades'])) {
            $output .= '<button type="button" 
                            value="' . $row['grade_id'] . '" 
                            class="edit_grade btn btn-success btn-sm">
                            <i class="fa fa-edit"></i>
                        </button>';
        }

        $output .= '</div></td></tr>';
    }

    echo $output; // Return the HTML to the AJAX call
}
?>
