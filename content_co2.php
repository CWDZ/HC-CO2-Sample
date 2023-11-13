<script src='js/jquery-3.3.1.js'></script>
<html>
<div style="position:absolute;width:42%;height:100%">
	<div class="font_size" style="position:absolute;top:32%;left:30%;width:60%;height:33%;">
		<div id="date" style="font-size:5.2vh;padding-left:3%"></div>
		<div id="time" style="font-size:12vh;padding-top:2%;"></div>
	</div>
	<div class="font_size" id="loc_msg" style="color:#2F5597;font-size:8vh;position:absolute;top:78%;left:31%;width:55%;height:10%;display: flex;justify-content: left;align-items: center;"></div>
</div>
<div style="position:absolute;left:42%;width:58%;height:100%;">
	<div class="font_size" id="loc_name" style="font-size:8vh;position:absolute;top:23%;left:7%;width:34%;height:24%;display: flex;justify-content: center;align-items: center;text-align:center;"></div>
	<div class="font_size" id="loc_temp" style="position:absolute;top:23%;left:46%;width:34%;height:24%;display: flex;justify-content: center;align-items: center;"></div>
	<div class="font_size" id="loc_rh" style="position:absolute;top:64%;left:7%;width:34%;height:24%;display: flex;justify-content: center;align-items: center;"></div>
	<div class="font_size" id="loc_co2" style="position:absolute;top:64%;left:46%;width:34%;height:24%;display: flex;justify-content: center;align-items: center;"></div>
</div>
</html>
<style>
@font-face {
    font-family: "源樣黑體B";
    src: url(GenYoGothic-B.ttc);
}
html {
    overflow: -moz-hidden-unscrollable;
    height: 100%;
}
body{ margin: 0; padding: 0; }
.font_size{

	font-size:10vh;
	line-height:10vh;
	font-family: 源樣黑體B;
	color:#004962;
}
</style>
<script>
if(typeof connect == "undefined"){
	window.addEventListener('online', (e) => connect = true);
	window.addEventListener('offline', (e) => connect = false);
	var connect = true;
}
if(typeof monthNames == "undefined"){
var monthNames = ["Jan.", "Feb.", "Mar.", "Apr.", "May", "Jun.",
  "Jul.", "Aug.", "Sep.", "Oct.", "Nov.", "Dec."
];
}
if(typeof timesec == "undefined"){
	timesec = true;
}
var content_cur_num=0,content_device_max=0,content_json="",co2_color_range='["0","800","800","1500","1500","3000"]';
getSensor(true);

function isTime(){
	var time = new Date();
	getTime(time);
	if(time.getSeconds() %10 == 0){
		if(time.getSeconds() == 50)
			getSensor(false);
	}
	if(connect && timecount % showTime == 0){
		if(timecount % (showTime*2) == 0 || !English){
			if(content_device_max>1 && document.visibilityState == "visible"){
				content_cur_num+1 == content_device_max ? content_cur_num=0 : content_cur_num++;
			}
			else{
				content_cur_num = 0;
			}
		}
		change_device_view();
	}
}
function getTime(time){
	var date = "";
	if(language_count==1)
		date = monthNames[time.getMonth()] + " " + time.getDate().toString() + ", " + (time.getFullYear()).toString();
	else
		date = (time.getFullYear()).toString() + "年 " + ((time.getMonth()+1).toString().length == 2 ? (time.getMonth()+1).toString() : "0" + (time.getMonth()+1).toString()) + "月" + (time.getDate().toString().length == 2 ? time.getDate().toString() : "0" + time.getDate().toString()) + "日";
	var curtime = "";
	if(timesec){
		curtime = (time.getHours().toString().length == 2 ? time.getHours().toString() : "0" + time.getHours().toString()) + "<font style=\"visibility: visible;\">:</font>" + (time.getMinutes().toString().length == 2 ? time.getMinutes().toString() : "0" + time.getMinutes().toString()) + "<font style=\"font-size:4.5vh\">" + (time.getHours()>11 ? "&nbsp;&nbsp;&nbsp;PM" : "&nbsp;&nbsp;&nbsp;AM") + "</font>";
		timesec = false;
	}
	else{
		curtime = (time.getHours().toString().length == 2 ? time.getHours().toString() : "0" + time.getHours().toString()) + "<font style=\"visibility: hidden;\">:</font>" + (time.getMinutes().toString().length == 2 ? time.getMinutes().toString() : "0" + time.getMinutes().toString()) + "<font style=\"font-size:4.5vh\">" + (time.getHours()>11 ? "&nbsp;&nbsp;&nbsp;PM" : "&nbsp;&nbsp;&nbsp;AM") + "</font>";
		timesec = true;
	}
	$("#date").html(date);
	$("#time").html(curtime);
}
function getSensor(first){
	$.ajax({
		type:'GET',
		url:"getsensor.php"+'<?php if(isset($_GET['name'])) echo "?name=".$_GET['name']; ?>',
		dataType: "html",
		data: {},
		error: function(xhr, status) {

		},
		success:function(data){
			if(data){
				content_json = JSON.parse(data);
				content_device_max = content_json.data.length;
				if(first)
				change_device_view();
			}
		}
	});
}
function change_device_view(){
	if(language_count==1)
		$("#loc_name").html(content_json.data[content_cur_num].en_name);
	else
		$("#loc_name").html(content_json.data[content_cur_num].name);
	$("#loc_co2").html(content_json.data[content_cur_num].co2_value);
	$("#loc_rh").html(content_json.data[content_cur_num].rh_value.toFixed(1));
	$("#loc_temp").html(content_json.data[content_cur_num].temp_value.toFixed(1));
	
	var co2_range = JSON.parse(co2_color_range);
	if(content_json.data[content_cur_num].co2_value > parseInt(co2_range[0]) && content_json.data[content_cur_num].co2_value <= parseInt(co2_range[1])){
		if(language_count==1)
			$("#loc_msg").html("Good");
		else
			$("#loc_msg").html("良好");
		$("#loc_co2").css('color','#004962');
		$("#loc_msg").css('color','#2F5597');
	}
	else if(content_json.data[content_cur_num].co2_value > parseInt(co2_range[2]) && content_json.data[content_cur_num].co2_value <= parseInt(co2_range[3])){
		if(language_count==1)
			$("#loc_msg").html("Fair");
		else
			$("#loc_msg").html("普通");
		$("#loc_co2").css('color','#E79D3B');
		$("#loc_msg").css('color','#E79D3B');
	}
	else if(content_json.data[content_cur_num].co2_value > parseInt(co2_range[4])){
		if(language_count==1)
			$("#loc_msg").html("Poor");
		else
			$("#loc_msg").html("偏高");
		$("#loc_co2").css('color','#E37475');
		$("#loc_msg").css('color','#E37475');		
	}
}
</script>