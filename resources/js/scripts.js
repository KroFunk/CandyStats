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
        //fileobj = document.getElementById('selectfile').files[0];
		fileobj = document.getElementById('selectfile');
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

function openStats(name,steamID){
    //fetch the stuff via ajax
    var xmlhttp;
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
    if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
        document.getElementById("playerStats").innerHTML=xmlhttp.responseText;
        console.log("Player Stats Updated for "+steamID);

        // LOAD THE DATATABLE
        $(document).ready( function () {
            playerleaderboard = $('#globalLeaderboardTEST').DataTable( {
              'columnDefs': [
                {
                    "targets": 0,
                    "className": "text-left"
                },
                {
                    "targets": 1,
                    "width":"15%",
                    "className": "text-right"
                },
                {
                    "targets": 2,
                    "width":"15%",
                    "className": "text-right"
                },
                {
                    "targets": 3, 
                    "width":"15%",
                    "className": "text-right"
                }
              ],
              "order": [[ 3, "desc" ]],
              "lengthChange": false,
              "ajax": 'API/GET/victims/datatables.php?hide=bots&ID='+steamID
            });
          } );
          // END OF DATATABLE
    

        }
        console.log("ajax status: "+xmlhttp.status);
    }
    
    xmlhttp.open("POST","playerstats.php",true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send("SteamID="+steamID);

    //make the box visible.
    document.getElementById(`playerStats`).className=`playerStats visible`;
}

function expandSessionDate(sessionDate) {
    sessionDateDiv      = document.getElementById('sessionDate'+sessionDate);
    sessionDateButton   = document.getElementById('sessionDateButton'+sessionDate);

    if(sessionDateDiv.style.maxHeight == '9999px'){
        sessionDateDiv.style.maxHeight = '30px';
        sessionDateButton.src = 'resources/images/UI/plus-small.png';
    } else {
        sessionDateDiv.style.maxHeight = '9999px';
        sessionDateButton.src = 'resources/images/UI/minus-small.png';
    }
}

function selectSession(selectedSessionID) {

    //flip clicked div between selected and selectable (unselected)
    selectedDiv = document.getElementById(selectedSessionID);
    if(selectedDiv.className == 'Selected SelectedSession'){
        selectedDiv.className = 'SelectionDivItem';
    } else {
        selectedDiv.className = 'Selected SelectedSession';
    }

    //Grab all sessions in one array - duplicate operation
    //var selectedSessions = document.getElementsByClassName('SelectedSession');
    
    //cosmetic, may remove. 
    //if (selectedSessions.length > 0){
    //    document.getElementById('mapSelectionArrow').className = 'pulse';
    //} else {
    //    document.getElementById('mapSelectionArrow').className = '';
    //}

    mapSelection();   

}

function selectSessionMap(selectedSessionID) {
    selectedDiv = document.getElementById(selectedSessionID);
    if(selectedDiv.className == 'SelectedMap'){
        selectedDiv.className = 'SelectionDivItem';
    } else {
        selectedDiv.className = 'SelectedSession';
    }
    var selectedSessions = document.getElementsByClassName('SelectedMap');
    if (selectedSessions.length > 0){
        document.getElementById('roundSelectionArrow').className = 'pulse';
    } else {
        document.getElementById('roundSelectionArrow').className = '';
    }
    roundSelection();
}

function mapSelection() {
    //cosmetic, may remove. 
    document.getElementById('mapSelectionArrow').className = '';
    
    //Grab all sessions in one array 
    var selectedSessions = document.getElementsByClassName('SelectedSession');

    //debug log
    var logArray = [];
    console.log(''); //new blank line
    console.log('%c[CandyStats] %cMap Selection Process started...','color:#8e7bd5','color:#000000;font-weight:800;');

    //List the selected logs in the console and build the array of sessionIDs
    var i = 0;
    for(i = 0;i < selectedSessions.length;i++) {
        console.log('%cSelected Log: %c'+selectedSessions[i].id+' ','color:#7accd3;','color:#7ad380')
        logArray.push(selectedSessions[i].id);
    }

    //wording for catching plural/singular maps
    var words = ' logs have ';
    if(i == 1){
        words = ' log has ';
    } 

    //Output log to console.
    console.log('%c[CandyStats] %c'+i+words+'been selected.','color:#8e7bd5','color:#000000;font-weight:800;');

    //Ajax request to get the output for the Map selection
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        console.log('%c[CandyStats] %cAJAX request completed.','color:#8e7bd5','color:#000000;font-weight:800;');
        document.getElementById("mapsDiv").innerHTML = this.responseText;
      }
    };
    xhttp.open("POST", "mapSelection.php", true);
    xhttp.setRequestHeader("Content-Type", "application/json");
    xhttp.send(JSON.stringify(logArray));

    console.log('%c[CandyStats] %cMap Selection Process finished.','color:#8e7bd5','color:#000000;font-weight:800;');
}

function roundSelection() {
    document.getElementById('roundSelectionArrow').className = '';
    var logArray = [];
    console.log('');
    console.log('%c[CandyStats] %cRound Selection Process started...','color:#8e7bd5','color:#000000;font-weight:800;');
    var selectedSessions = document.getElementsByClassName('SelectedSession');
    var i = 0;
    for(i = 0;i < selectedSessions.length;i++) {
        console.log('%cSelected Log: %c'+selectedSessions[i].id+' ','color:#7accd3;','color:#7ad380')
        logArray.push(selectedSessions[i].id);
    }
    var words = ' logs have ';
    if(i == 1){
        words = ' log has ';
    } 
    console.log('%c[CandyStats] %c'+i+words+'been selected.','color:#8e7bd5','color:#000000;font-weight:800;');

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        console.log('%c[CandyStats] %cAJAX request completed.','color:#8e7bd5','color:#000000;font-weight:800;');
        document.getElementById("roundsDiv").innerHTML = this.responseText;
      }
    };
    xhttp.open("POST", "mapSelection.php", true);
    xhttp.setRequestHeader("Content-Type", "application/json");
    xhttp.send(JSON.stringify(logArray));

    console.log('%c[CandyStats] %cMap Selection Process finished.','color:#8e7bd5','color:#000000;font-weight:800;');
}