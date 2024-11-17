<?php include 'database/db_connect.php';
?>
<?php 
//  Insert-Student 
if(isset($_POST['save_student'])){
    $firstname = mysqli_real_escape_string($connection, $_POST['firstname']);
    $middlename = mysqli_real_escape_string($connection, $_POST['middlename']);
    $lastname = mysqli_real_escape_string($connection, $_POST['lastname']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $image = mysqli_real_escape_string($connection, $_FILES['stud_image']['name']);
    $class_id = mysqli_real_escape_string($connection, $_POST['class_id']);
    $phonenumber = mysqli_real_escape_string($connection, $_POST['phonenumber']);
    $check = $connection->query("SELECT * FROM students where Firstname = '$firstname' and Lastname ='$lastname'")->num_rows;
    if($check > 0){
        $res = [
            'status' => 421,
            'message' => 'Student already exists!'
        ];
        echo json_encode($res);
        return;
    }
    
    $check = $connection->query("SELECT * FROM students where Email = '$email' ")->num_rows;
    if($check > 0){
        $res = [
            'status' => 421,
            'message' => 'Email already exists!'
        ];
        echo json_encode($res);
        return;
    }
    
    // Validation: firstname, middlename, and lastname should not contain numbers
    if($firstname == NULL )
    {
        $res = [
            'status' => 422,
            'message' => 'First Name is mandatory!'
        ];
        echo json_encode($res);
        return;
    }
    if($lastname  == NULL)
    {
        $res = [
            'status' => 422,
            'message' => 'Last Name is mandatory!'
        ];
        echo json_encode($res);
        return;
    }
    // Validate that firstname is at least 3 characters long
    if (strlen($firstname) < 2) {
        $res = [
            'status' => 422,
            'message' => 'First Name must be at least 2 characters long!'
        ];
        echo json_encode($res);
        return;
    }
    if (strlen($lastname) < 2) {
        $res = [
            'status' => 422,
            'message' => 'Last Name must be at least 2 characters long!'
        ];
        echo json_encode($res);
        return;
    }

    if(!preg_match("/^[a-zA-Z\s]+$/", $firstname))
    {
        $res = [
            'status' => 422,
            'message' => 'First Name should not contain numbers!'
        ];
        echo json_encode($res);
        return;
    }
 // Allow blank middlename; if provided, validate it
if(!empty($middlename) && !preg_match("/^[a-zA-Z\s]+$/", $middlename)) {
    $res = [
        'status' => 422,
        'message' => 'Middle Name should not contain numbers or special characters!'
    ];
    echo json_encode($res);
    return;
}


    if(!preg_match("/^[a-zA-Z\s]+$/", $lastname))
    {
        $res = [
            'status' => 422,
            'message' => 'Last Name should not contain numbers!'
        ];
        echo json_encode($res);
        return;
    }
    if($email  == NULL ) {
        $res = [
            'status' => 422,
            'message' => 'Email is mandatory!'
        ];
        echo json_encode($res);
        return;
    }
    if (!preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@._-]+$/", $email)) {
        $res = [
            'status' => 422,
            'message' => 'Email must contain both numbers and characters!'
        ];
        echo json_encode($res);
        return;
    }
    
    if($phonenumber == NULL ) {
        $res = [
            'status' => 422,
            'message' => 'Phone number is mandatory!'
        ];
        echo json_encode($res);
        return;
    }
    if($class_id  == NULL ) {
        $res = [
            'status' => 422,
            'message' => 'Class is mandatory!'
        ];
        echo json_encode($res);
        return;
    }

    if($_FILES['stud_image']['name'] != ''){
    $allowed_extension = array('gif','GIF','png','PNG','jpg','JPG','jpeg','JPEG');
    $filename = $_FILES['stud_image']['name'];
    $file_extension = pathinfo($filename, PATHINFO_EXTENSION);
    if(!in_array($file_extension, $allowed_extension)){
        $res = [
            'status' => 301,
            'message' => 'You are allowed with only jpg, png, jpeg and gif '
        ];
        echo json_encode($res);
        return;
    }else{ 
if(file_exists("Student_img/" . $_FILES['stud_image']['name'])){
$filename = $_FILES['stud_image']['name'];
$res = [
    'status' => 300,
    'message' => 'Image is already Exists '. $filename
];
echo json_encode($res);
return;
}else{
  
 $sql = "INSERT INTO `students`( `Firstname`, `Middlename`, `Lastname`, `Email`, Student_img ,class_id,phonenumber) VALUES 
 ('$firstname','$middlename','$lastname','$email','$image','$class_id','$phonenumber')";
   $query_run = mysqli_query($connection, $sql);
   if($query_run)
    {
        $sql = "SELECT * FROM students WHERE Firstname ='$firstname' AND Lastname = '$lastname'";
        $faculty =  $connection->query($sql) or die ($connection->error);
        $row = $faculty->fetch_assoc();
        if($faculty->num_rows > 0){
          $id =$row['Id'];
          $email = $row['Email'];
          $password = md5($phonenumber);
          $password_text = $phonenumber;
          $class = $row['class_id'];
          $sql = "INSERT INTO `users`(  `username`, `password`,`password_text` ,`access`,Student_Id,stud_class_id) VALUES ('$email','$password','$password_text','1','$id','$class')";
          $query_run = mysqli_query($connection, $sql);
          }
        move_uploaded_file($_FILES["stud_image"]["tmp_name"], "Student_img/".$_FILES["stud_image"]["name"]);
        $res = [
            'status' => 200,
            'message' => 'Student Created Successfully'
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 500,
            'message' => 'Student Not Created'
        ];
        echo json_encode($res);
        return;
    }
}
}
}else{
     // Validation: firstname, middlename, and lastname should not contain numbers
     if($firstname == NULL )
     {
         $res = [
             'status' => 422,
             'message' => 'First Name is mandatory!'
         ];
         echo json_encode($res);
         return;
     }
     if(!preg_match("/^[a-zA-Z\s]+$/", $firstname))
     {
         $res = [
             'status' => 422,
             'message' => 'First Name should not contain numbers!'
         ];
         echo json_encode($res);
         return;
     }
// Allow blank middlename; if provided, validate it
if(!empty($middlename) && !preg_match("/^[a-zA-Z\s]+$/", $middlename)) {
    $res = [
        'status' => 422,
        'message' => 'Middle Name should not contain numbers or special characters!'
    ];
    echo json_encode($res);
    return;
}
     if($lastname  == NULL)
     {
         $res = [
             'status' => 422,
             'message' => 'Last Name is mandatory!'
         ];
         echo json_encode($res);
         return;
     }
     // Validate that firstname is at least 4 characters long
    if (strlen($firstname) < 2) {
        $res = [
            'status' => 422,
            'message' => 'First Name must be at least 2 characters long!'
        ];
        echo json_encode($res);
        return;
    }
    if (strlen($lastname) < 2) {
        $res = [
            'status' => 422,
            'message' => 'Last Name must be at least 2 characters long!'
        ];
        echo json_encode($res);
        return;
    }
     if(!preg_match("/^[a-zA-Z\s]+$/", $lastname))
     {
         $res = [
             'status' => 422,
             'message' => 'Last Name should not contain numbers!'
         ];
         echo json_encode($res);
         return;
     }
     if($email  == NULL ) {
         $res = [
             'status' => 422,
             'message' => 'Email is mandatory!'
         ];
         echo json_encode($res);
         return;
     }
     if (!preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@._-]+$/", $email)) {
         $res = [
             'status' => 422,
             'message' => 'Email must contain both numbers and characters!'
         ];
         echo json_encode($res);
         return;
     }
    $sql = "INSERT INTO `students`( `Firstname`, `Middlename`, `Lastname`, `Email`, Student_img ,class_id,phonenumber) VALUES 
    ('$firstname','$middlename','$lastname','$email','$image','$class_id','$phonenumber')";
       $query_run = mysqli_query($connection, $sql);
 

       if($query_run)
        {
            $sql = "SELECT * FROM students WHERE Firstname ='$firstname' AND Lastname = '$lastname'";
                  $student =  $connection->query($sql) or die ($connection->error);
                  $row = $student->fetch_assoc();
                  if($student->num_rows > 0){
                    $id =$row['Id'];
                    $email = $row['Email'];
                    $password = md5($phonenumber);
                    $class = $row['class_id'];
                    $sql = "INSERT INTO `users`(  `username`, `password`, `access`,Student_Id,stud_class_id) VALUES ('$email','$password','1','$id','$class')";
                    $query_run = mysqli_query($connection, $sql);
                    }
           
            $res = [
                'status' => 200,
                'message' => 'Student Created Successfully'
            ];
            echo json_encode($res);
            return;
        }
        else
        { 
            $res = [
                'status' => 500,
                'message' => 'Student Not Created'
            ];
            echo json_encode($res);
            return;
        }
}
}

