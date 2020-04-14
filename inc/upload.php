<?php
//print_r($_POST);
  if (isset($_FILES['filename'])){
    if(isset($_SESSION['image']))
    unset($_SESSION['image']);
  $form_filled=false;
}
else
  $form_filled=true;
?>
<div class="container-fluid">
  <div class="col-lg-12">

    <div class="col-lg-12">
    <?php
    if ($form_filled) {
      if (isset($_SESSION["filename"])){
       echo  '<div class="card mb-4 py-3 border-left-danger">
                <div class="card-body">
                  You have already uploaded '.$_SESSION["filename_ori"].' file. If you upload a new file, you will loose your current project.
                </div>
              </div>';
      }
      ?>

      <div class="row" id="upload_form">
        <form  method="post" enctype="multipart/form-data" action="index.php">
            <input type="hidden" name="MAX_FILE_SIZE" value="3000000" />
            <input type="file" name="filename" id="filename">
            <input type="hidden" name="action" value="<?php echo $action; ?>">
            <input class="text" type="submit"  name="submit">
        </form>
      </div>
    <?php } else {
      $target_dir = "uploads/";
      $imageFileType = strtolower(pathinfo($_FILES['filename']['name'],PATHINFO_EXTENSION));
      $filename_ori=basename($_FILES["filename"]["name"]);
      $filename=microtime().".".$imageFileType;
      
      $target_file=$target_dir.$filename;


      $uploadOk = 1;
      // Check if image file is a actual image or fake image
      if(isset($_REQUEST["submit"])) {
          $check = getimagesize($_FILES["filename"]["tmp_name"]);
          if($check !== false) {
              $uploadOk = 1;
          } else {
              echo "Error:File is not an image.";
              $uploadOk = 0;
          }
      }
      // Check if file already exists
      if (file_exists($target_file)) {
          echo "Sorry, file already exists.";
          $uploadOk = 0;
      }
      // Check file size
      if ($_FILES["filename"]["size"] > 500000) {
          echo "Sorry, your file is too large.";
          $uploadOk = 0;
      }
      // Allow certain file formats
      if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
      && $imageFileType != "gif" ) {
          echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
          $uploadOk = 0;
      }
      // Check if $uploadOk is set to 0 by an error
      if ($uploadOk == 0) {
          echo "Sorry, your file was not uploaded.";
      // if everything is ok, try to upload file
      } else {
          if (move_uploaded_file($_FILES["filename"]["tmp_name"], $target_file)) {
              echo  '<div class="card mb-4 py-3 border-left-success ">
              <div class="card-body">
              The file '. basename( $_FILES["filename"]["name"]). ' has been uploaded.
              </div>
            </div>';

              $_SESSION['filename']=$filename;
              $_SESSION['filename_ori']=$filename_ori;
              ?>
                <a href="index.php?action=textboxes" class="btn btn-primary btn-icon-split">
                  <span class="icon text-white-50">
                    <i class="fas fa-flag"></i>
                  </span>
                  <span class="text">Next Step</span>
                </a>  
              <?php
          } else {
              echo "Sorry, there was an error uploading your file.";
          }
      }
      ?>
  <?php  } ?>

    </div>
  </div>
</div>
