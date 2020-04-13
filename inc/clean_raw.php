<div class="container-fluid">
  <div class="col-lg-12">
    <div class="col-lg-12">
      <?php

        if ( isset($_SESSION['image'])){

          $_SESSION['image']->clean_raw();
      ?>
      <div class="card mb-4 py-3 border-left-success ">
              <div class="card-body">
              Raw cleaned.
              </div>
          </div>
<a href="index.php?action=export" class="btn btn-primary btn-icon-split">
                  <span class="icon text-white-50">
                    <i class="fas fa-flag"></i>
                  </span>
                  <span class="text">Next Step</span>
                </a>  
<?php
        } else {
          echo "image does not exists";
        }
      ?>
    </div>
  </div>
</div>
