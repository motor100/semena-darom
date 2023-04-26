tinymce.init({ 
  selector: 'textarea',
  height: 500,
  default_link_target: '_blank',
  images_upload_handler: function (blobInfo, success, failure) {
    let xhr, formData;
    xhr = new XMLHttpRequest();
    xhr.withCredentials = false;
    xhr.open('POST', '/dashboard/tinyfileupload');
    let token = document.querySelector("meta[name='csrf-token']").content;
    xhr.setRequestHeader("X-CSRF-Token", token);
    xhr.onload = function() {
      let json;
      if (xhr.status != 200) {
        failure('HTTP Error: ' + xhr.status);
        return;
      }
      json = JSON.parse(xhr.responseText);

      if (!json || typeof json.location != 'string') {
        failure('Invalid JSON: ' + xhr.responseText);
        return;
      }
      success(json.location);
    };
    formData = new FormData();
    formData.append('file', blobInfo.blob(), blobInfo.filename());
    xhr.send(formData);
  },
  file_picker_callback: function (cb, value, meta) {
    var input = document.createElement('input');
    input.setAttribute('type', 'file');
    input.setAttribute('accept', 'application/pdf, application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

    input.onchange = function () {
      var file = this.files[0];
      var reader = new FileReader();

      // FormData
      var fd = new FormData();
      var files = file;
      fd.append('filetype', meta.filetype);
      fd.append("file", files);

      var filename = "";

      // AJAX
      var xhr, formData;
      xhr = new XMLHttpRequest();
      xhr.withCredentials = false;
      xhr.open('POST', '/dashboard/tinyfileupload');
      let token = document.querySelector("meta[name='csrf-token']").content;
      xhr.setRequestHeader("X-CSRF-Token", token);
      xhr.onload = function() {
        var json;
        if (xhr.status != 200) {
          failure('HTTP Error: ' + xhr.status);
          return;
        }
        json = JSON.parse(xhr.responseText);
        if (!json || typeof json.location != 'string') {
          failure('Invalid JSON: ' + xhr.responseText);
          return;
        }
        filename = json.location;
        reader.onload = function(e) {
          cb(filename, { text: file.name });
        };
        reader.readAsDataURL(file);
      };
      xhr.send(fd);

      return;
    };

    input.click();
  },
  plugins: [
    'autolink lists link image',
    'table paste'
  ],
  toolbar: 'undo redo | formatselect | ' +
  'bold italic | image link | forecolor | alignleft aligncenter ' +
  'alignjustify | bullist numlist outdent indent | ' +
  'removeformat',
});