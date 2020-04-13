<div class="container-fluid">
  <div class="col-lg-12">
    <div class="col-lg-12">
      <?php

        if ( isset($_SESSION['image'])){

          $blocks=$_SESSION['image']->get_blocks();

          echo "<table border=1>";
          for($i=0 ; isset($blocks[$i]);$i++){
            $ocr[$i]=$_SESSION['image']->get_block_ocr($i);
            $trans[$i]=$_SESSION['image']->get_block_image_path($i);

            echo "<tr>";
            echo  "<td>".$ocr[$i]."</td>";
            echo  "<td><img src='".$trans[$i]."'></td>";
            echo "</tr>";
          }
          echo "</table>";          
?>
<a href="index.php?action=translate" class="btn btn-primary btn-icon-split">
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