// Update-Student
if(isset($_POST['update_student']))
{
    $student_id = mysqli_real_escape_string($connection, $_POST['student_id']);
    $firstname = mysqli_real_escape_string($connection, $_POST['firstname']);
    $middlename = mysqli_real_escape_string($connection, $_POST['middlename']);
    $lastname = mysqli_real_escape_string($connection, $_POST['lastname']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $new_image = mysqli_real_escape_string($connection, $_FILES['stud_image']['name']);
    $old_image = mysqli_real_escape_string($connection, $_POST['stud_image_old']);
    $class_id = mysqli_real_escape_string($connection, $_POST['class_Id']);
    $phonenumber = mysqli_real_escape_string($connection, $_POST['phonenumber']);
   

     // Validation: firstname, middlename, and lastname should not contain numbers
     if($firstname == NULL )
     {
         $res = [
             'status' => 422,
             'message' => 'First Name is mandatory!'
         ];
         echo json_encode($res);
         return;
     }
     if(!preg_match("/^[a-zA-Z\s]+$/", $firstname))
     {
         $res = [
             'status' => 422,
             'message' => 'First Name should not contain numbers!'
         ];
         echo json_encode($res);
         return;
     }
if(!empty($middlename) && !preg_match("/^[a-zA-Z\s]+$/", $middlename)) {
    $res = [
        'status' => 422,
        'message' => 'Middle Name should not contain numbers or special characters!'
    ];
    echo json_encode($res);
    return;
}
     if($lastname  == NULL)
     {
         $res = [
             'status' => 422,
             'message' => 'Last Name is mandatory!'
         ];
         echo json_encode($res);
         return;
     }
     // Validate that firstname is at least 4 characters long
    if (strlen($firstname) < 2) {
        $res = [
            'status' => 422,
            'message' => 'First Name must be at least 2 characters long!'
        ];
        echo json_encode($res);
        return;
    }
    if (strlen($lastname) < 2) {
        $res = [
            'status' => 422,
            'message' => 'Last Name must be at least 2 characters long!'
        ];
        echo json_encode($res);
        return;
    }
     if(!preg_match("/^[a-zA-Z\s]+$/", $lastname))
     {
         $res = [
             'status' => 422,
             'message' => 'Last Name should not contain numbers!'
         ];
         echo json_encode($res);
         return;
     }
     if($email  == NULL ) {
         $res = [
             'status' => 422,
             'message' => 'Email is mandatory!'
         ];
         echo json_encode($res);
         return;
     }
     if (!preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@._-]+$/", $email)) {
         $res = [
             'status' => 422,
             'message' => 'Email must contain both numbers and characters!'
         ];
         echo json_encode($res);
         return;
     }

    if($class_id  == NULL )
    {
        $res = [
            'status' => 422,
            'message' => 'Class is mandatory!'
        ];
        echo json_encode($res);
        return;
    }
    if($phonenumber == NULL )
    {
        $res = [
            'status' => 422,
            'message' => 'Phonenumber is mandatory!'
        ];
        echo json_encode($res);
        return;
    }  
    
if($_FILES['stud_image']['name'] != ''){
    if(file_exists("Student_img/".$_FILES['stud_image']['name'])){
    $filename = $_FILES['stud_image']['name'];
    $res = [
        'status' => 422,
        'message' => 'Image is already Exists '. $filename
    ];
    echo json_encode($res);
    return;
    }else{
        $query = "UPDATE students SET Firstname ='$firstname', Middlename ='$middlename', Lastname='$lastname', Email='$email', Student_img='$new_image', class_id='$class_id', phonenumber='$phonenumber' WHERE Id='$student_id'";
                $query_run = mysqli_query($connection, $query);
            
                if($query_run)
                {
                    $query1 = "UPDATE users SET username ='$email',stud_class_id='$class_id' WHERE Student_Id='$student_id'";
                    $query_run1 = mysqli_query($connection, $query1);
                    if($query_run1)
                    {
                    if($_FILES['stud_image']['name'] !=''){
                        move_uploaded_file($_FILES["stud_image"]["tmp_name"], "Student_img/".$_FILES["stud_image"]["name"]);
                       if($old_image !=''){
                        unlink("Student_img/".$old_image);
                       }
                    }
                    $res = [
                        'status' => 201,
                        'message' => 'Student Updated Successfully'
                    ];
                    echo json_encode($res);
                    return;
                }
                }
                else
                {
                    $res = [
                        'status' => 500,
                        'message' => 'Student Not Updated'
                    ];
                    echo json_encode($res);
                    return;
                }
            } 
}
else{
     // Validation: firstname, middlename, and lastname should not contain numbers
     if($firstname == NULL )
     {
         $res = [
             'status' => 422,
             'message' => 'First Name is mandatory!'
         ];
         echo json_encode($res);
         return;
     }
     if(!preg_match("/^[a-zA-Z\s]+$/", $firstname))
     {
         $res = [
             'status' => 422,
             'message' => 'First Name should not contain numbers!'
         ];
         echo json_encode($res);
         return;
     }
if(!empty($middlename) && !preg_match("/^[a-zA-Z\s]+$/", $middlename)) {
    $res = [
        'status' => 422,
        'message' => 'Middle Name should not contain numbers or special characters!'
    ];
    echo json_encode($res);
    return;
}
     if($lastname  == NULL)
     {
         $res = [
             'status' => 422,
             'message' => 'Last Name is mandatory!'
         ];
         echo json_encode($res);
         return;
     }
     // Validate that firstname is at least 4 characters long
    if (strlen($firstname) < 2) {
        $res = [
            'status' => 422,
            'message' => 'First Name must be at least 2 characters long!'
        ];
        echo json_encode($res);
        return;
    }
    if (strlen($lastname) < 2) {
        $res = [
            'status' => 422,
            'message' => 'Last Name must be at least 2 characters long!'
        ];
        echo json_encode($res);
        return;
    }
     if(!preg_match("/^[a-zA-Z\s]+$/", $lastname))
     {
         $res = [
             'status' => 422,
             'message' => 'Last Name should not contain numbers!'
         ];
         echo json_encode($res);
         return;
     }
     if($email  == NULL ) {
         $res = [
             'status' => 422,
             'message' => 'Email is mandatory!'
         ];
         echo json_encode($res);
         return;
     }
     if (!preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@._-]+$/", $email)) {
         $res = [
             'status' => 422,
             'message' => 'Email must contain both numbers and characters!'
         ];
         echo json_encode($res);
         return;
     }
$query = "UPDATE students SET Firstname ='$firstname', Middlename ='$middlename', Lastname='$lastname', Email='$email', Student_img='$old_image', class_id='$class_id', phonenumber='$phonenumber' WHERE Id='$student_id'";
        $query_run = mysqli_query($connection, $query);
    
        if($query_run)
        {
            $query1 = "UPDATE users SET username ='$email',stud_class_id='$class_id' WHERE Student_Id='$student_id'";
             $query_run1 = mysqli_query($connection, $query1);
             if($query_run1)
             {
            if($_FILES['stud_image']['name'] !=''){
                move_uploaded_file($_FILES["stud_image"]["tmp_name"], "Student_img/".$_FILES["stud_image"]["name"]);
                unlink("Student_img/".$old_image);
            }
            $res = [
                'status' => 201,
                'message' => 'Student Updated Successfully'
            ];
            echo json_encode($res);
            return;
        }
        }
        else
        {
            $res = [
                'status' => 500,
                'message' => 'Student Not Updated'
            ];
            echo json_encode($res);
            return;
        }
    } 
}
if(isset($_GET['student_id']))
{
    $student_id = mysqli_real_escape_string($connection, $_GET['student_id']);
    $query = "SELECT * FROM students WHERE Id='$student_id'";
    $query_run = mysqli_query($connection, $query);

    if(mysqli_num_rows($query_run) == 1)
    {
        $student = mysqli_fetch_array($query_run);

        $res = [
            'status' => 200,
            'message' => 'Student Fetch Successfully by id',
            'data' => $student
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 404,
            'message' => 'Student Id Not Found'
        ];
        echo json_encode($res);

        return;
    }
}

// Delete-Student
if(isset($_POST['delete_student']))
{
    $student_id = mysqli_real_escape_string($connection, $_POST['delete_id']);
    $stud_img = mysqli_real_escape_string($connection, $_POST['delete_stud_img']);
    $query = "DELETE students, users FROM students 
    JOIN users ON (users.Student_Id = students.Id) 
    WHERE students.Id = '$student_id'";

    $query_run = mysqli_query($connection, $query);

    if($query_run)
    {
    
        if($query_run)
        {
            $query_run = mysqli_query($connection, $query);

        if($stud_img != ''){
            unlink("Student_img/".$stud_img);
        }
        $res = [
            'status' => 200,
            'message' => 'All Student Info Deleted Successfully'
              ];
               echo json_encode($res);
               return;  
    }
    else
    {
        $res = [
            'status' => 500,
            'message' => 'Student Not Deleted'
        ];
        echo json_encode($res);
        return;
    }
}
}
// save-faculty
//  Insert-faculty 
if(isset($_POST['save_faculty'])){
    $firstname = mysqli_real_escape_string($connection, $_POST['firstname']);
    $middlename = mysqli_real_escape_string($connection, $_POST['middlename']);
    $lastname = mysqli_real_escape_string($connection, $_POST['lastname']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $faculty_img = mysqli_real_escape_string($connection, $_FILES['faculty_img']['name']);
    $phonenumber = mysqli_real_escape_string($connection, $_POST['phonenumber']);
    $check = $connection->query("SELECT * FROM faculty where Firstname = '$firstname' and Lastname ='$lastname'")->num_rows;
    if($check > 0){
        $res = [
            'status' => 421,
            'message' => 'Faculty is already exist!'
        ];
        echo json_encode($res);
        return;
    }
    $check = $connection->query("SELECT * FROM faculty where  Email = '$email' ")->num_rows;
    if($check > 0){
        $res = [
            'status' => 421,
            'message' => 'Email is already exist!'
        ];
        echo json_encode($res);
        return;
    }
  
      // Validation: firstname, middlename, and lastname should not contain numbers
      if($firstname == NULL )
      {
          $res = [
              'status' => 422,
              'message' => 'First Name is mandatory!'
          ];
          echo json_encode($res);
          return;
      }
      if(!preg_match("/^[a-zA-Z\s]+$/", $firstname))
      {
          $res = [
              'status' => 422,
              'message' => 'First Name should not contain numbers!'
          ];
          echo json_encode($res);
          return;
      }
      if(!empty($middlename) && !preg_match("/^[a-zA-Z\s]+$/", $middlename)) {
        $res = [
            'status' => 422,
            'message' => 'Middle Name should not contain numbers or special characters!'
        ];
        echo json_encode($res);
        return;
    }
      if($lastname  == NULL)
      {
          $res = [
              'status' => 422,
              'message' => 'Last Name is mandatory!'
          ];
          echo json_encode($res);
          return;
      }
      // Validate that firstname is at least 4 characters long
    if (strlen($firstname) < 2) {
        $res = [
            'status' => 422,
            'message' => 'First Name must be at least 2 characters long!'
        ];
        echo json_encode($res);
        return;
    }
    if (strlen($lastname) < 2) {
        $res = [
            'status' => 422,
            'message' => 'Last Name must be at least 2 characters long!'
        ];
        echo json_encode($res);
        return;
    }
      if(!preg_match("/^[a-zA-Z\s]+$/", $lastname))
      {
          $res = [
              'status' => 422,
              'message' => 'Last Name should not contain numbers!'
          ];
          echo json_encode($res);
          return;
      }
      if($email  == NULL ) {
          $res = [
              'status' => 422,
              'message' => 'Email is mandatory!'
          ];
          echo json_encode($res);
          return;
      }
      if (!preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@._-]+$/", $email)) {
          $res = [
              'status' => 422,
              'message' => 'Email must contain both numbers and characters!'
          ];
          echo json_encode($res);
          return;
      }
    if($phonenumber == NULL )
    {
        $res = [
            'status' => 422,
            'message' => 'Phonenumber is mandatory!'
        ];
        echo json_encode($res);
        return;
    }   


    if($_FILES['faculty_img']['name'] != ''){
        $allowed_extension = array('gif','GIF','png','PNG','jpg','JPG','jpeg','JPEG');
        $filename = $_FILES['faculty_img']['name'];
        $file_extension = pathinfo($filename, PATHINFO_EXTENSION);
        if(!in_array($file_extension, $allowed_extension)){
            $res = [
                'status' => 422,
                'message' => 'You are allowed with only jpg, png, jpeg and gif '
            ];
            echo json_encode($res);
            return;
        }else{
      
    if(file_exists("Faculty_img/" . $_FILES['faculty_img']['name'])){
    $filename = $_FILES['faculty_img']['name'];
    $res = [
        'status' => 422,
        'message' => 'Image is already Exists '. $filename
    ];
    echo json_encode($res);
    return;
    }else{
    
        $sql = "INSERT INTO `faculty`( `Firstname`, `Middlename`, `Lastname`, `Email`, Faculty_img, phonenumber) VALUES 
        ('$firstname','$middlename','$lastname','$email','$faculty_img','$phonenumber')";
        $query_run = mysqli_query($connection, $sql);
      
       if($query_run)
        {
                  //
                 
                  $sql = "SELECT * FROM faculty WHERE Firstname ='$firstname' AND Lastname = '$lastname'";
                  $faculty =  $connection->query($sql) or die ($connection->error);
                  $row = $faculty->fetch_assoc();
                  if($faculty->num_rows > 0){
                    $id =$row['Id'];
                    $email = $row['Email'];
                    $password = md5($phonenumber);
           
                    $sql = "INSERT INTO `users`(  `username`, `password`, `access`,Faculty_Id) VALUES ('$email','$password','2','$id')";
                    $query_run = mysqli_query($connection, $sql);
                    }
           
            //
            move_uploaded_file($_FILES["faculty_img"]["tmp_name"], "Faculty_img/".$_FILES["faculty_img"]["name"]);
            $res = [
                'status' => 199,
                'message' => 'Faculty Created Successfully'
            ];
            echo json_encode($res);
            return;
      
           
        }
        else
        {
            $res = [
                'status' => 500,
                'message' => 'Faculty Not Created'
            ];
            echo json_encode($res);
            return;
        }
    }
    }
    }else{
         // Validation: firstname, middlename, and lastname should not contain numbers
    if($firstname == NULL )
    {
        $res = [
            'status' => 422,
            'message' => 'First Name is mandatory!'
        ];
        echo json_encode($res);
        return;
    }
    if(!preg_match("/^[a-zA-Z\s]+$/", $firstname))
    {
        $res = [
            'status' => 422,
            'message' => 'First Name should not contain numbers!'
        ];
        echo json_encode($res);
        return;
    }
    if(!empty($middlename) && !preg_match("/^[a-zA-Z\s]+$/", $middlename)) {
        $res = [
            'status' => 422,
            'message' => 'Middle Name should not contain numbers or special characters!'
        ];
        echo json_encode($res);
        return;
    }
    if($lastname  == NULL)
    {
        $res = [
            'status' => 422,
            'message' => 'Last Name is mandatory!'
        ];
        echo json_encode($res);
        return;
    }
    // Validate that firstname is at least 4 characters long
    if (strlen($firstname) < 2) {
        $res = [
            'status' => 422,
            'message' => 'First Name must be at least 2 characters long!'
        ];
        echo json_encode($res);
        return;
    }
    if (strlen($lastname) < 2) {
        $res = [
            'status' => 422,
            'message' => 'Last Name must be at least 2 characters long!'
        ];
        echo json_encode($res);
        return;
    }
    if(!preg_match("/^[a-zA-Z\s]+$/", $lastname))
    {
        $res = [
            'status' => 422,
            'message' => 'Last Name should not contain numbers!'
        ];
        echo json_encode($res);
        return;
    }
    if($email  == NULL ) {
        $res = [
            'status' => 422,
            'message' => 'Email is mandatory!'
        ];
        echo json_encode($res);
        return;
    }
    if (!preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@._-]+$/", $email)) {
        $res = [
            'status' => 422,
            'message' => 'Email must contain both numbers and characters!'
        ];
        echo json_encode($res);
        return;
    }
        $sql = "INSERT INTO `faculty`( `Firstname`, `Middlename`, `Lastname`, `Email`, Faculty_img,phonenumber) VALUES 
        ('$firstname','$middlename','$lastname','$email','$faculty_img','$phonenumber')";
           $query_run = mysqli_query($connection, $sql);
           if($query_run)
            {
                
                $sql = "SELECT * FROM faculty WHERE Firstname ='$firstname' AND Lastname = '$lastname'";
                $faculty =  $connection->query($sql) or die ($connection->error);
                $row = $faculty->fetch_assoc();
                if($faculty->num_rows > 0){
                  $id =$row['Id'];
                  $email = $row['Email'];
                  $password = md5($phonenumber);
         
                  $sql = "INSERT INTO `users`(  `username`, `password`, `access`,Faculty_Id) VALUES ('$email','$password','2','$id')";
                  $query_run = mysqli_query($connection, $sql);
                  }
                $res = [
                    'status' => 199,
                    'message' => 'Faculty Created Successfully'
                ];
                echo json_encode($res);
                return;
            }
            else
            {
                $res = [
                    'status' => 500,
                    'message' => 'Faculty Not Created'
                ];
                echo json_encode($res);
                return;
            }
        }
    }
    
