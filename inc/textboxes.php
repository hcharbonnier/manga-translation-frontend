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
          $blocks=$_SESSION['image']->get_blocks();

          $img_width=$_SESSION['image']->get_width();
          $img_height=$_SESSION['image']->get_height();
          ?>

<style type="text/css">

canvas{
    background-position: center;
    background-size: 100% 100%;
    background-image: url("<?php echo "uploads/".$_SESSION["filename"] ?>");
}
</style>
      <div>
        <a href="#" class="btn btn-primary btn-icon-split btn-sm" class="text" onclick=hide_blocks()>Hide Blocks</a> &nbsp;
        <a href="#" class="btn btn-primary btn-icon-split btn-sm" class="text" onclick=draw_blocks()>Show blocks</a> &nbsp;
        <a href="#" class="btn btn-primary btn-icon-split btn-sm" class="text" onclick=addblock()>Add block</a> &nbsp;
        <a href="#" class="btn btn-primary btn-icon-split btn-sm" class="text" id="save" onclick=save()>Save</a> &nbsp;

</div>  
<canvas id="canvas-textblocks" width="<?php echo $img_width ?>" height="<?php echo $img_height?>">
</canvas>

<script>
  var new_blocks = <?php echo json_encode($blocks); ?>;
  var ori_blocks = <?php echo json_encode($blocks); ?>;

  var new_block={"x1":0,"y1":0,"x2":0,"y2":0,"x3":0,"y3":0,"x4":0,"y4":0};
  var addingblock=false;
  var ori_circles = [];
  var new_circles = [];

  function draw_block(x1,y1,x2,y2,x3,y3,x4,y4) {
    var canevas = document.getElementById('canvas-textblocks');
    if (canevas.getContext) {
      var ctx = canevas.getContext('2d');

      ctx.globalAlpha = 0.2;
      ctx.beginPath();
      ctx.moveTo(x1, y1);
      ctx.lineTo(x2, y2);
      ctx.lineTo(x3, y3);
      ctx.lineTo(x4, y4);
      ctx.lineTo(x1, y1);
      ctx.closePath();
      ctx.fillStyle = "blue";
      ctx.fill();
    }
  }

  function save(){
    var str = JSON.stringify(new_blocks);
    str = encodeURIComponent(str);
    var xhr = new XMLHttpRequest();
    xhr.open("POST", 'api.php', true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send('action=set_blocks&value=' + str);

    document.getElementById("save").classList.remove('btn-danger');
    document.getElementById("save").classList.add('btn-primary');
    
    xhr.onreadystatechange = function() {//Call a function when the state changes.
            if(xhr.readyState == 4) {
              if (xhr.status == 200){
                window.location.href = "index.php?action=translate";
              } else {
                alert(xhr.status+": "+xhr.statusText);
              }
            }
          }
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
    var i;
    i=0;
    new_blocks.forEach(value => {
      draw_block(value.x1,value.y1,value.x2,value.y2,value.x3,value.y3,value.x4,value.y4);
      new_circles[i]={'x':value.x2 , 'y':value.y2, 'radius':5};
      draw_remove_button(new_circles[i].x,new_circles[i].y,new_circles[i].radius);
      i++;
    });
  }

  function draw_remove_button (x,y,radius){
    var canevas = document.getElementById('canvas-textblocks');
    if (canevas.getContext) {
      var ctx = canevas.getContext('2d');
      ctx.globalAlpha = 1;

      ctx.moveTo(x,y);
      ctx.arc(x, y, radius, 0, 2 * Math.PI, false);
      ctx.moveTo(x-2, y-2);
      ctx.lineTo(x+2, y+2);
      
      ctx.moveTo(x+2, y-2);
      ctx.lineTo(x-2, y+2);
      ctx.fillStyle = "black";
      ctx.stroke();

      console.log("draw remove_button", x, y);
    }

  }

  function isIntersect(x,y, circle) {
          return Math.sqrt((x-circle.x) ** 2 + (y - circle.y) ** 2) < circle.radius;
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

            document.getElementById("save").classList.remove('btn-primary');
            document.getElementById("save").classList.add('btn-danger');



            hide_blocks();
            draw_blocks();
            addingblock=false;
          }
        }

          var i=0;
          console.log (JSON.stringify(ori_circles));  
          ori_circles.forEach(circle => {
            console.log(xPosition+" "+yPosition+" "+circle);
            if (isIntersect(xPosition,yPosition, circle)) {
              delete_block('ori',i);
              document.getElementById("save").classList.remove('btn-primary');
              document.getElementById("save").classList.add('btn-danger');
              console.log("i:"+i);
            }
              i++;
          });
          new_circles.forEach(circle => {
            
            console.log(xPosition+" "+yPosition+" "+circle);
            if (isIntersect(xPosition,yPosition, circle)) {
              delete_block('new',i);
              document.getElementById("save").classList.remove('btn-primary');
              document.getElementById("save").classList.add('btn-danger');
              console.log("i:"+i);
            }
              i++;
          });

      }
    );
  

  function addblock(){
    addingblock=true;
   }

  function delete_block (tab, i){
    console.log(tab,i);
    hide_blocks();
    if (tab =="new"){
      new_blocks.splice(i,1);
    }

    draw_blocks();
  };

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
