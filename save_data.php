<?php
 include 'database/db_connect.php';
?>

<?php
// Connect to the database


// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get the data from the AJAX request
$firstname = $_POST['firstname'];
$middlename = $_POST['middlename'];
$lastname = $_POST['lastname'];
$class_id = $_POST['class_id'];

// Insert the data into the database
$sql = "INSERT INTO grades (1st_grading, 2nd_grading, 3rd_grading, 4th_grading) VALUES (?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "sssi", $firstname, $middlename, $lastname, $class_id);
mysqli_stmt_execute($stmt);

// Check if the data was inserted successfully
if (mysqli_stmt_affected_rows($stmt) > 0) {
    echo "Data inserted successfully!";
} else {
    echo "Error inserting data: " . mysqli_error($conn);
}

// Close the database connection
mysqli_close($connection);
?>