// Update-faculty
if(isset($_POST['update_faculty']))
{
    $faculty_id = mysqli_real_escape_string($connection, $_POST['faculty_id']);
    $firstname = mysqli_real_escape_string($connection, $_POST['firstname']);
    $middlename = mysqli_real_escape_string($connection, $_POST['middlename']);
    $lastname = mysqli_real_escape_string($connection, $_POST['lastname']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $new_image = mysqli_real_escape_string($connection, $_FILES['faculty_image']['name']);
    $old_image = mysqli_real_escape_string($connection, $_POST['faculty_image_old']);
    $phonenumber = mysqli_real_escape_string($connection, $_POST['phonenumber']);
     // Validation: firstname, middlename, and lastname should not contain numbers
     if($firstname == NULL )
     {
         $res = [
             'status' => 422,
             'message' => 'First Name is mandatory!'
         ];
         echo json_encode($res);
         return;
     }
     if(!preg_match("/^[a-zA-Z\s]+$/", $firstname))
     {
         $res = [
             'status' => 422,
             'message' => 'First Name should not contain numbers!'
         ];
         echo json_encode($res);
         return;
     }
if(!empty($middlename) && !preg_match("/^[a-zA-Z\s]+$/", $middlename)) {
    $res = [
        'status' => 422,
        'message' => 'Middle Name should not contain numbers or special characters!'
    ];
    echo json_encode($res);
    return;
}
     if($lastname  == NULL)
     {
         $res = [
             'status' => 422,
             'message' => 'Last Name is mandatory!'
         ];
         echo json_encode($res);
         return;
     }
     // Validate that firstname is at least 4 characters long
    if (strlen($firstname) < 2) {
        $res = [
            'status' => 422,
            'message' => 'First Name must be at least 2 characters long!'
        ];
        echo json_encode($res);
        return;
    }
    if (strlen($lastname) < 2) {
        $res = [
            'status' => 422,
            'message' => 'Last Name must be at least 2 characters long!'
        ];
        echo json_encode($res);
        return;
    }
     if(!preg_match("/^[a-zA-Z\s]+$/", $lastname))
     {
         $res = [
             'status' => 422,
             'message' => 'Last Name should not contain numbers!'
         ];
         echo json_encode($res);
         return;
     }
     if($email  == NULL ) {
         $res = [
             'status' => 422,
             'message' => 'Email is mandatory!'
         ];
         echo json_encode($res);
         return;
     }
     if (!preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@._-]+$/", $email)) {
         $res = [
             'status' => 422,
             'message' => 'Email must contain both numbers and characters!'
         ];
         echo json_encode($res);
         return;
     }
    if($phonenumber == NULL )
    {
        $res = [
            'status' => 422,
            'message' => 'Phonenumber is mandatory!'
        ];
        echo json_encode($res);
        return;
    }  
    
 
if($_FILES['faculty_image']['name'] !=''){
    if(file_exists("Faculty_img/".$_FILES['faculty_image']['name'])){
        $filename = $_FILES['faculty_image']['name'];
        $res = [
            'status' => 422,
            'message' => 'Image is already Exists '. $filename
        ];
        echo json_encode($res);
        return;
        }else{
           
            $query = "UPDATE faculty SET Firstname ='$firstname', Middlename ='$middlename', Lastname='$lastname', Email='$email', Faculty_img='$new_image', phonenumber='$phonenumber' WHERE Id='$faculty_id'";
                    $query_run = mysqli_query($connection, $query);
                
                    if($query_run)
                    {
                        $query1 = "UPDATE users SET username ='$email' WHERE Faculty_Id='$faculty_id'";
                        $query_run1 = mysqli_query($connection, $query1);
                        if($query_run1)
                        {
                        if($_FILES['faculty_image']['name'] !=''){
                            move_uploaded_file($_FILES["faculty_image"]["tmp_name"], "Faculty_img/".$_FILES["faculty_image"]["name"]);
                           if($old_image !=''){
                            unlink("Faculty_img/".$old_image);
                           }                    
                        }
                        $res = [
                            'status' => 200,
                            'message' => 'Faculty Updated Successfully'
                        ];
                        echo json_encode($res);
                        return;
                        }
                    }
                    else
                    {
                        $res = [
                            'status' => 500,
                            'message' => 'Faculty Not Updated'
                        ];
                        echo json_encode($res);
                        return;
                    }
                } 
}
  else{  
     // Validation: firstname, middlename, and lastname should not contain numbers
     if($firstname == NULL )
     {
         $res = [
             'status' => 422,
             'message' => 'First Name is mandatory!'
         ];
         echo json_encode($res);
         return;
     }
     if(!preg_match("/^[a-zA-Z\s]+$/", $firstname))
     {
         $res = [
             'status' => 422,
             'message' => 'First Name should not contain numbers!'
         ];
         echo json_encode($res);
         return;
     }
if(!empty($middlename) && !preg_match("/^[a-zA-Z\s]+$/", $middlename)) {
    $res = [
        'status' => 422,
        'message' => 'Middle Name should not contain numbers or special characters!'
    ];
    echo json_encode($res);
    return;
}
     if($lastname  == NULL)
     {
         $res = [
             'status' => 422,
             'message' => 'Last Name is mandatory!'
         ];
         echo json_encode($res);
         return;
     }
     // Validate that firstname is at least 4 characters long
    if (strlen($firstname) < 2) {
        $res = [
            'status' => 422,
            'message' => 'First Name must be at least 2 characters long!'
        ];
        echo json_encode($res);
        return;
    }
    if (strlen($lastname) < 2) {
        $res = [
            'status' => 422,
            'message' => 'Last Name must be at least 2 characters long!'
        ];
        echo json_encode($res);
        return;
    }
     if(!preg_match("/^[a-zA-Z\s]+$/", $lastname))
     {
         $res = [
             'status' => 422,
             'message' => 'Last Name should not contain numbers!'
         ];
         echo json_encode($res);
         return;
     }
     if($email  == NULL ) {
         $res = [
             'status' => 422,
             'message' => 'Email is mandatory!'
         ];
         echo json_encode($res);
         return;
     }
     if (!preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@._-]+$/", $email)) {
         $res = [
             'status' => 422,
             'message' => 'Email must contain both numbers and characters!'
         ];
         echo json_encode($res);
         return;
     }
    $query = "UPDATE faculty SET Firstname ='$firstname', Middlename ='$middlename', Lastname='$lastname', Email='$email',Faculty_img='$old_image', phonenumber='$phonenumber' WHERE Id='$faculty_id'";
    $query_run = mysqli_query($connection, $query);

    if($query_run)
    {
        $query1 = "UPDATE users SET username ='$email' WHERE Faculty_Id='$faculty_id'";
        $query_run1 = mysqli_query($connection, $query1);
        if($query_run1)
        {
        if($_FILES['faculty_image']['name'] !=''){
            move_uploaded_file($_FILES["faculty_image"]["tmp_name"], "Faculty_img/".$_FILES["faculty_image"]["name"]);
            unlink("Faculty_img/".$old_image);
                          
        }
        $res = [
            'status' => 200,
            'message' => 'Faculty Updated Successfully'
        ];
        echo json_encode($res);
        return;
    }
    }
    else
    {
        $res = [
            'status' => 500,
            'message' => 'Faculty Not Updated'
        ];
        echo json_encode($res);
        return;
    }
}
}
if(isset($_GET['faculty_id']))
{
    $faculty_id = mysqli_real_escape_string($connection, $_GET['faculty_id']);
    $query = "SELECT * FROM faculty WHERE Id='$faculty_id'";
    $query_run = mysqli_query($connection, $query);

    if(mysqli_num_rows($query_run) == 1)
    {
        $faculty = mysqli_fetch_array($query_run);

        $res = [
            'status' => 200,
            'message' => 'Faculty Fetch Successfully by id',
            'data' => $faculty
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 404,
            'message' => 'Faculty Id Not Found'
        ];
        echo json_encode($res);
        return;
    }
}

// Delete-faculty
if(isset($_POST['delete_faculty']))
{
    $faculty_id = mysqli_real_escape_string($connection, $_POST['delete_id']);
    $faculty_img = mysqli_real_escape_string($connection, $_POST['delete_faculty_img']);
    $query = "DELETE users, faculty FROM users JOIN faculty ON(faculty.Id = users.Faculty_Id) WHERE users.Faculty_Id='$faculty_id'";
    $query_run = mysqli_query($connection, $query);

    if($query_run)
    {
        if($faculty_img != ''){
            unlink("Faculty_img/".$faculty_img);
        }   
            $res = [
                'status' => 200,
                'message' => 'Faculty Deleted Successfully'
            ];
            echo json_encode($res);
            return;
        
       
    }
    else
    {
        $res = [
            'status' => 500,
            'message' => 'Faculty Not Deleted'
        ];
        echo json_encode($res);
        return;
    }
}


