<?php
include 'auth.php';
include 'database/db_connect.php';

if (isset($_POST['fetch'])) {

    // Prepare the SQL statement to include both class and quarter filtering
    $stmt = $connection->prepare("
        SELECT *, CONCAT(Firstname,' ', Middlename,' ',Lastname) AS Fullname FROM faculty
    ");

    // Check for errors in preparing the statement
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($connection->error));
    }

    // Bind parameters and execute the statement
    // $stmt->bind_param("iii", $quarterId, $faculty_id, $classId); 
    $stmt->execute();
    $result = $stmt->get_result();

    $output = ''; // To store the table rows
    $i = 1;
    
    while ($row = $result->fetch_assoc()) {
        $output .= '<tr>
                        <td class="text-center">' . $row['Id'] . '</td>
                        <td>
                            <center>
                                <img src="Faculty_img/' . $row['Faculty_img'] . '" alt="Faculty Image" width="100px" height="90vh">
                            </center>
                        </td>
                        <td class="text-center">' . ucwords($row['Fullname']) . '</td>
                        <td class="text-center">' . $row['Email'] . '</td>
                        <td class="text-center">
                            <button type="button" value="' . $row['Id'] . '" class="viewFacultyBtn btn btn-info btn-sm"><i class="bi bi-eye"></i></button>
                            <button type="button" value="' . $row['Id'] . '" class="editFacultyBtn btn btn-success btn-sm"><i class="fa fa-edit"></i></button>
                            <form id="delete_Faculty" method="POST" class="d-inline">
                                <input type="hidden" name="delete_id" value="' . $row['Id'] . '">
                                <input type="hidden" name="delete_faculty_img" value="' . $row['Faculty_img'] . '">
                                <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>';
    }
    
    
    echo $output; // Return the HTML to the AJAX call
}
?>
