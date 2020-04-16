<div class="container-fluid">
  <div class="col-lg-12">
    <?php 
      if ( isset($_SESSION['image'])){
        $_SESSION['image']->clean_raw();
        $_SESSION['image']->write_translation();
        $_SESSION['image']->export("uploads/".$_SESSION['filename_ori'],90);
        echo "<img src=uploads/".$_SESSION['filename_ori'].">";
      } else {
        echo "Upload image first!!";
      }
    ?>
  </div>
</div>