// ADMIN
//  Insert-admin 
if(isset($_POST['save_admin'])){
    $firstname = mysqli_real_escape_string($connection, $_POST['firstname']);
    $middlename = mysqli_real_escape_string($connection, $_POST['middlename']);
    $lastname = mysqli_real_escape_string($connection, $_POST['lastname']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $admin_img = mysqli_real_escape_string($connection, $_FILES['admin_img']['name']);
    $phonenumber = mysqli_real_escape_string($connection, $_POST['phonenumber']);
    $check = $connection->query("SELECT * FROM admin where Firstname = '$firstname' and Lastname ='$lastname'")->num_rows;
    if($check > 0){
        $res = [
            'status' => 421,
            'message' => 'Admin is already exist!'
        ];
        echo json_encode($res);
        return;
    }
    $check = $connection->query("SELECT * FROM admin where  Email = '$email' ")->num_rows;
    if($check > 0){
        $res = [
            'status' => 421,
            'message' => 'Email is already exist!'
        ];
        echo json_encode($res);
        return;
    }
     // Validation: firstname, middlename, and lastname should not contain numbers
     if($firstname == NULL )
     {
         $res = [
             'status' => 422,
             'message' => 'First Name is mandatory!'
         ];
         echo json_encode($res);
         return;
     }
     if(!preg_match("/^[a-zA-Z\s]+$/", $firstname))
     {
         $res = [
             'status' => 422,
             'message' => 'First Name should not contain numbers!'
         ];
         echo json_encode($res);
         return;
     }
    if(!empty($middlename) && !preg_match("/^[a-zA-Z\s]+$/", $middlename)) {
        $res = [
            'status' => 422,
            'message' => 'Middle Name should not contain numbers or special characters!'
        ];
        echo json_encode($res);
        return;
    }
     if($lastname  == NULL)
     {
         $res = [
             'status' => 422,
             'message' => 'Last Name is mandatory!'
         ];
         echo json_encode($res);
         return;
     }
     // Validate that firstname is at least 4 characters long
    if (strlen($firstname) < 2) {
        $res = [
            'status' => 422,
            'message' => 'First Name must be at least 2 characters long!'
        ];
        echo json_encode($res);
        return;
    }
    if (strlen($lastname) < 2) {
        $res = [
            'status' => 422,
            'message' => 'Last Name must be at least 2 characters long!'
        ];
        echo json_encode($res);
        return;
    }
     if(!preg_match("/^[a-zA-Z\s]+$/", $lastname))
     {
         $res = [
             'status' => 422,
             'message' => 'Last Name should not contain numbers!'
         ];
         echo json_encode($res);
         return;
     }
     if($email  == NULL ) {
         $res = [
             'status' => 422,
             'message' => 'Email is mandatory!'
         ];
         echo json_encode($res);
         return;
     }
     if (!preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@._-]+$/", $email)) {
         $res = [
             'status' => 422,
             'message' => 'Email must contain both numbers and characters!'
         ];
         echo json_encode($res);
         return;
     }
    if($phonenumber == NULL )
    {
        $res = [
            'status' => 422,
            'message' => 'Phonenumber is mandatory!'
        ];
        echo json_encode($res);
        return;
    }   

    if($_FILES['admin_img']['name'] != ''){
        $allowed_extension = array('gif','GIF','png','PNG','jpg','JPG','jpeg','JPEG');
        $filename = $_FILES['admin_img']['name'];
        $file_extension = pathinfo($filename, PATHINFO_EXTENSION);
        if(!in_array($file_extension, $allowed_extension)){
            $res = [
                'status' => 422,
                'message' => 'You are allowed with only jpg, png, jpeg and gif '
            ];
            echo json_encode($res);
            return;
        }else{
      
    if(file_exists("Admin_img/" . $_FILES['admin_img']['name'])){
    $filename = $_FILES['admin_img']['name'];
    $res = [
        'status' => 422,
        'message' => 'Image is already Exists '. $filename
    ];
    echo json_encode($res);
    return;
    }else{
        
    
        $sql = "INSERT INTO `admin`( `Firstname`, `Middlename`, `Lastname`, `Email`, Admin_img, phonenumber) VALUES 
        ('$firstname','$middlename','$lastname','$email','$admin_img',$phonenumber)";
        $query_run = mysqli_query($connection, $sql);
      
       if($query_run)
        {
            $sql = "SELECT * FROM admin WHERE Firstname ='$firstname' AND Lastname = '$lastname'";
            $faculty =  $connection->query($sql) or die ($connection->error);
            $row = $faculty->fetch_assoc();
            if($faculty->num_rows > 0){
            $id =$row['Id'];
            $email = $row['Email'];
            $password = md5($phonenumber);
            $sql = "INSERT INTO `users`(`username`, `password`, `access`,Admin_Id) VALUES ('$email','$password','3','$id')";
            $query_run = mysqli_query($connection, $sql);
          }
            move_uploaded_file($_FILES["admin_img"]["tmp_name"], "Admin_img/".$_FILES["admin_img"]["name"]);
            $res = [
                'status' => 199,
                'message' => 'Admin Created Successfully'
            ];
            echo json_encode($res);
            return;
        }
        else
        {
            $res = [
                'status' => 500,
                'message' => 'Admin Not Created'
            ];
            echo json_encode($res);
            return;
        }
    }
    }
    }else{

          // Validation: firstname, middlename, and lastname should not contain numbers
    if($firstname == NULL )
    {
        $res = [
            'status' => 422,
            'message' => 'First Name is mandatory!'
        ];
        echo json_encode($res);
        return;
    }
    if(!preg_match("/^[a-zA-Z\s]+$/", $firstname))
    {
        $res = [
            'status' => 422,
            'message' => 'First Name should not contain numbers!'
        ];
        echo json_encode($res);
        return;
    }
    if(!empty($middlename) && !preg_match("/^[a-zA-Z\s]+$/", $middlename)) {
        $res = [
            'status' => 422,
            'message' => 'Middle Name should not contain numbers or special characters!'
        ];
        echo json_encode($res);
        return;
    }
    if($lastname  == NULL)
    {
        $res = [
            'status' => 422,
            'message' => 'Last Name is mandatory!'
        ];
        echo json_encode($res);
        return;
    }
    // Validate that firstname is at least 4 characters long
    if (strlen($firstname) < 2) {
        $res = [
            'status' => 422,
            'message' => 'First Name must be at least 2 characters long!'
        ];
        echo json_encode($res);
        return;
    }
    if (strlen($lastname) < 2) {
        $res = [
            'status' => 422,
            'message' => 'Last Name must be at least 2 characters long!'
        ];
        echo json_encode($res);
        return;
    }
    if(!preg_match("/^[a-zA-Z\s]+$/", $lastname))
    {
        $res = [
            'status' => 422,
            'message' => 'Last Name should not contain numbers!'
        ];
        echo json_encode($res);
        return;
    }
    if($email  == NULL ) {
        $res = [
            'status' => 422,
            'message' => 'Email is mandatory!'
        ];
        echo json_encode($res);
        return;
    }
    if (!preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@._-]+$/", $email)) {
        $res = [
            'status' => 422,
            'message' => 'Email must contain both numbers and characters!'
        ];
        echo json_encode($res);
        return;
    }
        $sql = "INSERT INTO `admin`( `Firstname`, `Middlename`, `Lastname`, `Email`, Admin_img,phonenumber) VALUES 
        ('$firstname','$middlename','$lastname','$email','$admin_img',$phonenumber)";
           $query_run = mysqli_query($connection, $sql);
           if($query_run)
            {
                $sql = "SELECT * FROM admin WHERE Firstname ='$firstname' AND Lastname = '$lastname'";
                $faculty =  $connection->query($sql) or die ($connection->error);
                $row = $faculty->fetch_assoc();
                if($faculty->num_rows > 0){
                $id =$row['Id'];
                $email = $row['Email'];
                $password = md5($phonenumber);
                $sql = "INSERT INTO `users`(  `username`, `password`, `access`,Admin_Id) VALUES ('$email','$password','3','$id')";
                $query_run = mysqli_query($connection, $sql);
                }
                $res = [
                    'status' => 199,
                    'message' => 'Admin Created Successfully'
                ];

                echo json_encode($res);
                return;
            }
            else
            {
                $res = [
                    'status' => 500,
                    'message' => 'Admin Not Created'
                ];
                echo json_encode($res);
                return;
            }
        
}
}

// Update-admin
if(isset($_POST['update_admin']))
{
    $admin_id = mysqli_real_escape_string($connection, $_POST['admin_id']);
    $firstname = mysqli_real_escape_string($connection, $_POST['firstname']);
    $middlename = mysqli_real_escape_string($connection, $_POST['middlename']);
    $lastname = mysqli_real_escape_string($connection, $_POST['lastname']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $new_image = mysqli_real_escape_string($connection, $_FILES['admin_img']['name']);
    $old_image = mysqli_real_escape_string($connection, $_POST['admin_img_old']);
    $phonenumber = mysqli_real_escape_string($connection, $_POST['phonenumber']);
     // Validation: firstname, middlename, and lastname should not contain numbers
     if($firstname == NULL )
     {
         $res = [
             'status' => 422,
             'message' => 'First Name is mandatory!'
         ];
         echo json_encode($res);
         return;
     }
     if(!preg_match("/^[a-zA-Z\s]+$/", $firstname))
     {
         $res = [
             'status' => 422,
             'message' => 'First Name should not contain numbers!'
         ];
         echo json_encode($res);
         return;
     }
if(!empty($middlename) && !preg_match("/^[a-zA-Z\s]+$/", $middlename)) {
    $res = [
        'status' => 422,
        'message' => 'Middle Name should not contain numbers or special characters!'
    ];
    echo json_encode($res);
    return;
}
     if($lastname  == NULL)
     {
         $res = [
             'status' => 422,
             'message' => 'Last Name is mandatory!'
         ];
         echo json_encode($res);
         return;
     }
     // Validate that firstname is at least 4 characters long
    if (strlen($firstname) < 2) {
        $res = [
            'status' => 422,
            'message' => 'First Name must be at least 2 characters long!'
        ];
        echo json_encode($res);
        return;
    }
    if (strlen($lastname) < 2) {
        $res = [
            'status' => 422,
            'message' => 'Last Name must be at least 2 characters long!'
        ];
        echo json_encode($res);
        return;
    }
     if(!preg_match("/^[a-zA-Z\s]+$/", $lastname))
     {
         $res = [
             'status' => 422,
             'message' => 'Last Name should not contain numbers!'
         ];
         echo json_encode($res);
         return;
     }
     if($email  == NULL ) {
         $res = [
             'status' => 422,
             'message' => 'Email is mandatory!'
         ];
         echo json_encode($res);
         return;
     }
     if (!preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@._-]+$/", $email)) {
         $res = [
             'status' => 422,
             'message' => 'Email must contain both numbers and characters!'
         ];
         echo json_encode($res);
         return;
     }
    if($phonenumber == NULL )
    {
        $res = [
            'status' => 422,
            'message' => 'Phonenumber is mandatory!'
        ];
        echo json_encode($res);
        return;
    }   
if($_FILES['admin_img']['name'] !=''){
    if(file_exists("Admin_img/".$_FILES['admin_img']['name'])){
        $filename = $_FILES['admin_img']['name'];
        $res = [
            'status' => 422,
            'message' => 'Image is already Exists '. $filename
        ];
        echo json_encode($res);
        return;
        }else{
            $query = "UPDATE admin SET Firstname ='$firstname', Middlename ='$middlename', Lastname='$lastname', Email='$email', Admin_img='$new_image', phonenumber='$phonenumber' WHERE Id='$admin_id'";
                    $query_run = mysqli_query($connection, $query);
                
                    if($query_run)
                    {
                        $query1 = "UPDATE users SET username ='$email' WHERE Admin_Id='$admin_id'";
                        $query_run1 = mysqli_query($connection, $query1);
                        if($query_run1)
                        {
                        if($_FILES['admin_img']['name'] !=''){
                            move_uploaded_file($_FILES["admin_img"]["tmp_name"], "Admin_img/".$_FILES["admin_img"]["name"]);
                           if($old_image !=''){
                            unlink("Admin_img/".$old_image);
                           }                    
                        }
                        $res = [
                            'status' => 200,
                            'message' => 'Admin Updated Successfully'
                        ];
                        echo json_encode($res);
                        return;
                        }
                    }
                    else
                    {
                        $res = [
                            'status' => 500,
                            'message' => 'Admin Not Updated'
                        ];
                        echo json_encode($res);
                        return;
                    }
                } 
}
  else{ 
     // Validation: firstname, middlename, and lastname should not contain numbers
     if($firstname == NULL )
     {
         $res = [
             'status' => 422,
             'message' => 'First Name is mandatory!'
         ];
         echo json_encode($res);
         return;
     }
     if(!preg_match("/^[a-zA-Z\s]+$/", $firstname))
     {
         $res = [
             'status' => 422,
             'message' => 'First Name should not contain numbers!'
         ];
         echo json_encode($res);
         return;
     }
if(!empty($middlename) && !preg_match("/^[a-zA-Z\s]+$/", $middlename)) {
    $res = [
        'status' => 422,
        'message' => 'Middle Name should not contain numbers or special characters!'
    ];
    echo json_encode($res);
    return;
}
     if($lastname  == NULL)
     {
         $res = [
             'status' => 422,
             'message' => 'Last Name is mandatory!'
         ];
         echo json_encode($res);
         return;
     }

// Validate that firstname is at least 4 characters long
if (strlen($firstname) < 2) {
    $res = [
        'status' => 422,
        'message' => 'First Name must be at least 2 characters long!'
    ];
    echo json_encode($res);
    return;
}
if (strlen($lastname) < 2) {
    $res = [
        'status' => 422,
        'message' => 'Last Name must be at least 2 characters long!'
    ];
    echo json_encode($res);
    return;
}
     if(!preg_match("/^[a-zA-Z\s]+$/", $lastname))
     {
         $res = [
             'status' => 422,
             'message' => 'Last Name should not contain numbers!'
         ];
         echo json_encode($res);
         return;
     }
     if($email  == NULL ) {
         $res = [
             'status' => 422,
             'message' => 'Email is mandatory!'
         ];
         echo json_encode($res);
         return;
     }
     if (!preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@._-]+$/", $email)) {
         $res = [
             'status' => 422,
             'message' => 'Email must contain both numbers and characters!'
         ];
         echo json_encode($res);
         return;
     }
    $query = "UPDATE admin SET Firstname ='$firstname', Middlename ='$middlename', Lastname='$lastname', Email='$email',Admin_img='$old_image', phonenumber='$phonenumber' WHERE Id='$admin_id'";
    $query_run = mysqli_query($connection, $query);

    if($query_run)
    {
        $query1 = "UPDATE users SET username ='$email' WHERE Admin_Id='$admin_id'";
        $query_run1 = mysqli_query($connection, $query1);
        if($query_run1)
        {
        if($_FILES['admin_img']['name'] !=''){
            move_uploaded_file($_FILES["admin_img"]["tmp_name"], "Admin_img/".$_FILES["admin_img"]["name"]);
            unlink("Admin_img/".$old_image);
                          
        }
        $res = [
            'status' => 200,
            'message' => 'Admin Updated Successfully'
        ];
        echo json_encode($res);
        return;
    }
    }
    else
    {
        $res = [
            'status' => 500,
            'message' => 'Admin Not Updated'
        ];
        echo json_encode($res);
        return;
    }
}
}
if(isset($_GET['admin_id']))
{
    $admin_id = mysqli_real_escape_string($connection, $_GET['admin_id']);
    $query = "SELECT * FROM admin WHERE Id='$admin_id'";
    $query_run = mysqli_query($connection, $query);

    if(mysqli_num_rows($query_run) == 1)
    {
        $admin = mysqli_fetch_array($query_run);

        $res = [
            'status' => 200,
            'message' => 'Admin Fetch Successfully by id',
            'data' => $admin
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 404,
            'message' => 'Admin Id Not Found'
        ];
        echo json_encode($res);
        return;
    }
}

