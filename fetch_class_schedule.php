<?php include 'database/db_connect.php';
?>
<?php
session_start();


$faculty_id = $_SESSION['login_Faculty_Id'];
$student_class_id = $_SESSION['login_stud_class_id'];
$login_access = $_SESSION['login_access'];

if ($login_access == 2) {
    $stmt = $connection->prepare("SELECT cs.*, CONCAT(g.Gradelevel, '-', c.Section) AS `class`, s.Subject AS subject, CONCAT(f.Firstname, ' ', f.Middlename, ' ', f.Lastname) AS fullname, CONCAT('(', d.day, ') ', DATE_FORMAT(cs.start_time, '%l:%i %p'), '-', DATE_FORMAT(cs.end_time, '%l:%i %p')) AS `schedule` FROM class_subjects cs LEFT JOIN `class` c ON c.Id = cs.class_id INNER JOIN gradelevel g ON g.Id = c.Gradelevel_Id LEFT JOIN faculty f ON f.Id = cs.faculty_id LEFT JOIN subjects s ON s.Id = cs.subject_id LEFT JOIN days d ON d.Id = cs.day WHERE f.Id = ? ORDER BY CONCAT(g.Gradelevel, '-', c.Section) ASC");
    $stmt->bind_param("i", $faculty_id);
} elseif ($login_access == 1) {
    $stmt = $connection->prepare("SELECT cs.*, CONCAT(g.Gradelevel, '-', c.Section) AS `class`, s.Subject AS subject, CONCAT(f.Firstname, ' ', f.Middlename, ' ', f.Lastname) AS fullname, CONCAT('(', d.day, ') ', DATE_FORMAT(cs.start_time, '%l:%i %p'), '-', DATE_FORMAT(cs.end_time, '%l:%i %p')) AS `schedule` FROM class_subjects cs LEFT JOIN `class` c ON c.Id = cs.class_id INNER JOIN gradelevel g ON g.Id = c.Gradelevel_Id LEFT JOIN faculty f ON f.Id = cs.faculty_id LEFT JOIN subjects s ON s.Id = cs.subject_id LEFT JOIN days d ON d.Id = cs.day WHERE cs.class_id = ? ORDER BY CONCAT(g.Gradelevel, '-', c.Section) ASC");
    $stmt->bind_param("i", $student_class_id);
} else {
    $stmt = $connection->prepare("SELECT cs.*, CONCAT(g.Gradelevel, '-', c.Section) AS `class`, s.Subject AS subject, CONCAT(f.Firstname, ' ', f.Middlename, ' ', f.Lastname) AS fullname, CONCAT('(', d.day, ') ', DATE_FORMAT(cs.start_time, '%l:%i %p'), '-', DATE_FORMAT(cs.end_time, '%l:%i %p')) AS `schedule` FROM class_subjects cs LEFT JOIN `class` c ON c.Id = cs.class_id INNER JOIN gradelevel g ON g.Id = c.Gradelevel_Id LEFT JOIN faculty f ON f.Id = cs.faculty_id LEFT JOIN subjects s ON s.Id = cs.subject_id LEFT JOIN days d ON d.Id = cs.day ORDER BY CONCAT(g.Gradelevel, '-', c.Section) ASC");
}

$stmt->execute();
$result = $stmt->get_result();
$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
?>
