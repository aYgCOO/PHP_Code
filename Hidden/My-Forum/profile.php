<?php
include "db_connection.php";
session_start();
error_reporting(0);
ini_set('display_errors', 0);
?>
<!DOCTYPE html>
<html lang="en">

<head>
     <meta charset="UTF-8" />
     <meta name="viewport" content="width=device-width, initial-scale=1.0" />
     <?php include "bootstrapcss-and-icons.php"; ?>
     <title>Welcome to fSociety - "your hidden society" - Login</title>

     <?php include "fonts.php"; ?>
     <style>
          ul li {
               list-style-type: none;
          }

          * {
               margin: 0;
               padding: 0
          }



          .card {
               width: 350px;
               background-color: #efefef;
               border: none;
               cursor: pointer;
               transition: all 0.5s;
          }

          .image img {
               transition: all 0.5s
          }

          .card:hover .image img {
               transform: scale(1.5)
          }

          .name {
               font-size: 22px;
               font-weight: bold
          }

          .idd {
               font-size: 14px;
               font-weight: 600
          }

          .idd1 {
               font-size: 12px
          }

          .number {
               font-size: 22px;
               font-weight: bold
          }

          .follow {
               font-size: 12px;
               font-weight: 500;
               color: #444444
          }

          .btn1 {
               height: 40px;
               width: 150px;
               border: none;
               background-color: #000;
               color: #aeaeae;
               font-size: 15px
          }

          .text span {
               font-size: 13px;
               color: #545454;
               font-weight: 500
          }

          .icons i {
               font-size: 19px
          }

          hr .new1 {
               border: 1px solid
          }

          .join {
               font-size: 14px;
               color: #a0a0a0;
               font-weight: bold
          }

          .date {
               background-color: #ccc
          }
     </style>

</head>

<body class="bg-light">

     <?php include "header.php"; ?>




     <?php
     $username = $_SESSION['username'];

     ?>
     <?php
     $sql_query = "SELECT * FROM `user` WHERE username = '$username'";
     $result = mysqli_query($conn, $sql_query);

     if ($result) {
          if (mysqli_num_rows($result) > 0) {
               while ($row = mysqli_fetch_assoc($result)) {
                    ?>


                    <div class="container d-flex p-2 py-5 bg-dark w-75 border my-2 rounded">
                         <div class="container p-2 w-100 border rounded" style="background-color:white;">
                              <div class="d-flex flex-column justify-content-center align-items-center">
                                   <img src="img/images/<?php echo $row['profile_pic']; ?>" class="rounded-circle border" height="180"
                                        width="180" />
                                   <span class="name mt-3">
                                        <?php echo $row['username']; ?>
                                   </span>
                                   <div class="d-flex flex-row justify-content-center align-items-center gap-2"> <span class="idd1">@
                                             <?php echo $row['username']; ?>
                                        </span>

                                   </div>
                                   <span>
                                        <i class="ri-flag-fill"></i>
                                        <?php echo $row['country']; ?>
                                   </span>
                                   <span style="font-size:8px;">Joined
                                        <?php echo $row['datetime']; ?>
                                   </span>
                                   <span style="font-size:13px;"><i class="ri-cake-2-fill"></i>
                                        <?php echo $row['cake_day']; ?>
                                   </span>
                                   <div class=" d-flex mt-2">
                                        <button class="btn btn-dark btn-sm dropdown-toggle rounded-0" type="button"
                                             data-bs-toggle="dropdown" aria-expanded="false">
                                             <i class="ri-user-settings-fill"></i> Account Setting
                                        </button>
                                        <ul class="dropdown-menu text-light px-3 py-3 bg-dark rounded-0">
                                             <li><a href="profile.php?action=edit" style="text-decoration:none;">Edit
                                                       Profile</a></li>
                                             <li><a href="profile.php?action=change_profile_image" style="text-decoration:none;">Change
                                                       Profile Image</a>
                                             </li>
                                             <li><a href="profile.php?action=change_password" style="text-decoration:none;">Change
                                                       Password</a></li>

                                             <li><a href="profile.php?action=delete" style="text-decoration:none;">Delete
                                                       Profile</a></li>
                                             <hr>
                                             <li><a href="your-disks.php" style="text-decoration:none;">your disks</a></li>
                                             <li><a href="your-threads.php" style="text-decoration:none;">your threads</a></li>
                                             <li><a href="your-comments.php" style="text-decoration:none;">your comments</a></li>
                                        </ul>

                                   </div>
                                   <div class="text mt-3"> <span>
                                             <?php echo $row['about']; ?>
                                        </span>
                                   </div>
                                   <div class="gap-3 mt-3 icons d-flex flex-row justify-content-center align-items-center">
                                        <span><a href="<?php echo $row['twitter']; ?>"><i class="fa fa-twitter"
                                                       style="font-size:2rem; color:black;"></i></a></span>
                                        <span><a style="text-decoration: none;" href="<?php echo $row['facebook']; ?>"><i
                                                       class="ri-facebook-box-fill"
                                                       style="font-size:2.2rem; color:black;"></i></a></span>
                                        <span><a href="<?php echo $row['instagram']; ?>"><i class="fa fa-instagram"
                                                       style="font-size:2rem; color:black;"></i></a></span>
                                        <span><a href="<?php echo $row['github']; ?>"><i class="fa fa-github"
                                                       style="font-size:2rem; color:black;"></i></a></span>
                                   </div>

                              </div>
                         </div>
                    </div>



                    <div class="container d-flex p-2 bd-highlight w-75" style="background-color:none;">

                         <?php
                         $action = isset($_GET['action']) ? $_GET['action'] : "";

                         $username = $_SESSION['username'];
                         if ($action == "edit") {

                              ?>
                              <p style="font-size:12px;">If you want to edit your profile pic and other informtions just click this <a
                                        href="editprofile.php?update=<?php echo $row['id']; ?>">edit</a> button.
                              </p>
                              <?php
                         } elseif ($action == "change_password") {
                              ?>
                              <p style="font-size:12px;">If you want to change your password just click on this <a
                                        href="editprofile_password.php?change=<?php echo $row['id']; ?>">Change Password</a> button.
                              </p>


                              <?php
                         } elseif ($action == "change_profile_image") {
                              ?>
                              <p style="font-size:12px;">If you want to delete your account just click on the is <a
                                        href="editprofile-image.php?update=<?php echo $row['id']; ?>">Change Profile Image</a>
                                   button.
                              </p>
                              <?php


                         } elseif ($action == "delete") {
                              ?>
                              <p style="font-size:12px;">If you want to delete your account just click on the is <a
                                        href="deleteprofile.php?delete=<?php echo $row['id']; ?>">delete</a> button.
                              </p>

                              <?php

                         }
               }

          } else {
               header("Location: index.php");
          }
          ?>
          </div>

          <?php


     }
     ?>






     <?php include "footer.php"; ?>
     <?php include "bootstrapjs.php"; ?>

</body>

</html>