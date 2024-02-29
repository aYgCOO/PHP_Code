<?php
include "../db_connection.php";
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <?php include "../bootstrapcss-and-icons.php"; ?>
     <title>Document</title>
</head>
<?php include "../fonts.php"; ?>

<body>
     <!-- All threads section -Start  -->
     <?php

     $sql = "SELECT * FROM `threads`";
     $result = mysqli_query($conn, $sql);
     if ($result) {
          if (mysqli_num_rows($result) > 0) {
               while ($thread = mysqli_fetch_assoc($result)) {
                    ?>
                    <!-- Thread box -Start  -->
                    <div class="card rounded-0">
                         <div class="card-body">
                              <h5 class="card-title">
                                   <?php echo $thread['thread_name']; ?>
                              </h5>
                              <h6 class="card-subtitle mb-2 text-body-secondary">
                                   <b style="color:black;">
                                        <?php echo '@' . $thread['thread_created_by']; ?>
                                   </b><br>
                                   <b style="font-weight:lighter; font-size:12px;">
                                        <?php echo $thread['thread_time']; ?>
                                   </b>
                              </h6>
                              <p class="card-text">
                                   <?php
                                   if (empty($thread['uploaded_image'])) {

                                   } else {
                                        ?>
                                        <img src="../img/upload/<?php echo $thread['uploaded_image']; ?>"
                                             class="figure-img img-fluid rounded" alt="..." width="300px" height="300px">
                                        <?php
                                   }
                                   ?><br>
                                   <?php echo $thread['thread_desc']; ?>
                              </p><br>
                              <img src="img/upload/<?php echo $thread['uploaded_image']; ?>" class="img-thumbnail" alt=""
                                   width="200vw"><br>
                              <a href="delete-threads.php?delete=<?php echo $thread['thread_id']; ?>" class="card-link text-light"
                                   style="text-decoration:none; font-size:1rem;"><button type="button" class="btn btn-danger rounded-0">Banned <i class="ri-delete-bin-5-line"></i></a></button>
                         </div>
                    </div>
                    <!-- Thread box -End  -->
                    <?php
               }

          } else {
               echo "No threads Found !";
          }
     }
     ?>
     <!-- All threads section -End  -->

     <?php include "../bootstrapjs.php"; ?>
</body>

</html>