// Delete-admin
if(isset($_POST['delete_admin']))
{
    $admin_id = mysqli_real_escape_string($connection, $_POST['delete_id']);
    $admin_img = mysqli_real_escape_string($connection, $_POST['delete_admin_img']);

    $query = "DELETE users,admin FROM users JOIN admin ON (admin.Id = users.Admin_Id) WHERE Admin_Id='$admin_id'";
    $query_run = mysqli_query($connection, $query);

    if($query_run)
    {
        if($admin_img != ''){
            unlink("Admin_img/".$admin_img);
        }

            $res = [
                'status' => 200,
                'message' => 'Admin Deleted Successfully'
            ];
            echo json_encode($res);
            return;
    }
    else
    {
        $res = [
            'status' => 500,
            'message' => 'Admin Not Deleted'
        ];
        echo json_encode($res);
        return;
    }
}

// GradeLevel
// insert-gradelevel
if(isset($_POST['save_gradelevel'])){
    $gradelevel = mysqli_real_escape_string($connection, $_POST['gradelevel']);
    $description = mysqli_real_escape_string($connection, $_POST['description']);
    $check = $connection->query("SELECT * FROM gradelevel where Gradelevel = '$gradelevel'")->num_rows;
    if($check > 0){
        $res = [
            'status' => 421,
            'message' => 'Grade level is already exist!'
        ];
        echo json_encode($res);
        return;
    }
	if($gradelevel == NULL)
    {
        $res = [
            'status' => 422,
            'message' => 'Grade level is empty!'
        ];
        echo json_encode($res);
        return;
    }

 $sql = "INSERT INTO `gradelevel`( `Gradelevel`, `Description`) VALUES 
('$gradelevel','$description')";
   $query_run = mysqli_query($connection, $sql);
   if($query_run)
    {
        $res = [
            'status' => 201,
            'message' => 'Grade Level Created Successfully'
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 500,
            'message' => 'Grade Level Not Created'
        ];
        echo json_encode($res);
        return;
    }
}

// Update-gradelevel
if(isset($_POST['update_gradelevel']))
{
        $gradelevel_id = mysqli_real_escape_string($connection, $_POST['gradelevel_id']);
        $gradelevel = mysqli_real_escape_string($connection, $_POST['gradelevel']);
        $description = mysqli_real_escape_string($connection, $_POST['description']);
      
        $check = $connection->query("SELECT * FROM gradelevel where Gradelevel = '$gradelevel' && Description ='$description'")->num_rows;
        if($check > 0){
            $res = [
                'status' => 421,
                'message' => 'Grade level is already exist!'
            ];
            echo json_encode($res);
            return;
        }
	if($gradelevel == NULL)
    {
        $res = [
            'status' => 422,
            'message' => 'Grade level is empty!'
        ];
        echo json_encode($res);
        return;
    }

    $query = "UPDATE gradelevel SET Gradelevel ='$gradelevel',Description ='$description' WHERE Id='$gradelevel_id'";
    $query_run = mysqli_query($connection, $query);

    if($query_run)
    {
        $res = [
            'status' => 200,
            'message' => 'Grade Level Updated Successfully'
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 500,
            'message' => 'Grade Level Not Updated'
        ];
        echo json_encode($res);
        return;
    }
}
if(isset($_GET['gradelevel_id']))
{
    $gradelevel_id = mysqli_real_escape_string($connection, $_GET['gradelevel_id']);
    $query = "SELECT * FROM gradelevel WHERE Id='$gradelevel_id'";
    $query_run = mysqli_query($connection, $query);

    if(mysqli_num_rows($query_run) == 1)
    {
        $gradelevel = mysqli_fetch_array($query_run);

        $res = [
            'status' => 200,
            'message' => 'Gradelevel Fetch Successfully by id',
            'data' => $gradelevel
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 404,
            'message' => 'Grade Level Id Not Found'
        ];
        echo json_encode($res);
        return;
    }
}

// Delete-gradelevel
if(isset($_POST['delete_gradelevel']))
{
    $gradelevel_id = mysqli_real_escape_string($connection, $_POST['gradelevel_id']);

    $query = "DELETE FROM gradelevel WHERE Id='$gradelevel_id'";
    $query_run = mysqli_query($connection, $query);

    if($query_run)
    {
        $res = [
            'status' => 200,
            'message' => 'Grade Level Deleted Successfully'
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 500,
            'message' => 'Grade Level Not Deleted'
        ];
        echo json_encode($res);
        return;
    }
}
// Subject
// insert-subject
if(isset($_POST['save_subject'])){
    $subject = mysqli_real_escape_string($connection, $_POST['subject']);
    $description = mysqli_real_escape_string($connection, $_POST['description']);
    $check = $connection->query("SELECT * FROM subjects where Subject = '$subject'")->num_rows;
    if($check > 0){
        $res = [
            'status' => 421,
            'message' => 'Subject is already exist!'
        ];
        echo json_encode($res);
        return;
    }
	if($subject == NULL)
    {
        $res = [
            'status' => 422,
            'message' => 'Subject is empty!'
        ];
        echo json_encode($res);
        return;
    }

    if($description == NULL)
    {
        $res = [
            'status' => 422,
            'message' => 'Description is empty!'
        ];
        echo json_encode($res);
        return;
    }
 $sql = "INSERT INTO `subjects`( `Subject`, `Description`) VALUES 
('$subject','$description')";
   $query_run = mysqli_query($connection, $sql);
   if($query_run)
    {
        $res = [
            'status' => 201,
            'message' => 'Subject Created Successfully'
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 500,
            'message' => 'Subject Not Created'
        ];
        echo json_encode($res);
        return;
    }
}

// Update-subject
if(isset($_POST['update_subject']))
{
        $subject_id = mysqli_real_escape_string($connection, $_POST['subject_id']);
        $subject = mysqli_real_escape_string($connection, $_POST['subject']);
        $description = mysqli_real_escape_string($connection, $_POST['description']);
      
        $check1 = $connection->query("SELECT * FROM subjects where Subject = '$subject'")->num_rows;
        if($check1 > 0){
            $res = [
                'status' => 421,
                'message' => 'Subject is already exist!'
            ];
            echo json_encode($res);
            return;
        }
	if($subject == NULL)
    {
        $res = [
            'status' => 422,
            'message' => 'Subject is empty!'
        ];
        echo json_encode($res);
        return;
    }

    $query = "UPDATE subjects SET Subject ='$subject',Description ='$description' WHERE Id='$subject_id'";
    $query_run = mysqli_query($connection, $query);

    if($query_run)
    {
        $res = [
            'status' => 200,
            'message' => 'Subject Updated Successfully'
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 500,
            'message' => 'Subject Not Updated'
        ];
        echo json_encode($res);
        return;
    }
}
if(isset($_GET['subject_id']))
{
    $subject_id = mysqli_real_escape_string($connection, $_GET['subject_id']);
    $query = "SELECT * FROM subjects WHERE Id='$subject_id'";
    $query_run = mysqli_query($connection, $query);

    if(mysqli_num_rows($query_run) == 1)
    {
        $subject = mysqli_fetch_array($query_run);

        $res = [
            'status' => 200,
            'message' => 'Subject Fetch Successfully by id',
            'data' => $subject
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 404,
            'message' => 'Subject Id Not Found'
        ];
        echo json_encode($res);
        return;
    }
}

// Delete-subject

if(isset($_POST['delete_subject']))
{
    $subject_id = mysqli_real_escape_string($connection, $_POST['subject_id']);

    $query = "DELETE FROM subjects WHERE Id='$subject_id'";
    $query_run = mysqli_query($connection, $query);

    if($query_run)
    {
        $res = [
            'status' => 200,
            'message' => 'Subject Deleted Successfully'
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 500,
            'message' => 'Subject Not Deleted'
        ];
        echo json_encode($res);
        return;
    }
}

// Class
// insert-class
if(isset($_POST['save_class'])){
    $gradelevel_id = mysqli_real_escape_string($connection, $_POST['gradelevel_id']);
    $section = mysqli_real_escape_string($connection, $_POST['section']);
    $check = $connection->query("SELECT * FROM class where Gradelevel_Id = '$gradelevel_id' and Section = '$section'")->num_rows;
    if($check > 0){
        $res = [
            'status' => 421,
            'message' => 'Class is already exist!'
        ];
        echo json_encode($res);
        return;
    }
	if($section == NULL || $gradelevel_id == null)
    {
        $res = [
            'status' => 422,
            'message' => 'All fields are mandatory'
        ];
        echo json_encode($res);
        return;
    }

 $sql = "INSERT INTO `class`( `Gradelevel_Id`, `Section`) VALUES 
('$gradelevel_id','$section')";
   $query_run = mysqli_query($connection, $sql);
   if($query_run)
    {
        $res = [
            'status' => 201,
            'message' => 'Class Created Successfully'
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 500,
            'message' => 'Class Not Created'
        ];
        echo json_encode($res);
        return;
    }
}

