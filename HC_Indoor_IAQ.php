<html>
<head>
<script src='js/jquery-3.3.1.js'></script>
</head>
<body>
<style>
body{ margin: 0; padding: 0; background-color:black;}
#zone1 {
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    z-index: 10;
}
#zone2 {
    position: absolute;
    width: 24%;
    height: 20%;
    top: 12%;
    left: 12%;
    z-index: 10;
}

html {
    overflow: -moz-hidden-unscrollable;
    height: 100%;
}

body::-webkit-scrollbar {
    display: none;
}

body {
    -ms-overflow-style: none;
    height: 100%;
	overflow: auto;
}
* {cursor: none;}
</style>
<div id="main" style="width:1920px;height:1080px;overflow: hidden;">
	<div id="zone1" style="display:block;"></div>
	<div id="zone2" style="display:block;"></div>
	<div id="mainTW" style="width:1920px;height:1080px;display:block;overflow: hidden;background-image: url('Indoor_TW.png');background-size:100%;background-repeat:no-repeat;background-position: center center;"></div>
	<div id="mainEN" style="width:1920px;height:1080px;display:none;overflow: hidden;background-image: url('Indoor_EN.png');background-size:100%;background-repeat:no-repeat;background-position: center center;"></div>
</div>
</body>
</html>

<script>
var showTime = 5;
var English = true;

var language_count=0;
function disableMove() {
    event.preventDefault();
}
document.addEventListener('touchmove', disableMove, {passive: false});
$(document).ready(function(){
	getALL();
});
setInterval(changeLng, 1000);
var timecount = 0;
function changeLng(){
	var time = new Date();
	timecount++;
	if(timecount % showTime == 0){
		if(language_count==0 && English){
			$("#mainTW").css('display',"none");
			$("#mainEN").css('display',"inline-block");
			language_count++;
		}
		else{
			if(content_cur_num+1 == content_device_max){
				$("#mainTW").css('display',"inline-block");
				$("#mainEN").css('display',"none");
			}
			else{
				$("#mainTW").css('display',"inline-block");
				$("#mainEN").css('display',"none");
			}
			language_count=0;
			timecount=0;
		}
	}
	if(typeof isTime === 'function'){
		isTime();
	}
}
function getALL(){
	$.ajax({
		type:'GET',
		url:"content_co2.php"+'<?php if(isset($_GET['name'])) echo "?name=".$_GET['name']; ?>',
		dataType: "html",
		data: {},
		error: function(xhr, status) {
			alert(xhr);
			alert(status);
		},
		success:function(data){
			if(data){
				$("#zone1").html(data);
			}
		}
	});
	$.ajax({
		type:'GET',
		url:"Logo.php",
		dataType: "html",
		data: {},
		error: function(xhr, status) {
			alert(xhr);
			alert(status);
		},
		success:function(data){
			if(data){
				$("#zone2").html(data);
			}
		}
	});
}
</script>