<?php
include 'auth.php';
include 'database/db_connect.php';

if (isset($_POST['fetch'])) {

    // Prepare the SQL statement to include both class and quarter filtering
    $stmt = $connection->prepare("
        SELECT s.*, CONCAT(glevel.Gradelevel,'-',c.Section) AS class , CONCAT(s.Firstname,' ' ,s.Middlename,' ',s.Lastname) AS Fullname FROM class c right join gradelevel glevel on glevel.Id = c.Gradelevel_Id right join students s on s.class_id = c.Id
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
                        <td>';
        
        if (empty($row['Student_img'])) {
            $output .= '<center>
                            <img src="img/Img.png" class="border border-dark" width="100px" height="90vh" alt="Default Student Image" id="stud_img">
                        </center>';
        } else {
            $output .= '<center>
                            <img src="Student_img/' . $row['Student_img'] . '" alt="Student Image" width="100px" height="90vh">
                        </center>';
        }
    
        $output .= '</td>
                    <td class="text-center">' . ucwords($row['Fullname']) . '</td>
                    <td class="text-center">' . $row['Email'] . '</td>
                    <td class="text-center">' . $row['class'] . '</td>
                    <td class="text-center">
                        <button type="button" value="' . $row['Id'] . '" class="viewStudentBtn btn btn-info btn-sm"><i class="bi bi-eye"></i></button>
                        <button type="button" value="' . $row['Id'] . '" class="editStudentBtn btn btn-success btn-sm"><i class="fa fa-edit"></i></button>
                        <form id="delete_Stud" method="POST" class="d-inline">
                            <input type="hidden" name="delete_id" value="' . $row['Id'] . '">
                            <input type="hidden" name="delete_stud_img" value="' . $row['Student_img'] . '">
                            <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>';
    }
    
    echo $output; // Return the HTML to the AJAX call
}
?>
