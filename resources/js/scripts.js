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

//Drag and Drop File Upload. modified from Site: https://artisansweb.net/drag-drop-file-upload-using-javascript-php/
var fileobj;
function upload_file(e) {
    e.preventDefault();
    var dt = e.dataTransfer;
    fileobj = dt;
    document.getElementById('drop_file_zone').style.display = 'none';
    document.getElementById('PleaseWait').style.display = 'block';
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
        var files = file_obj.files.length;
        for (var x = 0; x < files; x++) {
            form_data.append("files[]", file_obj.files[x]);
        }                 
        $.ajax({
            type: 'POST',
            url: 'ajax_multi_upload.php?debug=1',
            //url: 'ajax_upload.php',
            contentType: false,
            processData: false,
            data: form_data,
            success:function(response) {
                document.getElementById('drop_file_zone').style.display = 'block';
                document.getElementById('PleaseWait').style.display = 'none';
                //alert(response);
                document.getElementById('debugOutput').innerHTML = response;
                $('#selectfile').val('');
            }
        });
    }
}
function setOneNumberDecimal(numberInput) {
    numberInput.value = parseFloat(numberInput.value).toFixed(1);
}
function setTwoNumberDecimal(numberInput) {
    numberInput.value = parseFloat(numberInput.value).toFixed(2);
}

function addtag(e) {
        if (e.keyCode == 13) {
            var randomnumber = Math.random();
            var tagname = document.getElementById('TAG1');
            var tagdiv = document.getElementById('tagdiv');
            tagdiv.innerHTML += '<div id="'+tagname.value+randomnumber+'" class="SelectionDivItem">'+tagname.value.toUpperCase()+'<input type="hidden" name="TAGS[]" value="'+tagname.value.toUpperCase()+'" /><div style="float:right;"><img style="cursor:pointer;" onclick="removeTag(this.parentNode.parentNode.id)" src="resources/images/UI/cross.png" /></div></div>';
            tagdiv.scrollTop = tagdiv.scrollHeight;
            tagname.value = '';
            return false;
        } else {
            return true;
        }
}

function removeTag(tagdiv) {
    var elem = document.getElementById(tagdiv);
    elem.parentNode.removeChild(elem);
}

