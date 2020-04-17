function get_blocks(){
  var value=[];
  var xhr = new XMLHttpRequest();
  xhr.open("POST", 'api.php', false);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send('action=get_blocks');
  
  xhr.onreadystatechange = function() {//Call a function when the state changes.
          if(xhr.readyState == 4) {
            if (xhr.status == 200){
              console.log("api get_blocks:"+xhr.responseText);
            } else {
              alert(xhr.status+": "+xhr.statusText);
            }
          }
  }
        return JSON.parse(xhr.responseText);
}

function delete_block(id) {
  var xhr = new XMLHttpRequest();
  xhr.open("POST", 'api.php', false);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send('action=delete_block&id=' + id );
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4) {
      if (xhr.status == 200) {
        console.log("delete ok");
        reload_blocks();
      }
      else {
        alert(xhr.status + ": " + xhr.statusText);
      }
    }
  };
}

function isIntersect_block(xPosition, yPosition,blockid){
  var vertices_x=[ new_blocks[blockid].x1,new_blocks[blockid].x2,new_blocks[blockid].x3,new_blocks[blockid].x4];
  var vertices_y=[ new_blocks[blockid].y1,new_blocks[blockid].y2,new_blocks[blockid].y3,new_blocks[blockid].y4];
  var i = 0;
  var j = 4;
  var c = false;
  var point = 0;
  for (i = 0 ; i < 4; j = i++) {
    point = i;
    if( point == 4 )
      point = 0;
    if ( ((vertices_y[point]  >  yPosition != (vertices_y[j] > yPosition)) &&
    (xPosition < (vertices_x[j] - vertices_x[point]) * (yPosition - vertices_y[point]) / (vertices_y[j] - vertices_y[point]) + vertices_x[point]) ) )
      c = ! c;
  }
  return c;
}

function isIntersect(x,y, circle) {
  return Math.sqrt((x-circle.x) ** 2 + (y - circle.y) ** 2) < circle.radius;
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
    new_circles[i]={'x':value.x2 , 'y':value.y2, 'radius':8};
    draw_remove_button(new_circles[i].x,new_circles[i].y,new_circles[i].radius);
    i++;
  });
}

function draw_remove_button (x,y,radius){
  var canevas = document.getElementById('canvas-textblocks');
  if (canevas.getContext) {
    var ctx = canevas.getContext('2d');
    ctx.beginPath();
    ctx.moveTo(x+radius,y);
    ctx.arc(x, y, radius, 0, 2 * Math.PI, false);

    ctx.moveTo(x-3, y-3);
    ctx.lineTo(x+3, y+3);
    
    ctx.moveTo(x+3, y-3);
    ctx.lineTo(x-3, y+3);
    

    ctx.globalAlpha = 1;
    ctx.strokeStyle = "red";
    ctx.fillStyle = "white";
    ctx.fill();
    ctx.stroke();
    console.log("draw remove_button", x, y);
  }
}

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

function mergeblock() {
  var xhr = new XMLHttpRequest();
  xhr.open("POST", 'api.php', false);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send('action=merge_blocks&id1=' + block1_id + '&id2=' + block2_id);
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4) {
      if (xhr.status == 200) {
        console.log("merge ok");
        reload_blocks();
      }
      else {
        alert(xhr.status + ": " + xhr.statusText);
      }
    }
  };
}


function add_block_event(xPosition,yPosition){
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

    add_block(new_block);

    new_block.x1=0;
    new_block.y1=0;
    new_block.x2=0;
    new_block.y2=0;
    new_block.x3=0;
    new_block.y3=0;
    new_block.x4=0;
    new_block.y4=0;

    addingblock=false;
  }
}

function add_block(new_blocks){
  var str = JSON.stringify(new_blocks);
  str = encodeURIComponent(str);
  var xhr = new XMLHttpRequest();
  xhr.open("POST", 'api.php', true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send('action=add_block&value=' + str);
  
  xhr.onreadystatechange = function() {//Call a function when the state changes.
          if(xhr.readyState == 4) {
            if (xhr.status == 200){
              reload_blocks();
            } else {
              alert(xhr.status+": "+xhr.statusText);
            }
          }
        }
}

function merge_block_event(xPosition,yPosition){
  var i=0;
  var j=0;
  console.log('block1_id:'+block1_id+", new_blocks:"+new_blocks);

  if (block1_id == -1 && blockfound == false){
    console.log("search for block1");
    for (i = 0; i < new_blocks.length; i++) {
      if (isIntersect_block(xPosition,yPosition, i)){
        
        console.log("block selected:"+i);
        block1_id=i;
        blockfound=true;
        break;
      }
      else{
        console.log("not in block:"+i);
      }
    }
  }

  if (block2_id == -1 && blockfound == false){
    for (i = 0; i < new_blocks.length; i++) {
      if (isIntersect_block(xPosition,yPosition, i)){
        block2_id=i;
        blockfound=true;
        break;
      }
    }
  }

  if (block1_id != -1 && block2_id != -1){
    mergeblock(block1_id,block2_id);

    block1_id=-1;
    block2_id=-1;
    mergingblock=false;
    reload_blocks();
  }
  
  blockfound=false;
}

function detect_delete_click(xPosition,yPosition){
  var i=0;
  new_circles.forEach(circle => {
    console.log(xPosition+" "+yPosition+" "+circle);
    if (isIntersect(xPosition,yPosition, circle)) {
      delete_block(i);
      reload_blocks();
      console.log("i:"+i);
    }
      i++;
  });
}

function reload_blocks(){
  new_blocks=get_blocks();
  hide_blocks();
  draw_blocks();
}