<div class="container-fluid">
  <div class="col-lg-12">
    <div class="col-lg-12">
      <?php

        if (! isset($_SESSION['image'])){

          $_SESSION['image']=new hcharbonnier\mangatranslation\MangaImage('uploads/'.$_SESSION['filename']);
          $_SESSION['image']->detect_block();
          ?>
          <div class="card mb-4 py-3 border-left-success ">
              <div class="card-body">
              Textboxes have been detected.
              </div>
          </div>
          <a href="index.php?action=edit_textboxes" class="btn btn-primary btn-icon-split">
                  <span class="icon text-white-50">
                    <i class="fas fa-flag"></i>
                  </span>
                  <span class="text">Next Step</span>
                </a>  
          <?php

        } else { ?>
          <div class="card mb-4 py-3 border-left-warning ">
              <div class="card-body">
              Textboxes have already been detected.
              </div>
          </div>
       <?php }
      ?>
    </div>
  </div>
</div>
