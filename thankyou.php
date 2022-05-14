<div id="page">
  <a href="" id="a">Click me</a><br>
  Hello<br>
  Hello<br>

  <div id="popup"> 
  External website:
 
  </div>

</div>

#popup { 
  display: none; 
  width: 400px; height: 200px;
  border: 1px black solid;
  top:200px; left:20px;
  background-color: white;
  z-index: 10;
  padding: 2em;
  position: absolute;
}

.darken { background: rgba(0, 0, 0, 0.0); }

#iframe { border: 0;}

html, body, #page { height: 100%; }

document.getElementById("a").onclick = function(e) {
  e.preventDefault();
  var isInit = true; // indicates if the popup already been initialized.
  var isClosed = false; // indicates the state of the popup
  document.getElementById("popup").style.display = "block";
  document.getElementById('iframe').src = "http://example.com";
  document.getElementById('page').className = "darken";
  document.getElementById('page').onclick = function() {
    if(isInit){isInit=false;return;}
    if(isClosed){return;} //if the popup is closed, do nothing.
    document.getElementById("popup").style.display = "none";
    document.getElementById('page').className = "";
    isClosed=true;
  }
  return false;
}

specify which file it will open in the js portion of this code, then attribute the photos in newUserprofile page with the project name like ive done with the href,
