<div class="container-fluid">
  <div class="col-lg-12">
    <div class="col-lg-12">
 <?php
  if (isset($_POST['new_blocks'])){
    $new_blocks=json_decode($_POST['new_blocks'],true);
    foreach($new_blocks as $block) {
      $_SESSION['image']->add_block($block['x1'],$block['y1'],$block['x2'],$block['y2'],$block['x3'],$block['y3'],$block['x4'],$block['y4'],false);
    }
    echo '<div class="card mb-4 py-3 border-left-success ">
              <div class="card-body">
              New blocs added!
              </div>
          </div>';
  }
?>

      <?php
      if (! isset($_SESSION['image'])){

        $_SESSION['image']=new hcharbonnier\mangatranslation\MangaImage('uploads/'.$_SESSION['filename']);
        $_SESSION['image']->detect_block();
      }
      ?>
      <div class="row">
        <span class="btn btn-primary btn-icon-split btn-sm" class="text" onclick=hide_blocks()>Hide Blocks</span> &nbsp;
        <span class="btn btn-primary btn-icon-split btn-sm" class="text" onclick=draw_blocks()>Show blocks</span> &nbsp;
        <span class="btn btn-primary btn-icon-split btn-sm" class="text" onclick=addblock()>Add block</span> &nbsp;
        <span class="btn btn-primary btn-icon-split btn-sm" class="text" onclick=restore_blocks()>Restore Originals blocks</span> &nbsp;
        <form id="blocks_form" method="post" enctype="multipart/form-data" action="index.php">
        <input type="hidden" name="action" value="<?php echo $action; ?>">
        <input type="hidden" name="new_blocks" value="">
        <input id="submit" class="btn btn-primary btn-icon-split btn-sm" type="submit"  name="submit" value="Save">
        </form>
      </div>
    </div>
    <div class="col-lg-12">
      <?php

        if ( isset($_SESSION['image'])){
          $blocks=$_SESSION['image']->get_blocks();

          $img_width=$_SESSION['image']->get_width();
          $img_height=$_SESSION['image']->get_height()  ;;
          ?>
    
<style type="text/css">

canvas{
    background-position: center;
    background-size: 100% 100%;
    background-image: url("<?php echo "uploads/".$_SESSION["filename"] ?>");
}
</style>

<canvas id="canvas-textblocks" width="<?php echo $img_width ?>" height="<?php echo $img_height?>">
</canvas>

<script>
  var new_blocks = [];
  var ori_blocks = <?php echo json_encode($blocks); ?>;
  var new_block={"x1":0,"y1":0,"x2":0,"y2":0,"x3":0,"y3":0,"x4":0,"y4":0};
  var addingblock=false;

  function draw_block(x1,y1,x2,y2,x3,y3,x4,y4) {
    var canevas = document.getElementById('canvas-textblocks');
    if (canevas.getContext) {
      var ctx = canevas.getContext('2d');
      ctx.beginPath();
      ctx.moveTo(x1, y1);
      ctx.lineTo(x2, y2);
      ctx.lineTo(x3, y3);
      ctx.closePath();
      ctx.fill();

      ctx.beginPath();
      ctx.moveTo(x3, y3);
      ctx.lineTo(x4, y4);
      ctx.lineTo(x1, y1);
      ctx.closePath();

      ctx.globalAlpha = 0.2;
      ctx.fillStyle = "blue";

      ctx.fill();
    }
  }

  function restore_blocks(){
    //new_blocks = [JSON.parse(JSON.stringify(ori_blocks))];
    new_blocks = [];
    hide_blocks();
    draw_blocks();
    refresh_form_value();
  }

  function draw_circle_mark(x,y){
    var canevas = document.getElementById('canvas-textblocks');
    if (canevas.getContext) {
      var ctx = canevas.getContext('2d');
      ctx.moveTo(x,y);
      ctx.arc(x, y, 3, 0, 2 * Math.PI, false);
      ctx.globalAlpha = 0.2;
      ctx.fillStyle = "red";
      ctx.stroke();

      console.log("draw circle", x, y);
    }
  }

  function hide_blocks () {
    var canevas = document.getElementById('canvas-textblocks');
    if (canevas.getContext) {
      var ctx = canevas.getContext('2d');
      ctx.clearRect(0,0,canevas.width,canevas.height);
    }
  }

  function  draw_blocks(){
    new_blocks.forEach(value => draw_block(value.x1,value.y1,value.x2,value.y2,value.x3,value.y3,value.x4,value.y4));
    ori_blocks.forEach(value => draw_block(value.x1,value.y1,value.x2,value.y2,value.x3,value.y3,value.x4,value.y4));
  }

  function refresh_form_value(){
    var oFormObject = document.getElementById('blocks_form');
    oFormObject.elements["new_blocks"].value = JSON.stringify(new_blocks);
  }


  var container = document.querySelector("#canvas-textblocks");
    var arr;
    container.addEventListener("click", function(event) {
        var xPosition = event.clientX - container.getBoundingClientRect().left;
        var yPosition = event.clientY - container.getBoundingClientRect().top;
        console.log(xPosition,yPosition,addingblock);

        if (addingblock ==true) {
          if (new_block.x1 == 0 && new_block.y1 == 0){
            new_block.x1=Math.round(xPosition);
            new_block.y1=Math.round(yPosition);
            draw_circle_mark(new_block.x1,new_block.y1);
            console.log("x1");
          } else if (new_block.x2 == 0 && new_block.y2 == 0){
            new_block.x2=Math.round(xPosition);
            new_block.y2=Math.round(yPosition);
            draw_circle_mark(new_block.x2,new_block.y2);
            console.log("x2");
          } else if (new_block.x3 == 0 && new_block.y3 == 0){
            new_block.x3=Math.round(xPosition);
            new_block.y3=Math.round(yPosition);
            draw_circle_mark(new_block.x3,new_block.y3);
            console.log("x3");
          } else if (new_block.x4 == 0 && new_block.y4 == 0){
            new_block.x4=Math.round(xPosition);
            new_block.y4=Math.round(yPosition);
            draw_circle_mark(new_block.x4,new_block.y4);
            console.log("x4");

            console.log("new_block:");
            console.log(new_block);

            new_blocks=new_blocks.concat([{
              "x1":new_block.x1,"y1":new_block.y1,
              "x2":new_block.x2,"y2":new_block.y2,
              "x3":new_block.x3,"y3":new_block.y3,
              "x4":new_block.x4,"y4":new_block.y4
            }]);

            console.log("blocks_new:");
            console.log(new_blocks);

            new_block.x1=0;
            new_block.y1=0;
            new_block.x2=0;
            new_block.y2=0;
            new_block.x3=0;
            new_block.y3=0;
            new_block.x4=0;
            new_block.y4=0;
            console.log("World");

            document.getElementById("submit").classList.remove('btn-primary');
            document.getElementById("submit").classList.add('btn-danger');



            hide_blocks();
            draw_blocks();
            addingblock=false;
            refresh_form_value();
          }
        }
      }
    );
  

  function addblock(){
    addingblock=true;
   }

  window.onload=draw_blocks();
</script>
<br>
<a href="index.php?action=ocr" class="btn btn-primary btn-icon-split">
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