// Update-class
if(isset($_POST['update_class']))
{
        $class_id = mysqli_real_escape_string($connection, $_POST['class_Id']);
        $gradelevel_id = mysqli_real_escape_string($connection, $_POST['gradelevel_Id']);
        $section = mysqli_real_escape_string($connection, $_POST['Section']);
      
        $check = $connection->query("SELECT * FROM class where Gradelevel_Id = '$gradelevel_id' and Section = '$section'")->num_rows;
        if($check > 0){
            $res = [
                'status' => 421,
                'message' => 'Class is already exist!'
            ];
            echo json_encode($res);
            return;
        }
	if($gradelevel_id == NULL || $section == NULL)
    {
        $res = [
            'status' => 421,
            'message' => 'All fields are mandatory'
        ];
        echo json_encode($res);
        return;
    }

    $query = "UPDATE class SET Gradelevel_Id ='$gradelevel_id',Section ='$section' WHERE Id='$class_id'";
    $query_run = mysqli_query($connection, $query);

    if($query_run)
    {
        $res = [
            'status' => 199,
            'message' => 'Class Updated Successfully'
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 499,
            'message' => 'Class Not Updated'
        ];
        echo json_encode($res);
        return;
    }
}
if(isset($_GET['class_id']))
{
    $class_id = mysqli_real_escape_string($connection, $_GET['class_id']);
    $query = "SELECT * FROM class WHERE Id='$class_id'";
    $query_run = mysqli_query($connection, $query);

    if(mysqli_num_rows($query_run) == 1)
    {
        $class = mysqli_fetch_array($query_run);

        $res = [
            'status' => 200,
            'message' => 'Class Fetch Successfully by id',
            'data' => $class
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 404,
            'message' => 'Class Id Not Found'
        ];
        echo json_encode($res);
        return;
    }
}

// Delete-Class
if(isset($_POST['delete_class']))
{
    $class_id = mysqli_real_escape_string($connection, $_POST['class_id']);

    $query = "DELETE FROM class WHERE Id='$class_id'";
    $query_run = mysqli_query($connection, $query);

    if($query_run)
    {
        $res = [
            'status' => 200,
            'message' => 'Class Deleted Successfully'
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 500,
            'message' => 'Class Not Deleted'
        ];
        echo json_encode($res);
        return;
    }
}

