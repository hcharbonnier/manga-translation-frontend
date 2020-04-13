<div class="container-fluid">
  <div class="col-lg-12">
      <!-- 404 Error Text -->
      <div class="row">
        <div class="text-center">
          <p class="lead text-gray-800 mb-5">Detect Texboxes</p>
      </div>
  </div>
    <div class="col-lg-12">
      <?php 

        if ( isset($_SESSION['image'])){
          $_SESSION['image']->write_translation();
          $_SESSION['image']->export("uploads/".$_SESSION['filename_ori'],90);
          echo "<img src=uploads/".$_SESSION['filename_ori'].">";
        } else {
          echo "image does not exists";
        }
      ?>
    </div>
  </div>
</div>
