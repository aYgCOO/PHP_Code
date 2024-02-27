<?php
include "db_connection.php";
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <?php include "bootstrapcss-and-icons.php"; ?>
     <title>Disk</title>
</head>
<?php include "fonts.php"; ?>

<body class="bg-light">
     <?php include "header.php"; ?>
     <!-- View Disk Hero -Start   -->
     <?php
     $disk_id = mysqli_real_escape_string($conn, $_GET['Disk']);
     $sql_query = "SELECT * FROM `catagory` WHERE catagory_id = '{$disk_id}'";
     $result = mysqli_query($conn, $sql_query);
     if ($result) {
          if (mysqli_num_rows($result) > 0) {
               while ($disk = mysqli_fetch_assoc($result)) {
                    ?>

                    <div class="container px-2 py-2 ">
                         <div class="card text-center ">
                              <div class="card-header">
                                   Disk
                                   <?php echo $disk['catagory_id']; ?><br>
                                   Created by
                                   <?php echo $disk['created_by'] ?>
                              </div>
                              <div class="card-body">
                                   <h2 class="card-title">
                                        Welcome to
                                        <?php echo $disk['catagory_name']; ?> disk
                                   </h2>
                                   <p class="card-text px-5">
                                        <?php echo $disk['catagory_desc']; ?>
                                   </p>
                                   <a href="index.php" class="btn btn-dark rounded-0">Go to another disk</a>
                              </div>

                              <div class="card-footer text-body-secondary">
                                   <?php echo $disk['created']; ?>
                              </div>
                         </div>
                    </div>
                    <!-- View Disk Hero -End  -->

                    <!-- Thread form start  -->
                    <div class="container py-3">
                         <?php
                         $alert = false;
                         $method = $_SERVER['REQUEST_METHOD'];
                         if ($method == 'POST') {
                              $get_id = mysqli_real_escape_string($conn, $_GET['Disk']);
                              if (isset($_POST['submit'])) {
                                   // Input details
                                   $topic_name = mysqli_real_escape_string($conn, $_POST['topic']);
                                   $topic_desc = mysqli_real_escape_string($conn, $_POST['topic_desc']);
                                   // Image file handling
                                   $image_name = $_FILES['image']['name'];
                                   $tmp_name = $_FILES['image']['tmp_name'];
                                   $image_error = $_FILES['image']['error'];
                                   $image_size = $_FILES['image']['size'];
                                   // Image file path destination
                                   $image_path_destination = "img/upload/";
                                   // Generate unique filename
                                   $image_new_name = uniqid('', true) . '_' . $image_name;
                                   // Check if text and image are both provided
                                   if (!empty($topic_name) && !empty($topic_desc) && !empty($image_name)) {
                                        // Check file size and type
                                        $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
                                        $image_extension = strtolower(pathinfo($image_new_name, PATHINFO_EXTENSION));
                                        if ($image_size > 0 && in_array($image_extension, $allowed_types)) {
                                             if ($image_size <= 999998) {
                                                  // Upload the file
                                                  if (move_uploaded_file($tmp_name, $image_path_destination . $image_new_name)) {
                                                       // Insert data into database
                                                       $username = $_SESSION['username'];
                                                       $sqlquery = "SELECT * FROM `user` WHERE username = '{$username}'";
                                                       $user = mysqli_query($conn, $sqlquery);
                                                       if (mysqli_num_rows($user) > 0) {
                                                            $user_account = mysqli_fetch_assoc($user);
                                                            $thread_user_id = $user_account['id'];
                                                            $sql_query = "INSERT INTO `threads` (`thread_name`, `thread_desc`, `thread_catagory_id`, `thread_user_id`,`thread_created_by`,`uploaded_image`) VALUES ('{$topic_name}', '{$topic_desc}', '{$get_id}', '{$thread_user_id}','{$username}','{$image_new_name}' )";
                                                            $result = mysqli_query($conn, $sql_query);
                                                            if ($result) {
                                                                 $alert = true;
                                                            } else {
                                                                 echo "Oops! Something went wrong :(";
                                                            }
                                                       } else {
                                                            echo "User not found!";
                                                       }
                                                  } else {
                                                       echo "Sorry, there was an error uploading your file!";
                                                  }
                                             } else {
                                                  echo "File size exceeds limit!";
                                             }
                                        } else {
                                             echo "Only JPG, JPEG, PNG, and GIF files are allowed!";
                                        }
                                   } else if (!empty($topic_name) && !empty($topic_desc)) {
                                        // Insert data into database without image
                                        $username = $_SESSION['username'];
                                        $sqlquery = "SELECT * FROM `user` WHERE username = '{$username}'";
                                        $user = mysqli_query($conn, $sqlquery);
                                        if (mysqli_num_rows($user) > 0) {
                                             $user_account = mysqli_fetch_assoc($user);
                                             $thread_user_id = $user_account['id'];
                                             $sql_query = "INSERT INTO `threads` (`thread_name`, `thread_desc`, `thread_catagory_id`, `thread_user_id`, `thread_created_by`) VALUES ('{$topic_name}', '{$topic_desc}', '{$get_id}', '{$thread_user_id}', '{$username}')";
                                             $result = mysqli_query($conn, $sql_query);
                                             if ($result) {
                                                  $alert = true;
                                             } else {
                                                  echo "Oops! Something went wrong :(";
                                             }
                                        } else {
                                             echo "User not found!";
                                        }
                                   } else {
                                        echo "Please properly create a thread!";
                                   }
                              }
                         }
                         // Success message -start
                         if ($alert) {
                              echo '<div id="alertMsg" class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Your thread has been added successfully. Wait for community response.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
                              ini_set('display_errors', 0);
                              echo '<script>
        setTimeout(function() {
            document.getElementById("alertMsg").style.display = "none";
            window.location="disk.php?Disk=' . $get_id . '";
        }, 2000);
    </script>';

                              //     Success message -end
                         }
                         ?>


                         <h3>Start A Discussion</h3>
                         <?php if (isset($_SESSION['username'])) { ?>
                              <form action="<?php echo htmlentities($_SERVER['REQUEST_URI']); ?>" method="post"
                                   enctype="multipart/form-data">
                                   <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">@</span>
                                        <input type="text" class="form-control" value="<?php echo $_SESSION['username']; ?>"
                                             aria-label="Username" aria-describedby="basic-addon1" disabled>
                                   </div>
                                   <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">Topic</label>
                                        <input type="text" class="form-control" id="exampleFormControlInput1" name="topic">
                                   </div>
                                   <div class="mb-3">
                                        <label for="exampleFormControlTextarea1" class="form-label">Discussion</label>
                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"
                                             name="topic_desc"></textarea>
                                   </div>
                                   <div class="mb-3">
                                        <label class="form-label">Upload Image (optional)</label>
                                        <input class="form-control" type="file" name="image" id="formFileMultiple" multiple>
                                   </div>
                                   <div class="mb-3">
                                        <button type="submit" name="submit" class="btn btn-danger rounded-0">Add Topic</button>
                                   </div>
                              </form>

                              <!-- Thread form -End  -->

                              <!-- Alert message if you are not logged in ... -start -->
                              <?php


                         } else {
                              ?>

                              <div class="alert alert-danger d-flex align-items-center" role="alert">

                                   <use xlink:href="#exclamation-triangle-fill" />
                                   </svg>
                                   <div>
                                        <i class="ri-alert-fill"></i> You are not logged In! Please <a href="login.php"
                                             style="color:maroon;">logIn</a> to start
                                        discussion.
                                   </div>
                              </div>
                              <?php
                         }
                         ?>
                         <!-- Alert message if you are not logged in ... -start -->


                    </div>
                    <!-- Thread list -Start -->
                    <div class="container my-3">
                         <h3>Browes
                              <?php echo $disk['catagory_name']; ?> disk topics
                         </h3>
                    </div>
                    <?php
               }

          } else {
               echo "Invalid Disk ID";
          }


     } else {
          echo "Somthing Went Wrong : (";
     }
     ?>
     <?php
     $disk_id = mysqli_real_escape_string($conn, $_GET['Disk']);
     $sql_query = "SELECT * FROM `threads` WHERE thread_catagory_id = '{$disk_id}'";
     $result = mysqli_query($conn, $sql_query);
     if ($result) {

          if (mysqli_num_rows($result) > 0) {
               $check_result = false;
               while ($thread = mysqli_fetch_assoc($result)) {
                    $thread_id = $thread['thread_id'];
                    $thread_name = $thread['thread_name'];
                    $thread_desc = $thread['thread_desc'];
                    $thread_catagory_id = $thread['thread_catagory_id'];
                    $thread_user_id = $thread['thread_user_id'];
                    $thread_time = $thread['thread_time'];
                    $sql = "SELECT * FROM `user` WHERE id = '{$thread_user_id}'";
                    $run = mysqli_query($conn, $sql);
                    if ($run) {
                         if (mysqli_num_rows($run) > 0) {
                              $user = mysqli_fetch_assoc($run);
                              ?>
                              <div class="container d-flex border py-4 px-4" id="content">
                                   <div class="px-3">
                                        <?php
                                        if (isset($_SESSION['username'])) {
                                             ?>
                                             <a href="allprofile.php?user=<?php echo $user['id']; ?>"><img
                                                       src="img/images/<?php echo $user['profile_pic']; ?>" alt="" width="50px" height="50px"
                                                       class="my-1"></a>

                                             <?php
                                        } else {
                                             echo '<img src="img/images/default.png" alt="" width="50px" height="50px" class="my-1">';
                                        }
                                        ?>
                                   </div>
                                   <div class="text">
                                        <h5>
                                             <a href="allprofile.php?user=<?php echo $user['id']; ?>"
                                                  style="color:black; text-decoration:none; font-size:1rem;">
                                                  <b>@
                                                       <?php echo $user['username']; ?>
                                                  </b>
                                             </a><br>
                                             <b style="font-size:11px; font-weight:lighter;">Post at :
                                                  <?php echo $thread['thread_time']; ?>
                                             </b><br>

                                             <a href="thread.php?thread=<?php echo $thread['thread_id']; ?>" class="text-dark">
                                                  <?php echo $thread['thread_name']; ?>
                                             </a>


                                        </h5>
                                        <p style="font-size:12px;">
                                             <?php echo $thread['thread_desc']; ?>
                                        </p>
                                        <figure class="figure">
                                             <?php if (!empty($thread['uploaded_image'])) {
                                                  ?>
                                                  <img src="img/upload/<?php echo $thread['uploaded_image']; ?>" class="figure-img img-fluid rounded"
                                                       alt="..." width="300px" height="300px">
                                                  <?php
                                             } else {


                                             }
                                             ?>


                                   </div>
                              </div>
                              <?php


                         } else {
                              echo "No user found : (";

                         }

                    } else {
                         echo "User ID Not Found!";
                    }
                    $check_result = true;
               }

               if (!$check_result) {

               }
          } else {
               ?>
               <div class="container px-4">
                    <h2>No Result Found : (</h2>
                    <p style="font-size:12px;">Be the first person to add a topic....</p>
               </div>

               <?php
          }



     } else {
          echo "Somthing Went Wrong : (";
     }
     ?>
     <!-- Thread list -End  -->


     <?php include "footer.php"; ?>
     <?php include "bootstrapjs.php"; ?>
</body>

</html>