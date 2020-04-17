<?php
  if (! isset($_SESSION['image']) && isset($_SESSION['filename'])){

    $_SESSION['image']=new hcharbonnier\mangatranslation\MangaImage('uploads/'.$_SESSION['filename']);
    $_SESSION['image']->detect_block();
  }
?>
<div class="container-fluid">
  <div class="col-lg-12">
    <div class="col-lg-12" align="center">
      <?php

        if ( isset($_SESSION['image'])){
          $img_width=$_SESSION['image']->get_width();
          $img_height=$_SESSION['image']->get_height();
          ?>
      <script src="js/functions.js"></script>
      <style type="text/css">
      canvas{
          background-position: center;
          background-size: 100% 100%;
          background-image: url("<?php echo "uploads/".$_SESSION["filename"] ?>");
      }
      </style>
      <div style='position:fixed;top:200px;'>
        <div class="btn btn-primary btn-icon-split btn-sm" class="text" onclick=hide_blocks()>Hide Blocks</div> <br>
        <div href="#" class="btn btn-primary btn-icon-split btn-sm" class="text" onclick=draw_blocks()>Show blocks</div> <br>
        <div href="#" class="btn btn-primary btn-icon-split btn-sm" class="text" onclick="mergingblock=true;">Merge 2 blocks</div> <br>
        <div href="#" class="btn btn-primary btn-icon-split btn-sm" class="text" onclick="addingblock=true;">Add block</div>
      </div>  
      <canvas id="canvas-textblocks" width="<?php echo $img_width ?>" height="<?php echo $img_height?>">
      </canvas>

      <script>
        var new_blocks=get_blocks();

        console.log('new_blocks_start'+new_blocks);
        var new_block={"x1":0,"y1":0,"x2":0,"y2":0,"x3":0,"y3":0,"x4":0,"y4":0};
        var addingblock=false;
        var mergingblock=false
        var new_circles = [];
        var block1_id=-1;
        var block2_id=-1;
        var blockfound=false;
        var container = document.querySelector("#canvas-textblocks");
        var arr;
    
        container.addEventListener("click", function (event) {
          var xPosition = event.clientX - container.getBoundingClientRect().left;
          var yPosition = event.clientY - container.getBoundingClientRect().top;
          console.log(xPosition,yPosition,addingblock);

          if (addingblock ==true) {
            add_block_event(xPosition,yPosition);
          }

          if (mergingblock ==true) {
            merge_block_event(xPosition,yPosition);
          }

          detect_delete_click(xPosition,yPosition);
        });
  
        window.onload=draw_blocks();
      </script>
      <br>
      <?php
        } else {
          echo "Upload image first!!";
        }
      ?>
    </div>
  </div>
</div>