// Class_subject
// insert-Class_subject
if(isset($_POST['save_class_subject'])){
    $class_id = mysqli_real_escape_string($connection, $_POST['class_id']);
    $faculty_id = mysqli_real_escape_string($connection, $_POST['faculty_id']);
    $subject_id = mysqli_real_escape_string($connection, $_POST['subject_id']);
    $day_of_week = mysqli_real_escape_string($connection, $_POST['day_of_week']);
    $start_time = mysqli_real_escape_string($connection, $_POST['start_time']);
    $end_time = mysqli_real_escape_string($connection, $_POST['end_time']);

    $check = $connection->query("
    SELECT * 
    FROM class_subjects 
    WHERE class_id = '$class_id' 
    AND subject_id = '$subject_id' 
    AND day = '$day_of_week' 
    AND (
        (start_time < '$end_time' AND end_time > '$start_time')   -- New schedule starts before existing schedule ends
    )
")->num_rows;

if ($check > 0) {
    $res = [
        'status' => 421,
        'message' => 'There has already scheduled at this time!'
    ];
    echo json_encode($res);
    return;
}

$check1 = $connection->query("
    SELECT faculty_id 
    FROM class_subjects 
    WHERE class_id = '$class_id' 
    AND subject_id = '$subject_id' 
");

if ($check1->num_rows > 0) {
    $row = $check1->fetch_assoc();
    $db_faculty_id = $row['faculty_id'];

    // Compare the fetched faculty_id with the posted faculty_id
    if ($db_faculty_id !== $faculty_id) {
        $res = [
            'status' => 421,
            'message' => 'There is already a teacher assigned to this class and subject!'
        ];
        echo json_encode($res);
        return;
    }
} 

	if($faculty_id == NULL || $class_id == NULL || $subject_id == NULL)
    {
        $res = [
            'status' => 422,
            'message' => 'All fields are mandatory'
        ];
        echo json_encode($res);
        return;
    }

 $sql = "INSERT INTO class_subjects( class_id, faculty_id,subject_id,day,start_time,end_time) VALUES 
('$class_id','$faculty_id','$subject_id','$day_of_week','$start_time','$end_time')";
   $query_run = mysqli_query($connection, $sql);
   if($query_run)
    {
        $res = [
            'status' => 201,
            'message' => 'Class Created Successfully'
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 500,
            'message' => 'Class Not Created'
        ];
        echo json_encode($res);
        return;
    }
}

// Update-Class_subject
if(isset($_POST['update_class_subject']))
{
    $class_subject_id = mysqli_real_escape_string($connection, $_POST['class_subject_Id']);
    $class_id = mysqli_real_escape_string($connection, $_POST['class_Id']);
    $faculty_id = mysqli_real_escape_string($connection, $_POST['faculty_Id']);
    $subject_id = mysqli_real_escape_string($connection, $_POST['subject_Id']);
    $edit_start_time = mysqli_real_escape_string($connection, $_POST['edit_start_time']);
    $edit_end_time = mysqli_real_escape_string($connection, $_POST['edit_end_time']);
    $edit_day_of_week = mysqli_real_escape_string($connection, $_POST['edit_day_of_week']);

      
    // $check = $connection->query("SELECT * FROM class_subjects where class_id = '$class_id' and subject_id = '$subject_id' and faculty_id = '$faculty_id'")->num_rows;
    // if($check > 0){
    //     $res = [
    //         'status' => 421,
    //         'message' => 'Class is already exist!'
    //     ];
    //     echo json_encode($res);
    //     return;
    // }
	if($class_id == NULL || $faculty_id == NULL || $subject_id == NULL)
    {
        $res = [
            'status' => 422,
            'message' => 'All fields are mandatory'
        ];
        echo json_encode($res);
        return;
    }
    $query = "UPDATE class_subjects SET class_id ='$class_id',subject_id ='$subject_id', faculty_id = $faculty_id,start_time ='$edit_start_time',end_time ='$edit_end_time', day = $edit_day_of_week  WHERE Id='$class_subject_id'";
    $query_run = mysqli_query($connection, $query);
    if($query_run)
    {
        $res = [
            'status' => 199,
            'message' => 'Class Subject Updated Successfully'
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 499,
            'message' => 'Class Subject Not Updated'
        ];
        echo json_encode($res);
        return;
    }
}
if(isset($_GET['class_subject_Id']))
{
    $class_subject_id = mysqli_real_escape_string($connection, $_GET['class_subject_Id']);
    $query = "SELECT * FROM class_subjects WHERE Id='$class_subject_id'";
    $query_run = mysqli_query($connection, $query);

    if(mysqli_num_rows($query_run) == 1)
    {
        $class_subject = mysqli_fetch_array($query_run);

        $res = [
            'status' => 200,
            'message' => 'Class Fetch Successfully by id',
            'data' => $class_subject
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 404,
            'message' => 'Class Id Not Found'
        ];
        echo json_encode($res);
        return;
    }
}

// Delete-Class_Subject
if(isset($_POST['delete_class_subject']))
{
    $class_subject_id = mysqli_real_escape_string($connection, $_POST['class_subject_Id']);

    $query = "DELETE FROM class_subjects WHERE Id='$class_subject_id'";
    $query_run = mysqli_query($connection, $query);

    if($query_run)
    {
        $res = [
            'status' => 200,
            'message' => 'Class Deleted Successfully'
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 500,
            'message' => 'Class Not Deleted'
        ];
        echo json_encode($res);
        return;
    }
}

//Users
//insert user
// if(isset($_POST['update_user']))
// {
//     $user_id = mysqli_real_escape_string($connection, $_POST['user_id']);
//     $username = mysqli_real_escape_string($connection, $_POST['username']);
//     $password = mysqli_real_escape_string($connection, $_POST['password']);

   
//     if($username == NULL  )
//     {
//         $res = [
//             'status' => 422,
//             'message' => 'Info Id, User Name, Password, Access are mandatory'
//         ];
//         echo json_encode($res);
//         return;
//     }                          
// if($password == ''){

// $query = "UPDATE users SET username ='$username' WHERE Id='$user_id'";
//         $query_run = mysqli_query($connection, $query);
    
//         if($query_run)
//         {
//             $res = [
//                 'status' => 201,
//                 'message' => 'User Updated Successfully'
//             ];
//             echo json_encode($res);
//             return;
//         }
//         else
//         {
//             $res = [
//                 'status' => 500,
//                 'message' => 'User Not Updated'
//             ];
//             echo json_encode($res);
//             return;
//         }
//     }else{
//         $new_password =md5($password);
//         $query = "UPDATE users SET username ='$username', password='$new_password' WHERE Id='$user_id'";
//         $query_run = mysqli_query($connection, $query);
    
//         if($query_run)
//         {
//             $res = [
//                 'status' => 201,
//                 'message' => 'User Updated Successfully'
//             ];
//             echo json_encode($res);
//             return;
//         }
//         else
//         {
//             $res = [
//                 'status' => 500,
//                 'message' => 'User Not Updated'
//             ];
//             echo json_encode($res);
//             return;
//         }
//     } 
// }
if(isset($_POST['ownupdate_user']))
{
    $user_id = mysqli_real_escape_string($connection, $_POST['user_id']);
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $oldpassword = mysqli_real_escape_string($connection, $_POST['oldpassword']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);
    $cpassword = mysqli_real_escape_string($connection, $_POST['cpassword']);
    $oldpassword1 = md5($oldpassword);
    $qry = $connection->query("SELECT * FROM users where Id = '$user_id' ");
    if($qry->num_rows > 0){
        foreach ($qry->fetch_array() as $key => $value) {
            if($key != 'passwors' && !is_numeric($key))
                $_SESSION['login_'.$key] = $value;
        }
    }
    if($username == NULL)
    {
        $res = [
            'status' => 422,
            'message' => 'Please input the username'
        ];
        echo json_encode($res);
        return;
    }  
    if($_SESSION['login_password'] != $oldpassword1)
    {
        $res = [
            'status' => 422,
            'message' => 'Old Password is incorrect'
        ];
        echo json_encode($res);
        return;
    }
     
    if($password != $cpassword)
    {
        $res = [
            'status' => 422,
            'message' => 'Password and Confirm Password is Not match'
        ];
        echo json_encode($res);
        return;
    }
    
    

        $new_password =md5($password);
        $password_text =$password;
        $query = "UPDATE users SET username ='$username', password='$new_password', password_text ='$password_text' WHERE Id='$user_id'";
        $query_run = mysqli_query($connection, $query);
    
        if($query_run)
        {
            $res = [
                'status' => 201,
                'message' => 'User Updated Successfully'
            ];
            echo json_encode($res);
            return;
        }
        else
        {
            $res = [
                'status' => 500,
                'message' => 'User Not Updated'
            ];
            echo json_encode($res);
            return;
        }
     
}
if(isset($_GET['update_user_id']))
{
    $update_user_id = mysqli_real_escape_string($connection, $_GET['update_user_id']);
    $query = "SELECT * FROM users WHERE Id='$update_user_id'";
    $query_run = mysqli_query($connection, $query);

    if(mysqli_num_rows($query_run) == 1)
    {
        $user = mysqli_fetch_array($query_run);

        $res = [
            'status' => 200,
            'message' => 'User Fetch Successfully by id',
            'data' => $user
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 404,
            'message' => 'User Id Not Found'
        ];
        echo json_encode($res);
        return;
    }
}

if(isset($_POST['update_user']))
{
    $update_user_id = mysqli_real_escape_string($connection, $_POST['update_user_id']);
    $username = mysqli_real_escape_string($connection, $_POST['update_username']);
    $update_password = mysqli_real_escape_string($connection, $_POST['update_password']);
    $new_password = md5($update_password);
    $qry = $connection->query("SELECT * FROM users where Id = '$update_user_id' ");
    if($qry->num_rows > 0){
        foreach ($qry->fetch_array() as $key => $value) {
            if($key != 'passwors' && !is_numeric($key))
                $_SESSION['login_'.$key] = $value;
        }
    }
    if($username == NULL)
    {
        $res = [
            'status' => 422,
            'message' => 'Please input the username'
        ];
        echo json_encode($res);
        return;
    }  
    
        // $new_password = md5($update_password1);
        $query = "UPDATE users SET username ='$username', password='$new_password' WHERE Id='$update_user_id'";
        $query_run = mysqli_query($connection, $query);
    
        if($query_run)
        {
            $res = [
                'status' => 201,
                'message' => 'User Updated Successfully'
            ];
            echo json_encode($res);
            return;
        }
        else
        {
            $res = [
                'status' => 500,
                'message' => 'User Not Updated'
            ];
            echo json_encode($res);
            return;
        }
     
}

//Insert Announcement
if(isset($_POST['save_img1'])){
        $Id =mysqli_real_escape_string($connection, $_POST['ID']);
        $new_image = mysqli_real_escape_string($connection, $_FILES['first_img']['name']);
        $old_image = mysqli_real_escape_string($connection, $_POST['image_old']);
        if($new_image == NULL )
        {
            $res = [
                'status' => 422,
                'message' => 'Please choose image'
            ];
            echo json_encode($res);
            return;
        }
        if($_FILES['first_img']['name'] != ''){
            $allowed_extension = array('gif','GIF','png','PNG','jpg','JPG','jpeg','JPEG');
            $filename = $_FILES['first_img']['name'];
            $file_extension = pathinfo($filename, PATHINFO_EXTENSION);
            if(!in_array($file_extension, $allowed_extension)){
                $res = [
                    'status' => 301,
                    'message' => 'You are allowed with only jpg, png, jpeg and gif '
                ];
                echo json_encode($res);
                return;
            }    
        }                       
    if($_FILES['first_img']['name'] != ''){
        if(file_exists("assets/uploads/".$_FILES['first_img']['name'])){
        $filename = $_FILES['first_img']['name'];
        $res = [
            'status' => 422,
            'message' => 'Image is already Exists '. $filename
        ];
        echo json_encode($res);
        return;
        }
        }
            $query = "UPDATE system_settings SET cover_img1='$new_image' WHERE id='$Id'";
                    $query_run = mysqli_query($connection, $query); 
                    if($query_run)
                    {
                        if($_FILES['first_img']['name'] !=''){
                            move_uploaded_file($_FILES["first_img"]["tmp_name"], "assets/uploads/".$_FILES["first_img"]["name"]);
                           if($old_image !=''){
                            unlink("assets/uploads/".$old_image);
                           }
                         
                        }
                        $res = [
                            'status' => 201,
                            'message' => 'Image Successfully Insert'
                        ];
                        echo json_encode($res);
                        return;
                    }
                    else
                    {
                        $res = [
                            'status' => 500,
                            'message' => 'Image not Insert'
                        ];
                        echo json_encode($res);
                        return;
                    }
                } 
    //image2
 if(isset($_POST['save_img2'])){
                    $Id =mysqli_real_escape_string($connection, $_POST['ID']);
                    $new_image = mysqli_real_escape_string($connection, $_FILES['second_img']['name']);
                    $old_image = mysqli_real_escape_string($connection, $_POST['image_old']);
                    if($new_image == NULL )
                    {
                        $res = [
                            'status' => 422,
                            'message' => 'Please choose image'
                        ];
                        echo json_encode($res);
                        return;
                    }
                    if($_FILES['second_img']['name'] != ''){
                        $allowed_extension = array('gif','GIF','png','PNG','jpg','JPG','jpeg','JPEG');
                        $filename = $_FILES['second_img']['name'];
                        $file_extension = pathinfo($filename, PATHINFO_EXTENSION);
                        if(!in_array($file_extension, $allowed_extension)){
                            $res = [
                                'status' => 301,
                                'message' => 'You are allowed with only jpg, png, jpeg and gif '
                            ];
                            echo json_encode($res);
                            return;
                        }    
                    }                       
                if($_FILES['second_img']['name'] != ''){
                    if(file_exists("assets/uploads/".$_FILES['second_img']['name'])){
                    $filename = $_FILES['second_img']['name'];
                    $res = [
                        'status' => 422,
                        'message' => 'Image is already Exists '. $filename
                    ];
                    echo json_encode($res);
                    return;
                    }
                    }
                        $query = "UPDATE system_settings SET cover_img2='$new_image' WHERE id='$Id'";
                                $query_run = mysqli_query($connection, $query); 
                                if($query_run)
                                {
                                    if($_FILES['second_img']['name'] !=''){
                                        move_uploaded_file($_FILES["second_img"]["tmp_name"], "assets/uploads/".$_FILES["second_img"]["name"]);
                                       if($old_image !=''){
                                        unlink("assets/uploads/".$old_image);
                                       }
                                     
                                    }
                                    $res = [
                                        'status' => 201,
                                        'message' => 'Image Successfully Insert'
                                    ];
                                    echo json_encode($res);
                                    return;
                                }
                                else
                                {
                                    $res = [
                                        'status' => 500,
                                        'message' => 'Image not Insert'
                                    ];
                                    echo json_encode($res);
                                    return;
                                }
                            } 
      //image3
 if(isset($_POST['save_img3'])){
    $Id =mysqli_real_escape_string($connection, $_POST['ID']);
    $new_image = mysqli_real_escape_string($connection, $_FILES['third_img']['name']);
    $old_image = mysqli_real_escape_string($connection, $_POST['image_old']);
    if($new_image == NULL )
    {
        $res = [
            'status' => 422,
            'message' => 'Please choose image'
        ];
        echo json_encode($res);
        return;
    }
    if($_FILES['third_img']['name'] != ''){
        $allowed_extension = array('gif','GIF','png','PNG','jpg','JPG','jpeg','JPEG');
        $filename = $_FILES['third_img']['name'];
        $file_extension = pathinfo($filename, PATHINFO_EXTENSION);
        if(!in_array($file_extension, $allowed_extension)){
            $res = [
                'status' => 301,
                'message' => 'You are allowed with only jpg, png, jpeg and gif '
            ];
            echo json_encode($res);
            return;
        }    
    }                       
if($_FILES['third_img']['name'] != ''){
    if(file_exists("assets/uploads/".$_FILES['third_img']['name'])){
    $filename = $_FILES['third_img']['name'];
    $res = [
        'status' => 422,
        'message' => 'Image is already Exists '. $filename
    ];
    echo json_encode($res);
    return;
    }
    }
        $query = "UPDATE system_settings SET cover_img3='$new_image' WHERE id='$Id'";
                $query_run = mysqli_query($connection, $query); 
                if($query_run)
                {
                    if($_FILES['third_img']['name'] !=''){
                        move_uploaded_file($_FILES["third_img"]["tmp_name"], "assets/uploads/".$_FILES["third_img"]["name"]);
                       if($old_image !=''){
                        unlink("assets/uploads/".$old_image);
                       }         
                    }
                    $res = [
                        'status' => 201,
                        'message' => 'Image Successfully Insert'
                    ];
                    echo json_encode($res);
                    return;
                }
                else
                {
                    $res = [
                        'status' => 500,
                        'message' => 'Image not Insert'
                    ];
                    echo json_encode($res);
                    return;
                }
}   
// ADMIN ANNOUNCEMENT

// insert-announcement
if(isset($_POST['save_announcement'])){
    $type = mysqli_real_escape_string($connection, $_POST['type']);
    $title = mysqli_real_escape_string($connection, $_POST['title']);
    $ID = mysqli_real_escape_string($connection, $_POST['ID']);
    $description = mysqli_real_escape_string($connection, $_POST['description']);
    $start_time = mysqli_real_escape_string($connection, $_POST['start_time']);
    $end_time = mysqli_real_escape_string($connection, $_POST['end_time']);
    $announce_date = mysqli_real_escape_string($connection, $_POST['announce_date']);
    $check = $connection->query("SELECT * FROM announcement where title = '$title'")->num_rows;
    if($check > 0){
        $res = [
            'status' => 421,
            'message' => 'Announcement is already exist!'
        ];
        echo json_encode($res);
        return;
    }
	if($title == NULL)
    {
        $res = [
            'status' => 422,
            'message' => 'title is empty!'
        ];
        echo json_encode($res);
        return;
    }
    if($description == NULL)
    {
        $res = [
            'status' => 422,
            'message' => 'description is empty!'
        ];
        echo json_encode($res);
        return;
    }
    if($start_time == NULL)
    {
        $res = [
            'status' => 422,
            'message' => 'start time is empty!'
        ];
        echo json_encode($res);
        return;
    }
    if($end_time == NULL)
    {
        $res = [
            'status' => 422,
            'message' => 'end time is empty!'
        ];
        echo json_encode($res);
        return;
    }
    if($announce_date == NULL)
    {
        $res = [
            'status' => 422,
            'message' => 'announcement date  is empty!'
        ];
        echo json_encode($res);
        return;
    }

 $sql = "INSERT INTO `announcement`( `type`,`title`, admin_faculty_id,`description`, `start_time`, `end_time`, `announce_date`) VALUES 
('$type','$title','$ID','$description','$start_time','$end_time','$announce_date')";
   $query_run = mysqli_query($connection, $sql);
   if($query_run)
    {
        $res = [
            'status' => 201,
            'message' => 'Announcement Created Successfully'
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 500,
            'message' => 'Announcement Not Created'
        ];
        echo json_encode($res);
        return;
    }
}

// Update-announcement
if(isset($_POST['update_announcement']))
{
        $announcement_id = mysqli_real_escape_string($connection, $_POST['announcement_id']);
        $title = mysqli_real_escape_string($connection, $_POST['edit_title']);
        $description = mysqli_real_escape_string($connection, $_POST['edit_description']);
        $start_time = mysqli_real_escape_string($connection, $_POST['edit_start_time']);
        $end_time = mysqli_real_escape_string($connection, $_POST['edit_end_time']);
        $announce_date = mysqli_real_escape_string($connection, $_POST['edit_announce_date']);
   
      
        // $check = $connection->query("SELECT * FROM announcement where Id = '$announcement_id'")->num_rows;
        // if($check > 0){
        //     $res = [
        //         'status' => 421,
        //         'message' => 'Announcement is already exist!'
        //     ];
        //     echo json_encode($res);
        //     return;
        // }
	if($title == NULL)
    {
        $res = [
            'status' => 422,
            'message' => 'title is empty!'
        ];
        echo json_encode($res);
        return;
    }
	if($description == NULL)
    {
        $res = [
            'status' => 422,
            'message' => 'description is empty!'
        ];
        echo json_encode($res);
        return;
    }
    if($start_time == NULL)
    {
        $res = [
            'status' => 422,
            'message' => 'Start time is empty!'
        ];
        echo json_encode($res);
        return;
    }
    if($end_time == NULL)
    {
        $res = [
            'status' => 422,
            'message' => 'End time is empty!'
        ];
        echo json_encode($res);
        return;
    }
    if($announce_date == NULL)
    {
        $res = [
            'status' => 422,
            'message' => 'Date is empty!'
        ];
        echo json_encode($res);
        return;
    }
    $query = "UPDATE announcement SET title ='$title',description ='$description',start_time ='$start_time',end_time ='$end_time',announce_date ='$announce_date' WHERE Id='$announcement_id'";
    $query_run = mysqli_query($connection, $query);

    if($query_run)
    {
        $res = [
            'status' => 200,
            'message' => 'Announcement Updated Successfully'
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 500,
            'message' => 'Announcement Not Updated'
        ];
        echo json_encode($res);
        return;
    }
}
if(isset($_GET['announcement_id']))
{
    $announcement_id = mysqli_real_escape_string($connection, $_GET['announcement_id']);
    $query = "SELECT * FROM announcement WHERE Id='$announcement_id'";
    $query_run = mysqli_query($connection, $query);

    if(mysqli_num_rows($query_run) == 1)
    {
        $announcement = mysqli_fetch_array($query_run);

        $res = [
            'status' => 200,
            'message' => 'Announcement Fetch Successfully by id',
            'data' => $announcement
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 404,
            'message' => 'Announcement Id Not Found'
        ];
        echo json_encode($res);
        return;
    }
}

// Delete-announcement
if(isset($_POST['delete_announcement']))
{
    $announcement_id = mysqli_real_escape_string($connection, $_POST['announcement_id']);

    $query = "DELETE FROM announcement WHERE Id='$announcement_id'";
    $query_run = mysqli_query($connection, $query);

    if($query_run)
    {
        $res = [
            'status' => 200,
            'message' => 'Announcement Deleted Successfully'
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 500,
            'message' => 'Announcement Not Deleted'
        ];
        echo json_encode($res);
        return;
    }
}
// FACULTY ANNOUNCEMENT

// insert-announcement
if(isset($_POST['t_save_announcement'])){
    $type = mysqli_real_escape_string($connection, $_POST['type']);
    $title = mysqli_real_escape_string($connection, $_POST['title']);
    $class_id = mysqli_real_escape_string($connection, $_POST['class_id']);
    $ID = mysqli_real_escape_string($connection, $_POST['ID']);
    $description = mysqli_real_escape_string($connection, $_POST['description']);
    $start_time = mysqli_real_escape_string($connection, $_POST['start_time']);
    $end_time = mysqli_real_escape_string($connection, $_POST['end_time']);
    $announce_date = mysqli_real_escape_string($connection, $_POST['announce_date']);
    $check = $connection->query("SELECT * FROM announcement where title = '$title'")->num_rows;
    if($check > 0){
        $res = [
            'status' => 421,
            'message' => 'Announcement is already exist!'
        ];
        echo json_encode($res);
        return;
    }
	if($title == NULL)
    {
        $res = [
            'status' => 422,
            'message' => 'title is empty!'
        ];
        echo json_encode($res);
        return;
    }
    if($description == NULL)
    {
        $res = [
            'status' => 422,
            'message' => 'description is empty!'
        ];
        echo json_encode($res);
        return;
    }
    if($start_time == NULL)
    {
        $res = [
            'status' => 422,
            'message' => 'start time is empty!'
        ];
        echo json_encode($res);
        return;
    }
    if($end_time == NULL)
    {
        $res = [
            'status' => 422,
            'message' => 'end time is empty!'
        ];
        echo json_encode($res);
        return;
    }
    if($announce_date == NULL)
    {
        $res = [
            'status' => 422,
            'message' => 'announcement date  is empty!'
        ];
        echo json_encode($res);
        return;
    }

 $sql = "INSERT INTO `teacher_announcement`( `type`,`class_id`,`title`, faculty_id,`description`, `start_time`, `end_time`, `announce_date`) VALUES 
('$type','$class_id','$title','$ID','$description','$start_time','$end_time','$announce_date')";
   $query_run = mysqli_query($connection, $sql);
   if($query_run)
    {
        $res = [
            'status' => 201,
            'message' => 'Announcement Created Successfully'
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 500,
            'message' => 'Announcement Not Created'
        ];
        echo json_encode($res);
        return;
    }
}

// Update-announcement
if(isset($_POST['t_updateannouncement']))
{
        $announcement_id = mysqli_real_escape_string($connection, $_POST['announcement_id']);
        $title = mysqli_real_escape_string($connection, $_POST['edit_title']);
        $class_id= mysqli_real_escape_string($connection, $_POST['edit_class_id']);
        $description = mysqli_real_escape_string($connection, $_POST['edit_description']);
        $start_time = mysqli_real_escape_string($connection, $_POST['edit_start_time']);
        $end_time = mysqli_real_escape_string($connection, $_POST['edit_end_time']);
        $announce_date = mysqli_real_escape_string($connection, $_POST['edit_announce_date']);
   
      
        // $check = $connection->query("SELECT * FROM announcement where Id = '$announcement_id'")->num_rows;
        // if($check > 0){
        //     $res = [
        //         'status' => 421,
        //         'message' => 'Announcement is already exist!'
        //     ];
        //     echo json_encode($res);
        //     return;
        // }
	if($title == NULL)
    {
        $res = [
            'status' => 422,
            'message' => 'title is empty!'
        ];
        echo json_encode($res);
        return;
    }
	if($description == NULL)
    {
        $res = [
            'status' => 422,
            'message' => 'description is empty!'
        ];
        echo json_encode($res);
        return;
    }
    if($start_time == NULL)
    {
        $res = [
            'status' => 422,
            'message' => 'Start time is empty!'
        ];
        echo json_encode($res);
        return;
    }
    if($end_time == NULL)
    {
        $res = [
            'status' => 422,
            'message' => 'End time is empty!'
        ];
        echo json_encode($res);
        return;
    }
    if($announce_date == NULL)
    {
        $res = [
            'status' => 422,
            'message' => 'Date is empty!'
        ];
        echo json_encode($res);
        return;
    }
    $query = "UPDATE teacher_announcement SET title ='$title',description ='$description',start_time ='$start_time',end_time ='$end_time',announce_date ='$announce_date' WHERE Id='$announcement_id'";
    $query_run = mysqli_query($connection, $query);

    if($query_run)
    {
        $res = [
            'status' => 200,
            'message' => 'Announcement Updated Successfully'
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 500,
            'message' => 'Announcement Not Updated'
        ];
        echo json_encode($res);
        return;
    }
}
if(isset($_GET['t_announcement_id']))
{
    $announcement_id = mysqli_real_escape_string($connection, $_GET['t_announcement_id']);
    $query = "SELECT * FROM teacher_announcement WHERE Id='$announcement_id'";
    $query_run = mysqli_query($connection, $query);

    if(mysqli_num_rows($query_run) == 1)
    {
        $announcement = mysqli_fetch_array($query_run);

        $res = [
            'status' => 200,
            'message' => 'Announcement Fetch Successfully by id',
            'data' => $announcement
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 404,
            'message' => 'Announcement Id Not Found'
        ];
        echo json_encode($res);
        return;
    }
}

// Delete-announcement
if(isset($_POST['tdelete_announcement']))
{
    $announcement_id = mysqli_real_escape_string($connection, $_POST['announcement_id']);

    $query = "DELETE FROM teacher_announcement WHERE Id='$announcement_id'";
    $query_run = mysqli_query($connection, $query);

    if($query_run)
    {
        $res = [
            'status' => 200,
            'message' => 'Announcement Deleted Successfully'
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 500,
            'message' => 'Announcement Not Deleted'
        ];
        echo json_encode($res);
        return;
    }
}

//grades
if(isset($_POST['save_grade'])){
    $faculty_id = mysqli_real_escape_string($connection, $_POST['faculty_id']);
    $student_id = mysqli_real_escape_string($connection, $_POST['student_id']);
    $cs_id = mysqli_real_escape_string($connection, $_POST['cs_id']);
    $quarter_id = mysqli_real_escape_string($connection, $_POST['quarter_id']);
    $written_total = mysqli_real_escape_string($connection, $_POST['written_total']);
    $performance_task = mysqli_real_escape_string($connection, $_POST['performance_task']);
    $quarter_assesment = mysqli_real_escape_string($connection, $_POST['quarter_assesment']);
    $quarter_grade = mysqli_real_escape_string($connection, $_POST['quarter_grade']);
    $comment = mysqli_real_escape_string($connection, $_POST['comment']);

    $ww_score1 = mysqli_real_escape_string($connection, $_POST['ww_score1']);
    $ww_score2 = mysqli_real_escape_string($connection, $_POST['ww_score2']);
    $ww_score3 = mysqli_real_escape_string($connection, $_POST['ww_score3']);
    $ww_score4 = mysqli_real_escape_string($connection, $_POST['ww_score4']);
    $ww_score5 = mysqli_real_escape_string($connection, $_POST['ww_score5']);
    $pt_score1 = mysqli_real_escape_string($connection, $_POST['pt_score1']);
    $pt_score2 = mysqli_real_escape_string($connection, $_POST['pt_score2']);
    $pt_score3 = mysqli_real_escape_string($connection, $_POST['pt_score3']);
    $pt_score4 = mysqli_real_escape_string($connection, $_POST['pt_score4']);
    $pt_score5 = mysqli_real_escape_string($connection, $_POST['pt_score5']);
    $qa_score1 = mysqli_real_escape_string($connection, $_POST['qa_score1']);


    $check = $connection->query("SELECT * FROM grades where student_id = '$student_id' AND class_subject_id = '$cs_id' AND quarter_id = '$quarter_id' ")->num_rows;
    if($check > 0){
        $res = [
            'status' => 421,
            'message' => 'This student have already grades! Use edit to update the grades.'
        ];
        echo json_encode($res);
        return;
    }


 $sql = "INSERT INTO `grades`( `faculty_id`,`student_id`, class_subject_id,`quarter_id`, `written_work`, `performance_task`, `quarterly_assesment`,`quarterly_grade`,`comment`,`ww1`,`ww2`,`ww3`,`ww4`,`ww5`,`pt1`,`pt2`,`pt3`,`pt4`,`pt5`,`qa`) VALUES 
('$faculty_id','$student_id','$cs_id','$quarter_id','$written_total','$performance_task','$quarter_assesment','$quarter_grade','$comment','$ww_score1','$ww_score2','$ww_score3','$ww_score4','$ww_score5','$pt_score1','$pt_score2','$pt_score3','$pt_score4','$pt_score5','$qa_score1')";
    
   $query_run = mysqli_query($connection, $sql);
   if($query_run)
    {
        $res = [
            'status' => 201,
            'message' => 'Grade Save Successfully'
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 500,
            'message' => 'Grade Not Added'
        ];
        echo json_encode($res);
        return;
    }
}

// Update-save_grade
if(isset($_POST['update_grade']))
{
        $grade_Id = mysqli_real_escape_string($connection, $_POST['grade_Id']);
        $equarter_assesment = mysqli_real_escape_string($connection, $_POST['equarter_assesment']);
        $eperformance_task = mysqli_real_escape_string($connection, $_POST['eperformance_task']);
        $equarter_grade = mysqli_real_escape_string($connection, $_POST['equarter_grade']);
        $ewritten_work = mysqli_real_escape_string($connection, $_POST['ewritten_work']);
        $ecomment = mysqli_real_escape_string($connection, $_POST['ecomment']);

        $eww_score1 = mysqli_real_escape_string($connection, $_POST['eww_score1']);
        $eww_score2 = mysqli_real_escape_string($connection, $_POST['eww_score2']);
        $eww_score3 = mysqli_real_escape_string($connection, $_POST['eww_score3']);
        $eww_score4 = mysqli_real_escape_string($connection, $_POST['eww_score4']);
        $eww_score5 = mysqli_real_escape_string($connection, $_POST['eww_score5']);
        $ept_score1 = mysqli_real_escape_string($connection, $_POST['ept_score1']);
        $ept_score2 = mysqli_real_escape_string($connection, $_POST['ept_score2']);
        $ept_score3 = mysqli_real_escape_string($connection, $_POST['ept_score3']);
        $ept_score4 = mysqli_real_escape_string($connection, $_POST['ept_score4']);
        $ept_score5 = mysqli_real_escape_string($connection, $_POST['ept_score5']);
        $eqa_score1 = mysqli_real_escape_string($connection, $_POST['eqa_score1']);

    $query = "UPDATE grades SET written_work ='$ewritten_work',quarterly_assesment ='$equarter_assesment',performance_task ='$eperformance_task',quarterly_grade ='$equarter_grade', comment ='$ecomment',  
    ww1 ='$eww_score1',ww2 ='$eww_score2',
    ww3 ='$eww_score3',ww4 ='$eww_score4',
    ww5 ='$eww_score5',pt1 ='$ept_score1',
    pt2 ='$ept_score2',pt3 ='$ept_score3',
    pt4 ='$ept_score4',pt5 ='$ept_score5',
    qa ='$eqa_score1',
    added_At = NOW() 
    WHERE Id='$grade_Id'";
    $query_run = mysqli_query($connection, $query);

    if($query_run)
    {
        $res = [
            'status' => 200,
            'message' => 'Grade Updated Successfully'
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 500,
            'message' => 'Grade Not Updated'
        ];
        echo json_encode($res);
        return;
    }
}
if(isset($_GET['grade_Id']))
{
    $grade_Id = mysqli_real_escape_string($connection, $_GET['grade_Id']);
    $query = "SELECT * FROM grades WHERE Id='$grade_Id'";
    $query_run = mysqli_query($connection, $query);

    if(mysqli_num_rows($query_run) == 1)
    {
        $grades = mysqli_fetch_array($query_run);

        $res = [
            'status' => 200,
            'message' => 'Grade Fetch Successfully by id',
            'data' => $grades
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 404,
            'message' => 'This student doesnt have a grade!'
        ];
        echo json_encode($res);
        return;
    }
}

 ?>