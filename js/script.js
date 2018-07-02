var pathBase = "webservice/control/";

// Validate login 
function checkLogin(){
	if(getCookie("user") == "") {
		alert("Login necessário!");
		window.location.href = "login.html";
	}
}

function checkAdmin(){
	if(getCookie("type") > 1) {
		alert("Você não tem permissão para acessar essa página!");
		window.location.href = "index.html";
	}
}

// Closing login modal by clicking outside
var modal1 = document.getElementById('loginForm');
var modal2 = document.getElementById('signupForm');
window.onclick = function(event) {
    if (event.target == modal1) {
        modal1.style.display = "none";
    } else if (event.target == modal2){
    	modal2.style.display = "none";
    }
}

// Cookies functions
function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function clearCookie(cname) {
	document.cookie = cname + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT;path=/";
	console.log(cname);
}

function deleteAllCookies() {
    var cookies = document.cookie.split(";");

    for (var i = 0; i < cookies.length; i++) {
        var cookie = cookies[i];
        var eqPos = cookie.indexOf("=");
        var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
        document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
    }
}

// get URL parameters
function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

// start a conversation with an user anywere 
function startChat(id, name){
	window.location.href = "chat.html?chat=" + id + "&name=" + name;
}

// shows the message log
function getMessageLog() {
	var jsonObject = {};
	var user = getCookie('user');
	
	jsonObject["method"] = "getMessageLog";
	jsonObject["user"] = user;

	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
	      var resultado = JSON.parse(this.responseText);
	      if(resultado.status == true){
	      	var data = resultado.message;
	      	
	      	var infos = "";
	      	for (var i = 0; i < data.length; i++) {
	      		var idUser = data[i].idUser;
	      		var username = data[i].username;
	      		var pic = data[i].pic;
	      		var message = data[i].message;

	      		infos += "<div class='card friend-card' onclick=startChat(" + idUser +",'" + username + "')>";
				infos += "	<img class='float-right rounded-circle' src='" + pic + "'>";
				infos += "	<div class='message-info'>";
				infos += "		@" + username + "<br />";
				infos += "		" + message;
				infos += "	</div>";
				infos += "</div>";
	      	}

	      	document.getElementById("history").innerHTML = infos;
	      } else {
	      	document.getElementById("history").innerHTML = "<div class='card'> Nenhuma conversa ainda :( </div>";
	      }
	  }
	};

	xhttp.open("POST", pathBase + "GerenciadorMessageApl.php", true);
	xhttp.setRequestHeader('Content-Type', 'application/json; charset=UTF-8');
	xhttp.setRequestHeader('Access-Control-Allow-Headers', '*');
	xhttp.send(JSON.stringify(jsonObject));
}