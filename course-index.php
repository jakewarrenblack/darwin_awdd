<?php require_once 'config.php'; 

// We don't have a login yet so I have this commented out.
// if (!$request->is_logged_in()) {
//   $request->redirect("/login-form.php");
// }
?>
<?php
try {
    // You will learn more about sessions later
    $request->session()->forget("flash_data");
    $request->session()->forget("flash_errors");

    // Call the findAll() function in classes/course.php
    // This function returns an array $courses[] which is retrieved from the database
    $courses = course::findAll();
}
// If there were any exceptions thrown in the above try block they will be caught here and put into the session data.
catch (Exception $ex){
    $request->session()->set("flash_message", $ex->getMessage());
     $request->session()->set("flash_message_class", "alert-warning");
    $courses = [];
    
}

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Courses</title>

    <link href="<?= APP_URL ?>/assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?= APP_URL ?>/assets/css/template.css" rel="stylesheet">
      
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    
      
    <link rel="stylesheet" type="text/css" href="assets/css/myStyle.css">
  </head>
  <body>
   
      <?php require 'include/navbar.php'; ?>
      <?php require "include/flash.php"; ?>
      
    <div class="container-fluid">
      <main role="main">

        <div class="row">
            <div class="col table-responsive">
            <h1>Courses
                 <!-- The add button will call courses-create.php, the create will be implemented at a later stage -->
                 <a class="btn button float-right" href="<?= APP_URL ?>/course-create.php">Add</a>
                </h1>
                <form method="get">
              <table class="table">
                <thead>
                <!-- you already have the stuff you need in the Course class, just changed the headings -->
                  <tr>
                    <th>ID</th>
                    <th>Course name</th>                                        
                    <th>Course code</th>
                    <th>CAO points</th>
                    <th>Start Date</th>                                     
                    <th>Image</th>
                  </tr>
                </thead>
                <tbody>
                  
                  <!-- Loop through the following for every item in the $courses[] array, display title, description, location etc. to the screen -->
                  <?php foreach ($courses as $course) { ?>
                    <tr>
                      <!-- a radio button will display for each course, the user can choose one course then choose the View button below -->
                      <td><input type="radio" name="course_id" value="<?= $course->id ?>" /> </td>
                      <td><?= $course->name_course ?></td>                      
                      <td><?= $course->code_course ?></td>
                      <td><?= $course->cao_points ?></td>
                      <td><?= $course->start_date ?></td>
                      
                        <td>
                        <?php
                            // We have the image_id for the course, now call findById(image_id) in the class Image.php
                            // Image:: findById($image_id) will go to the database to get the image filename from the Image table 
                            $image = Image::findById($course->image_id);
                            if ($image !== null){
                                ?>
                                <!-- same problem again, needs the underscore in the name -->
                                <img src="<?= APP_URL . "/" . $image->file_name ?>" width="50px" alt="image" />
                        <?php
                            }
                            ?>
                        </td>                
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
                <!-- View, Edit and Delete buttons link to the appropriate php file. In this version you will implement course-view.php -->
                <button class="btn button btn-course" formaction="<?= APP_URL ?>/course-view.php">View</button>
                <button class="btn button btn-course" formaction="<?= APP_URL ?>/course-edit.php">Edit</button>
                <button class="btn button btn-course btn-course-delete" formaction="<?= APP_URL ?>/course-delete.php">Delete</button>
                </form>
            </div>
          </div>
      </main>
    </div>
      
   <?php require 'include/footer.php'; ?>
      
    <script src="<?= APP_URL ?>/assets/js/jquery-3.5.1.min.js"></script>
    <script src="<?= APP_URL ?>/assets/js/bootstrap.bundle.min.js"></script>
    <script src="<?= APP_URL ?>/assets/js/course.js"></script>
  </body>
</html>
