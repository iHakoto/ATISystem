<?php 
include 'database/db_connect.php';
include 'auth.php';

$faculty_id = $_SESSION['login_Faculty_Id']; 
$qry = $connection->query("SELECT * FROM system_settings LIMIT 1");

if ($qry->num_rows > 0) {
    foreach ($qry->fetch_array() as $k => $val) {
        $meta[$k] = $val;
    }
}

// Fetch user role from session or database
$access_level = $_SESSION['access_level']; // Assuming the access level is stored in session
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        img {
            width: 100%;
            height: 90vh;
            background-size: cover;
        }

        body {
            font-family: Arial, sans-serif;
        }

        /* Styles for different user access levels */
        <?php 
        if ($access_level == 3) { 
            // Admin (Access 3) - Maroon
            echo "body { background-color: #800000; color: white; }";
        } elseif ($access_level == 2) { 
            // Teacher (Access 2) - Teacher Blue
            echo "body { background-color: #1E90FF; color: white; }";
        } elseif ($access_level == 1) { 
            // Student (Access 1) - Soft Green
            echo "body { background-color: #A8D08D; color: black; }";
        }
        ?>

        .card-header-custom {
            background-color: rgb(161, 45, 58);
            color: white !important;
        }
    </style>
</head>

<body>
<div class="row px-5 pb-5 pt-0">
    <!-- Left Column: General Announcements -->
    <div class="col-md-6">
        <?php 
        $sql = $connection->query("SELECT Id, type, title, description, announce_date, CONCAT(DATE_FORMAT(start_time, '%l:%i %p'), '-', DATE_FORMAT(end_time, '%l:%i %p')) AS `time` FROM announcement ORDER BY start_time ASC");
        while ($row = $sql->fetch_assoc()):
        ?>
        <div class="card mb-3">
            <div class="card-header card-header-custom">
                <h4 class="mb-0"><?php echo ucwords($row['type']) ?> Announcement</h4>
            </div>
            <div class="card-body">
                <h5 class="card-title"><?php echo ucwords($row['title']) ?></h5>
                <p class="card-text"><?php echo ucwords($row['description']) ?></p>
            </div>
            <div class="card-footer">
                <?php echo date('l, F j, Y', strtotime($row['announce_date'])); ?> - <?php echo ucwords($row['time']) ?>
            </div>
        </div>
        <?php endwhile; ?>
    </div>

    <!-- Right Column: Teacher Announcements -->
    <div class="col-md-6">
        <?php 
        $sql = $connection->query("SELECT ta.Id, ta.title as title, ta.description as description ,ta.announce_date as t_announce, CONCAT(DATE_FORMAT(ta.start_time, '%l:%i %p'), '-', DATE_FORMAT(ta.end_time, '%l:%i %p')) AS `t_time`, ta.class_id, CONCAT(glevel.Gradelevel, '-', c.Section, '-', s.Subject) AS `class` FROM teacher_announcement ta LEFT JOIN `class_subjects` cs ON ta.class_id = cs.Id LEFT JOIN `class` c ON cs.class_id = c.Id INNER JOIN gradelevel glevel ON glevel.Id = c.Gradelevel_Id LEFT JOIN subjects s ON s.Id = cs.subject_id ORDER BY ta.announce_date ASC, CONCAT(glevel.Gradelevel, '-', c.Section) ASC;");
        while ($row = $sql->fetch_assoc()):
        ?>
        <div class="card mb-3">
            <div class="card-header" style="background-color: rgb(161, 45, 58); color: white;">
                <h4 class="mb-0"><?php echo ucwords($row['class']) ?></h4>
            </div>
            <div class="card-body">
                <h5 class="card-title"><?php echo ucwords($row['title']) ?></h5>
                <p class="card-text"><?php echo ucwords($row['description']) ?></p>
            </div>
            <div class="card-footer">
                <?php echo date('l, F j, Y', strtotime($row['t_announce'])); ?> - <?php echo ucwords($row['t_time']) ?>
            </div>
        </div>
        <?php endwhile; ?>    
    </div>
</div>

</body>
</html>
