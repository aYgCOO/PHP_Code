<?php
include "db_connection.php";
session_start();
ini_set('display_errors', 0);
?>

<!DOCTYPE html>
<html lang="en">

<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <?php include "bootstrapcss-and-icons.php"; ?>
     <title>Catagory-Page</title>
</head>
<?php include "fonts.php"; ?>
<style>
     :root {
          --success-result: #86efac;
     }
</style>

<body>
     <?php include "header.php"; ?>
     <!-- Hero Section -Start -->
     <div class="px-4 py-5 my-1 text-center">
          <img class="d-block mx-auto" src="/docs/5.0/assets/brand/bootstrap-logo.svg" alt="" width="72" height="57">
          <h1 class="display-5 fw-bold">Centered hero</h1>
          <div class="col-lg-6 mx-auto">
               <p class="lead mb-4">Quickly design and customize responsive mobile-first sites with Bootstrap, the
                    world’s most popular front-end open source toolkit, featuring Sass variables and mixins, responsive
                    grid system, extensive prebuilt components, and powerful JavaScript plugins.</p>
               <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                    <button type="button" class="btn btn-dark btn-lg px-4 gap-3"><a href="Chats/chatroom.php"
                              style="text-decoration:none; color:white;"><i class="ri-chat-3-fill"></i> Live
                              Chat</a></button>
                    <?php
                    if (!isset($_SESSION['username'])) {
                         ?>
                         <button type="button" class="btn btn-secondary btn-lg px-4">
                              <a href="login.php" style="text-decoration:none; color:white;"><i
                                        class="ri-login-circle-line"></i> Log
                                   In</a>
                         </button>
                         <?php
                    }
                    ?>

               </div>
          </div>
     </div>
     <!-- Hero Section -End -->


     <!-- Action Section -Start -->
     <div class="container">
          <!-- Search-bar -Start -->
          <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post"
               class=" container  py-3 d-flex">
               <button type="button" class=" btn btn-dark mx-5" style="width:200px;" data-bs-toggle="modal"
                    data-bs-target="#exampleModal">
                    Create a new disk
               </button>
               <input class="form-control rounded-0" style="width:800px;" type="search"
                    placeholder="Search Disks by name, date, content.." name="search"
                    aria-label="default input example">
               <button type="submit" name="submit" class="btn btn-dark rounded-0"><i
                         class="ri-search-line"></i></button>
          </form>
          <?php
          if (isset($_POST['submit'])) {
               $search = mysqli_real_escape_string($conn, $_POST['search']);
               if (!empty($search)) {
                    $search_query = "SELECT * FROM `catagory` WHERE catagory_name LIKE '%{$search}%' OR catagory_desc LIKE '%{$search}%' OR created LIKE '%{$search}%' ";
                    $result = mysqli_query($conn, $search_query);
                    if ($result) {
                         if (mysqli_num_rows($result) > 0) {
                              while ($search_disk = mysqli_fetch_assoc($result)) {
                                   ?>
                                   <a href="disk.php?Disk=<?php echo $search_disk['catagory_id']; ?>" style="text-decoration:none; color:white;"
                                        class="">
                                        <div class="card px-3 py-3 container" style="background-color:var(--success-result);">
                                             <div class="card-body">
                                                  <h5 class="card-title">
                                                       <?php echo $search_disk['catagory_name']; ?><br>
                                                       <b style="font-size:11px; font-weight:lighter;">Disk added on:
                                                            <?php echo $search_disk['created']; ?>
                                                       </b>
                                                  </h5>
                                                  <p class="card-text" style="font-size:12px;">
                                                       <?php echo $search_disk['catagory_desc']; ?>
                                                  </p>

                                             </div>
                                        </div>
                                   </a>
                                   <?php
                              }
                         } else {
                              echo "No Search Found : (";
                         }
                    } else {
                         echo "Something went wrong!";
                    }
               }
          }
          ?>
          <!-- Search-bar -End -->


          <!-- Createt New Disk -Start  -->

          <?php
          if (isset($_POST["submit"])) {
               $catagory_created_by = $_SESSION['username'];
               $catagory_name = mysqli_real_escape_string($conn, $_POST['catagory_name']);
               $catagory_desc = mysqli_real_escape_string($conn, $_POST['about']);
               if (!empty($_POST['catagory_name']) && !empty($_POST['about'] && !empty($catagory_created_by))) {

                    $sql_query = "INSERT INTO `catagory` (`catagory_name`, `catagory_desc` ,`created_by`) VALUES ( '{$catagory_name}', '{$catagory_desc}', '{$catagory_created_by}');";
                    $result = mysqli_query($conn, $sql_query);
                    if ($result) {
                         echo "<script>window.location='index.php'</script>";
                         exit();


                    } else {
                         echo "<s>alert('Somthing Went wrong : (');</script>";
                    }

               }
          }
          ?>
          <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
               aria-hidden="true">
               <div class="modal-dialog">
                    <div class="modal-content">
                         <div class="modal-header">
                              <h1 class="modal-title fs-5" id="exampleModalLabel">Create a new disk</h1>
                              <button type="button" class="btn-close" data-bs-dismiss="modal"
                                   aria-label="Close"></button>
                         </div>
                         <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
                              <div class="modal-body">
                                   <div class="mb-3">
                                        <input type="text" value="<?php echo $_SESSION['username'] ?>" disabled>
                                        <label for="exampleFormControlInput1" class="form-label">Disk name</label>
                                        <input type="text" class="form-control" name="catagory_name"
                                             id="exampleFormControlInput1" placeholder="Enter your disk name...">
                                   </div>
                                   <div class="mb-3">
                                        <label for="exampleFormControlTextarea1" class="form-label">About</label>
                                        <textarea class="form-control" name="about" id="exampleFormControlTextarea1"
                                             rows="3" placeholder="Talking about..."></textarea>
                                   </div>

                              </div>
                              <div class="modal-footer">
                                   <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                   <button type="submit" name="submit" class="btn btn-dark">Create</button>
                              </div>
                         </form>


                    </div>
               </div>
          </div>
          <!-- Create New Disk -End -->
     </div>
     <!-- Action Section -End  -->



     <!-- Middilbody -Start -->
     <div class="container d-flex px-3 py-3 row" style="margin:auto;">
          <?php
          $sql = "SELECT * FROM `catagory`";
          $print = mysqli_query($conn, $sql);
          if ($print) {
               if (mysqli_num_rows($print) > 0) {
                    while ($disk = mysqli_fetch_assoc($print)) {
                         ?>
                         <!-- Disk Fetch -Start -->
                         <a href="disk.php?Disk=<?php echo $disk['catagory_id']; ?>" style="text-decoration:none; color:white;"
                              class="row">
                              <div class="card mx-2 my-2">
                                   <!-- Disk Card -Start -->

                                   <div class="card-body">
                                        <h5 class="card-title">
                                             <i class="ri-hard-drive-fill"></i>
                                             <?php echo $disk['catagory_name']; ?><br>
                                             <b style="font-size:11px; font-weight:lighter;">Disk added on:
                                                  <?php echo $disk['created']; ?>
                                             </b>
                                        </h5>
                                        <p class="card-text" style="font-size:12px;">
                                             <?php echo $disk['catagory_desc']; ?>
                                        </p>

                                   </div>

                                   <!-- Disk Card -End -->
                              </div>
                         </a>
                         <!-- Disk Fetch -End -->
                         <?php
                    }
               } else {
                    echo "<h5>No Disk Found : (</h5>";
               }
          } else {
               echo "<h5>Somthing Went Wrong! : (</h5>";
          }



          ?>
     </div>
     <!-- Middlebody -End -->

     <?php include "footer.php"; ?>
     <?php include "bootstrapjs.php"; ?>
</body>

</html>