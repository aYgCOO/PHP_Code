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
<?php include "admin-header.php"; ?>
     <!-- All disks -Start -->
     <div class="my-2">
     <?php
     $sql = "SELECT * FROM `announcement`";
     $result = mysqli_query($conn, $sql);
     if ($result) {
          if (mysqli_num_rows($result) > 0) {
               while ($anno = mysqli_fetch_assoc($result)) {
                    ?>
                    <!-- Disk box -Start  -->
                    <div class="card rounded-0">
                         <div class="card-body">
                              <h5 class="card-title">
                                   <?php echo $anno['anno_name']; ?>
                              </h5>
                              <h6 class="card-subtitle mb-2 text-body-secondary">
                                   <b style="color:black;">
                                        <?php echo '<i class="ri-user-star-fill"></i>' . $anno['admin_name']; ?>
                                   </b><br>
                                   <b style="font-weight:lighter; font-size:12px;">
                                        <?php echo $anno['anno_date']; ?>
                                   </b>
                              </h6>
                              <p class="card-text">
                                   <?php echo $anno['anno_desc']; ?>
                              </p>
                              <a href="edit-announcement.php?edit=<?php echo $anno['anno_id']; ?>" class="card-link text-success"
                                   style="text-decoration:none; font-size:2rem;"><i class="ri-edit-box-line"></i><a>
                              <a href="delete-announcement.php?delete=<?php echo $anno['anno_id']; ?>" class="card-link text-danger"
                                   style="text-decoration:none; font-size:2rem;"><i class="ri-delete-bin-5-line"></i></a>
                                 
                         </div>
                    </div>
                    <!-- Disk box -End  -->

                    <?php
               }

          } else {
               echo "No Disk Found !";
          }
     }
     ?>
     </div>
     <!-- All disks -End  -->


     <?php include "../bootstrapjs.php"; ?>
</body>

</html>