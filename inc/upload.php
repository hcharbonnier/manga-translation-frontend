
<div class="container-fluid">
  <div class="col-lg-12">
      <div class="row" id="upload_form">
            <input type="hidden" name="MAX_FILE_SIZE" value="3000000" />
            <input type="file" name="filename" id="filename">
            <input class="text" type="button" id=submit  name="submit" value="upload" onclick="submit();">
      </div>

      <script>
        function submit(){
          var formData = new FormData();
          var file = document.getElementById('filename');
          console.log(file);
          formData.append("MAX_FILE_SIZE", "30000000");
          formData.append("action", "upload");
          formData.append("filename", file.files[0]);

          var xhr = new XMLHttpRequest();
          xhr.open("POST", 'api.php', true);
          xhr.send(formData);

          xhr.onreadystatechange = function() {//Call a function when the state changes.
            if(xhr.readyState == 4) {
              if (xhr.status == 200){
                window.location.href = "index.php?action=textboxes";
              } else {
                alert(xhr.status+": "+xhr.statusText);
              }
            }
          }
        }
      </script>
  </div>
</div>
