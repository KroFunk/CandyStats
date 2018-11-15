//UI Class changes
window.onscroll = function() {
  growShrinkMenu()
};

function growShrinkMenu() {
  var menu = document.getElementById("menuBar")
  if (document.body.scrollTop > 5 || document.documentElement.scrollTop > 5) {
    menu.className = 'smallMenuBar';
  } else {
    menu.className = 'menuBar';
  }
}

//Drag and Drop File Upload. Site: https://artisansweb.net/drag-drop-file-upload-using-javascript-php/
var fileobj;
function upload_file(e) {
    e.preventDefault();
    fileobj = e.dataTransfer.files[0];
    ajax_file_upload(fileobj);
}

function file_explorer() {
    document.getElementById('selectfile').click();
    document.getElementById('selectfile').onchange = function() {
        fileobj = document.getElementById('selectfile').files[0];
        ajax_file_upload(fileobj);
    };
}

function ajax_file_upload(file_obj) {
    if(file_obj != undefined) {
        var form_data = new FormData();                  
        form_data.append('file', file_obj);
        $.ajax({
            type: 'POST',
            url: 'ajax_upload.php',
            contentType: false,
            processData: false,
            data: form_data,
            success:function(response) {
                alert(response);
                $('#selectfile').val('');
            }
        });
    }
}