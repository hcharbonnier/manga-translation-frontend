<div class="container-fluid">
  <div class="col-lg-12">
    <div class="col-lg-12">
      <?php

        if ( isset($_SESSION['image'])){

          $blocks=$_SESSION['image']->get_blocks();
          for($i=0 ; isset($blocks[$i]);$i++){
            $ocr[$i]=$_SESSION['image']->get_block_ocr($i);
            $trans[$i]=$_SESSION['image']->get_block_translation($i);
            echo  "<p>".$ocr[$i]."<br>";
            echo  $trans[$i]."</p>";

          }
          ?>
<a href="index.php?action=clean_raw" class="btn btn-primary btn-icon-split">
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
