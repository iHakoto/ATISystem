<?php
include 'auth.php';
include 'database/db_connect.php';
echo "Received class ID: " . $_POST['id'];  // Check the received value

if (isset($_POST['id'])) {
    $classId = $_POST['id'];
    $student_id = $_POST['s_id'];

    // Prepare the SQL statement to include both class and quarter filtering
    if ($classId) {
        $stmt = $connection->prepare("
            SELECT 
                cs.Id AS ID,
                sub.Subject AS Subject,
                MAX(CASE WHEN g.quarter_id = 1 THEN g.quarterly_grade END) AS Q1_Grade, 
                MAX(CASE WHEN g.quarter_id = 2 THEN g.quarterly_grade END) AS Q2_Grade, 
                MAX(CASE WHEN g.quarter_id = 3 THEN g.quarterly_grade END) AS Q3_Grade, 
                MAX(CASE WHEN g.quarter_id = 4 THEN g.quarterly_grade END) AS Q4_Grade,
                MAX(CASE WHEN g.quarter_id = 1 THEN g.Id END) AS Q1_Grade_Id,
                MAX(CASE WHEN g.quarter_id = 2 THEN g.Id END) AS Q2_Grade_Id,
                MAX(CASE WHEN g.quarter_id = 3 THEN g.Id END) AS Q3_Grade_Id,
                MAX(CASE WHEN g.quarter_id = 4 THEN g.Id END) AS Q4_Grade_Id,
                CASE 
                    WHEN COUNT(DISTINCT g.quarter_id) = 4 THEN 
                        ROUND(
                            (COALESCE(MAX(CASE WHEN g.quarter_id = 1 THEN g.quarterly_grade END), 0) +
                             COALESCE(MAX(CASE WHEN g.quarter_id = 2 THEN g.quarterly_grade END), 0) +
                             COALESCE(MAX(CASE WHEN g.quarter_id = 3 THEN g.quarterly_grade END), 0) +
                             COALESCE(MAX(CASE WHEN g.quarter_id = 4 THEN g.quarterly_grade END), 0)) / 4, 2
                        )
                    ELSE NULL
                END AS Average_Grade
            FROM class_subjects cs
            LEFT JOIN subjects sub ON sub.Id = cs.subject_id
            LEFT JOIN grades g ON cs.Id = g.class_subject_id AND g.student_id = ?
            WHERE cs.class_id = ?
            GROUP BY cs.Id;
        ");
        $stmt->bind_param("ii", $student_id, $classId); 
    }

    if($classId === "All") {
        $stmt = $connection->prepare("
            WITH RankedClasses AS (
                SELECT 
                    cs.Id AS class_id1,
                    sub.Subject AS Subject,
                    MAX(CASE WHEN g.quarter_id = 1 THEN g.quarterly_grade END) AS Q1_Grade, 
                    MAX(CASE WHEN g.quarter_id = 2 THEN g.quarterly_grade END) AS Q2_Grade, 
                    MAX(CASE WHEN g.quarter_id = 3 THEN g.quarterly_grade END) AS Q3_Grade, 
                    MAX(CASE WHEN g.quarter_id = 4 THEN g.quarterly_grade END) AS Q4_Grade,
                    MAX(CASE WHEN g.quarter_id = 1 THEN g.Id END) AS Q1_Grade_Id,
                    MAX(CASE WHEN g.quarter_id = 2 THEN g.Id END) AS Q2_Grade_Id,
                    MAX(CASE WHEN g.quarter_id = 3 THEN g.Id END) AS Q3_Grade_Id,
                    MAX(CASE WHEN g.quarter_id = 4 THEN g.Id END) AS Q4_Grade_Id,
                    CASE 
                        WHEN COUNT(DISTINCT g.quarter_id) = 4 THEN 
                            ROUND(
                                (COALESCE(MAX(CASE WHEN g.quarter_id = 1 THEN g.quarterly_grade END), 0) +
                                 COALESCE(MAX(CASE WHEN g.quarter_id = 2 THEN g.quarterly_grade END), 0) +
                                 COALESCE(MAX(CASE WHEN g.quarter_id = 3 THEN g.quarterly_grade END), 0) +
                                 COALESCE(MAX(CASE WHEN g.quarter_id = 4 THEN g.quarterly_grade END), 0)) / 4, 2
                            )
                        ELSE NULL
                    END AS Average_Grade,
                    ROW_NUMBER() OVER (
                        PARTITION BY cs.Id
                        ORDER BY cs.Id ASC
                    ) AS row_num
                FROM 
                    class_subjects cs 
                LEFT JOIN 
                    subjects sub ON sub.Id = cs.subject_id  
                LEFT JOIN 
                    grades g ON cs.Id = g.class_subject_id AND g.student_id = ?
                WHERE 
                    cs.class_id = ? 
                GROUP BY 
                    cs.Id, sub.Subject
            )
            SELECT 
                *
            FROM 
                RankedClasses
            WHERE 
                row_num = 1
            ORDER BY 
                Subject ASC;
        ");
        $stmt->bind_param("ii", $student_id, $classId); 
    }

    // Check for errors in preparing the statement
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($connection->error));
    }

    // Bind parameters and execute the statement
    $stmt->execute();  
    $result = $stmt->get_result();

    $output = ''; // To store the table rows
    $i = 1;
    
    while ($row = $result->fetch_assoc()) {
        $output .= '<tr>
                        <td class="text-center">' . $i++ . '</td> 
                        <td class="text-center">
                            <b><p>' . $row['Subject'] . '</p></b>
                        </td>
                        <td class="text-center" id="quarter2">
                            <a href="#" class="transaction-link" data-toggle="modal" data-target="#transactionModal" data-transaction-id="' . $row['Q1_Grade_Id'] . '">
                                <b><p>' . $row['Q1_Grade'] . '</p></b>
                            </a>
                        </td>
                        <td class="text-center" id="quarter2">
                            <a href="#" class="transaction-link" data-toggle="modal" data-target="#transactionModal" data-transaction-id="' . $row['Q2_Grade_Id'] . '">
                                <b><p>' . $row['Q2_Grade'] . '</p></b>
                            </a>
                        </td>
                        <td class="text-center" id="quarter2">
                            <a href="#" class="transaction-link" data-toggle="modal" data-target="#transactionModal" data-transaction-id="' . $row['Q3_Grade_Id'] . '">
                                <b><p>' . $row['Q3_Grade'] . '</p></b>
                            </a>
                        </td>
                        <td class="text-center" id="quarter2">
                            <a href="#" class="transaction-link" data-toggle="modal" data-target="#transactionModal" data-transaction-id="' . $row['Q4_Grade_Id'] . '">
                                <b><p>' . $row['Q4_Grade'] . '</p></b>
                            </a>
                        </td>
                        <td class="text-center" id="quarter4">
                            <b><p>' . $row['Average_Grade'] . '</p></b>
                        </td>
                    </tr>';
    }

    echo $output; // Return the HTML to the AJAX call
}
?>
