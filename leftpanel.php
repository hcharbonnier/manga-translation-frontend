<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
  <div class="sidebar-brand-icon rotate-n-15">
    <i class="fas fa-laugh-wink"></i>
  </div>
  <div class="sidebar-brand-text mx-3">MangaTranslation</div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
  Manga Translation
</div>

<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item <?php echo $menu['active']["workflow"]?>">
  <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseUpload" aria-expanded="true" aria-controls="collapseUpload">
    <i class="fas fa-fw fa-cog"></i>
    <span>Workflow</span>
  </a>
  <div id="collapseUpload" class="collapse <?php echo $menu['show']["workflow"]?>" aria-labelledby="headingUpload" data-parent="#accordionSidebar">
    <div class="bg-white py-2 collapse-inner rounded">
      <h6 class="collapse-header">Workflow</h6>
      <a class="collapse-item <?php echo $menu['active']["upload"]?>" href="?action=upload"> 1 - Upload Image</a>
      <a class="collapse-item <?php echo $menu['active']["detect_textboxes"]?>" href="?action=detect_textboxes"> 2 - Detect textboxes</a>
      <a class="collapse-item <?php echo $menu['active']["edit_textboxes"]?>" href="?action=edit_textboxes"> 3 - Edit textboxes</a>
      <a class="collapse-item <?php echo $menu['active']["ocr"]?>" href="?action=ocr"> 4 - OCR</a>
      <a class="collapse-item <?php echo $menu['active']["ocr_validate"]?>" href="?action=ocr_validate"> 5 - OCR Result Validate</a>
      <a class="collapse-item <?php echo $menu['active']["translate"]?>" href="?action=translate"> 6 - Translate</a>
      <a class="collapse-item <?php echo $menu['active']["translate_validate"]?>" href="?action=translate_validate"> 7 - Translation Validate</a>
      <a class="collapse-item <?php echo $menu['active']["clean_raw"]?>" href="?action=clean_raw"> 8 - Clean Raw</a>
      <a class="collapse-item <?php echo $menu['active']["export"]?>" href="?action=export"> 9 - Export Result</a>
    </div>
  </div>
  <div id="collapseUpload" class="collapse" aria-labelledby="heading" data-parent="#accordionSidebar">
    <div class="bg-white py-2 collapse-inner rounded">
      <h6 class="collapse-header">1 Upload Image</h6>
      <a class="collapse-item" href="buttons.html">Upload Image</a>
    </div>
  </div>
</li>

<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
  <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

</ul>
<!-- End of Sidebar -->
