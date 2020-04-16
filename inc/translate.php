<div class="container-fluid">
  <div class="col-lg-12">
<pre>
<?php
if ( isset($_SESSION['image'])){
//    $_SESSION['image']->merge_near_block();
    $_SESSION['image']->ocr(false);
    $_SESSION['image']->translate();

  $blocks=$_SESSION['image']->get_blocks();
  for($i=0; isset($blocks[$i]);$i++){
    $ocr[$i]=$_SESSION['image']->get_block_ocr($i);
    $trans[$i]=$_SESSION['image']->get_block_translation($i);
    $angle[$i]=$_SESSION['image']->get_text_angle($i);
  }

?>
<script>

var blocks = <?php echo json_encode($blocks); ?>;

var trans = [];
var ocr = [];
var angle = [];
<?php
  for($i=0; isset($blocks[$i]);$i++){
    echo "trans[$i]=\"".$trans[$i]."\";".PHP_EOL;
    echo "ocr[$i]=\"".str_replace("\n",' ',$ocr[$i])."\";".PHP_EOL;
    echo "angle[$i]=\"".$angle[$i]."\";".PHP_EOL;
  }
  
?>;

function draw_block(x1,y1,x2,y2,x3,y3,x4,y4) {
    var canevas = document.getElementById('canvas-textblocks');
    if (canevas.getContext) {
      var ctx = canevas.getContext('2d');
      ctx.fillStyle = "pink";
      ctx.beginPath();
      ctx.moveTo(x1, y1);
      ctx.lineTo(x2, y2);
      ctx.lineTo(x3, y3);
      ctx.lineTo(x4, y4);
      ctx.closePath();
      ctx.globalAlpha = 0.5;
      ctx.fill();
    }
  }
  function hide_blocks () {
    var canevas = document.getElementById('canvas-textblocks');
    if (canevas.getContext) {
      var ctx = canevas.getContext('2d');
      ctx.clearRect(0,0,canevas.width,canevas.height);
    }
  }


            function resize_textarea(id) {
              var str = document.getElementById(id).value;
              var cols = document.getElementById(id).cols;

              var linecount = 0;
              var lines=str.split("\n")
              lines.forEach( function(l) {
                  linecount += Math.ceil( l.length / cols ); // Take into account long lines
              });
              document.getElementById(id).rows = linecount;
            }


  function focus_block(id){
    var block= blocks[id];
    hide_blocks();
//    insert_txt();
    draw_block(block.x1,block.y1,block.x2,block.y2,block.x3,block.y3,block.x4,block.y4);
  }

  function save_translation(id){
    
    var str = document.getElementById("trad_"+id).value;
    str = encodeURIComponent(str);

    var xhr = new XMLHttpRequest();
    xhr.open("POST", 'api.php', true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send('id=' + id + '&action=set_translation&value=' + str);
  }

</script>
<style>
  label,
textarea {
    font-size: .8rem;
    letter-spacing: 1px;
}
textarea {
    padding: 10px;
    line-height: 1.5;
    border-radius: 5px;
    border: 1px solid #ccc;
    box-shadow: 1px 1px 1px #999;
}
textarea:focus {
  background: pink;
}

label {
    display: block;
    margin-bottom: 10px;
}

canvas{
    background-position: center;
    background-size: 100% 100%;
    background-image: url("<?php echo $_SESSION['image']->get_image_path() ?>");
}

</style>
<div class="row">
  <?php
            $img_width=$_SESSION['image']->get_width();
            $img_height=$_SESSION['image']->get_height();
  ?>
<table valign=top>
  <tr>
    <td><canvas id="canvas-textblocks" width="<?php echo $img_width ?>" height="<?php echo $img_height?>">
</canvas>
</td>
    <td>
    <table border="0">
    <tr>
      <td>
      <?php
        $i=0;
        foreach ($blocks as $block){
         // echo "Angle: <input type=text name='angle_$i' value='".$angle[$i]."'><br>";
          echo "<div width=350px style='word-wrap: break-word; white-space:pre-wrap;'>".$ocr[$i].'<div>';
          echo "<textarea name='trad_$i' id=\"trad_$i\" cols='40' rows='5' oninput=\"resize_textarea('trad_$i')\" onload=\"resize_textarea('trad_$i')\" onfocus=\"focus_block($i)\">".$trans[$i]."</textarea><br>";
          echo "<div align=center><a href='#' onclick=\"save_translation($i)\">save</a></div>";
          echo "<hr><hr>";
          $i++;
        }
      ?>
      </td>
    </tr>
</table>
    </td>
  </tr>
</table>
</div>
<script>
  <?php
    for($i=0; isset($blocks[$i]);$i++){
    
   echo "resize_textarea('trad_$i');".PHP_EOL;
  }
  ?>
  </script>


<?php } else {
  echo "Upload image first!!";
} ?>
</pre>
  </div>
</div>
