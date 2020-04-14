<div class="container-fluid">
  <div class="col-lg-12">
    <div class="col-lg-12">
      <?php

        if ( isset($_SESSION['image'])){
          $_SESSION['image']->translate();
          $blocks=$_SESSION['image']->get_blocks();

          echo "<table border=1>";
          for($i=0 ; isset($blocks[$i]);$i++){
            $ocr[$i]=$_SESSION['image']->get_block_ocr($i);
            $trans[$i]=$_SESSION['image']->get_block_translation($i);
            echo  "<tr><td>".$ocr[$i]."</td>";
            echo  "<td>".$trans[$i]."</td></tr>";
          }
          echo "</table>";
          ?>
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
