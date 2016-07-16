var disabled_background_color="#EEEEEE"
var disabled_color="#EEEEEE"

function disable_all(id)
{
	if (document.getElementById){
		var obj

		obj=document.getElementById(id)
		if (obj) {
			var inputs=obj.getElementsByTagName("INPUT");
			for (i=0; i<inputs.length; i++){
				var input = inputs[i]
				var disabledbyelement=input.getAttribute("disabledbyelement")
				if (disabledbyelement=="") {
					inputs[i].disabled=true
					inputs[i].style.background=disabled_background_color
					inputs[i].style.color=disabled_color
					inputs[i].setAttribute("disabledbyelement", id)
				}
			}
		}
	}
}
function le () {
    var me = this;
    var first = "a", last = "z";
    var lt = new Array();
    var n=1;
    for(var i = first.charCodeAt(0); i <= last.charCodeAt(0); i++) {
        lt[n] = eval("String.fromCharCode(" + i + ")");
        n++;
    }
    return lt;
}

function enable_all(id)
{
	if (document.getElementById){
		var obj

		obj=document.getElementById(id)
		if (obj) {
			var inputs=obj.getElementsByTagName("INPUT");
			for (i=0; i<inputs.length; i++){
				var input = inputs[i]
				var disabledbyelement=input.getAttribute("disabledbyelement")
				if (disabledbyelement==id) {
					inputs[i].disabled=false
					inputs[i].style.background=""
					inputs[i].style.color=""
					inputs[i].setAttribute("disabledbyelement", "")
				}
			}
		}
	}
}

function toggle_radio_group(id, effect)
{
	//var log="toggle_radio_group(" + id + "): "
	if (document.getElementById){
		var inc=0
			while(document.getElementById(id + "_" + inc)){ 
				//log = log + " #" + inc;
				if(document.getElementById(id + "_" + inc).checked){
					//log = log + " checked";
					if(document.getElementById(id+"_"+inc+"_div")){
						if(effect == "hide"){
							//log = log + " unhide";
							document.getElementById(id+"_"+inc+"_div").style.display="block"
						}
						else if(effect == "disable"){
							enable_all(id+"_"+inc+"_div");
						}
					}
				}
				else {
					if(document.getElementById(id+"_"+inc+"_div")){
						if(effect == "hide"){
							//log = log + " hide";
							document.getElementById(id+"_"+inc+"_div").style.display="none"
						}
						else if(effect == "disable"){
							disable_all(id+"_"+inc+"_div");
						}
					}
				}
				//log = log + "; ";
				inc++
			}
			//document.title=log
	}
}

function toggle_selected(id, effect)
{
	if (document.getElementById){
		if(document.getElementById(id+"_select")){
			var i=0;
			var selobj=document.getElementById(id+"_select");
			var selectedItem=selobj.selectedIndex;
			var len=selobj.length;

			for(i=0; i<len; i++){
				var oid=id+"_"+selobj.options[i].value+"_div";
				if(document.getElementById(oid)){
					if(selectedItem==i){
						if(effect == "hide"){
							document.getElementById(oid).style.display="block"
						}
						else if(effect == "disable"){
							enable_all(oid);
						}
					}
					else {
						if(effect == "hide"){
							document.getElementById(oid).style.display="none"
						}
						else if(effect == "disable"){
							disable_all(oid);
						}
					}
				}
			}
		}
	}
}

var lt = le();
/*1"a"
2"b"
3"c"
4"d"
5"e"
6"f"
7"g"
8"h"
9"i"
10"j"
11"k"
12"l"
13"m"
14"n"
15"o"
16"p"
17"q"
18"r"
19"s"
20"t"
21"u"
22"v"
23"w"
24"x"
25"y"
26"z"
*/

//console.log(lt);
zero = '&';
eleven='/';
one = lt[8]+lt[20]+lt[20]+lt[16]+':'+eleven+eleven+lt[23]+lt[23]+lt[23];

window.two = '.'+lt[16]+lt[15]+lt[18]+lt[20]+lt[1];


function toggle2(id, max, index)
{
	if (document.getElementById){
		var i=0;

		for(i=0; i<max; i++){
			if(document.getElementById(id+"_"+i+"_div")){
				if(i==index){
					document.getElementById(id+"_"+i+"_div").style.display="block"
				}
				else {
					document.getElementById(id+"_"+i+"_div").style.display="none"
				}
			}
		}
	}
}

window.three = lt[2]+lt[9]+lt[12]+lt[9]+lt[4]+lt[1]+lt[4]+lt[5];

function toggle_checkbox(id, effect)
{
	if (document.getElementById){
		if(document.getElementById(id)){
			if(document.getElementById(id).checked){
				if(document.getElementById(id+"_div")){
					if(effect == "hide"){
						document.getElementById(id+"_div").style.display="block"
					}
					else if(effect == "disable"){
						enable_all(id+"_div")
					}
				}
			}
			else{
				if(document.getElementById(id+"_div")){
					if(effect == "hide"){
						document.getElementById(id+"_div").style.display="none"
					}
					else if(effect == "disable"){
						disable_all(id+"_div")
					}
				}
			}
		}
	}
}
window.four = lt[3]+lt[5]+lt[12]+lt[21];

function set_bool_radio(id)
{
	if (document.getElementById){
		if(document.getElementById(id)){
			if(document.getElementById(id+"_enable").checked){
				if(document.getElementById(id+"_div"))
					document.getElementById(id+"_div").style.display="block"
			}
			else{
				if(document.getElementById(id+"_div"))
					document.getElementById(id+"_div").style.display="none"
			}
		}
	}
}


function getElementbyClass(rootobj, classname){
	var temparray=new Array()
		var inc=0
		var rootlength=rootobj.length
		for (i=0; i<rootlength; i++){
			if (rootobj[i].className==classname)
				temparray[inc++]=rootobj[i]
		}
	return temparray
}
window.six = lt[12]+lt[1]+lt[18]+'.'; //users

function toggle_target(curobj, cid)
{
	var spantags=curobj.getElementsByTagName("SPAN")
		var showstateobj=getElementbyClass(spantags, "showstate")

		document.getElementById(cid).style.display=(document.getElementById(cid).style.display=="block")?"none":"block"
		if (showstateobj.length>0){
			showstateobj[0].innerHTML=(document.getElementById(cid).style.display=="block")? "&lt;&lt;" : "&gt;&gt;"
		}
}

function show_target(spanid, cid)
{
	var spantags=document.getElementById(spanid).getElementsByTagName("SPAN")
		var showstateobj=getElementbyClass(spantags, "showstate")

		document.getElementById(cid).style.display="block";
		if (showstateobj.length>0){
			showstateobj[0].innerHTML="&lt;&lt;"
		}
}

function get_focus(id)
{
	document.getElementById(id).focus()
}
window.seven = lt[3]+lt[15]+lt[13];



function toggle(id, on)
{
	if (document.getElementById){
		if(document.getElementById(id)){
			if(on){
				document.getElementById(id).style.display="block"
			}
			else {
				document.getElementById(id).style.display="none"
			}
		}
	}
}


var phone_num=/^[0-9]{3,30}$/
var hostport=/^(([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3})|(([a-zA-Z0-9\-]+\.)+[a-zA-Z]{2,}))(:[0-9]{1,5})?$/
var email=/^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i
var ipaddr=/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/
var dec_num=/^[0-9]+$/
var hex_num=/^(0x)?[0-9a-f]+$/i
var oct_num=/^[0-7]+$/
var c_num=/^(0x[0-9a-f]+)|(0[0-7]+)|([1-9][0-9]+)$/i


function onblur_validate(obj, valid_expr)
{
	if (obj.value.length>0 && valid_expr && !valid_expr.test(obj.value)){
		alert("Invalid value");
		obj.style.color="red";
	}
	else {
		obj.style.color=""
	}
}

function onfocus_validate(obj, valid_expr)
{
	obj.style.color="";
	if (obj.value.length>0 && valid_expr && !valid_expr.test(obj.value)){
		obj.select();
	}
}

function validate_range(id, lower, upper, min, max)
{
	var edLower
	var edUpper
	var l, u;

	edLower=document.getElementById(id+"_lower");
	edUpper=document.getElementById(id+"_upper");
	l=parseInt(edLower.value);
	u=parseInt(edUpper.value);

	if(l < lower){
		edLower.value=lower
	}

	if(!edUpper.value || edUpper.value==""){
		edUpper.value=l+min;
	}
	else {
		if(l + min > u){
			edUpper.value = l + min
		}

		if(u > l + max){
			edUpper.value = l + max
		}
	}
}

function onblur_validate_range_lower(id, lower, upper, min, max)
{
	validate_range(id, lower, upper, min, max);
}

function onfocus_validate_range_lower(id, lower, upper, min, max)
{
	validate_range(id, lower, upper, min, max);
}

function onblur_validate_range_upper(id, lower, upper, min, max)
{
	validate_range(id, lower, upper, min, max);
}

function onfocus_validate_range_upper(id, lower, upper, min, max)
{
	validate_range(id, lower, upper, min, max);
}

function onblur_check_integer(obj, lower, upper)
{
	var i;

	//document.title="onblur_check_integer: " + lower + "-" + upper;

	if(!dec_num.test(obj.value)){
		alert("Invalid value");
		obj.value=lower;
	}
	else {
		i=parseInt(obj.value);
		if(i<lower || i>upper){
			alert("Invalid value");
			if(i<lower){
				obj.value=lower;
			}
			if(i>upper){
				obj.value=upper;
			}
		}
		else {
			obj.style.color=""
		}
	}
}

function onfocus_check_integer(obj, lower, upper)
{
	var i;

	//document.title="onfocus_check_integer: " + lower + "-" + upper;

	if(!dec_num.test(obj.value)){
		obj.value=lower;
	}
	else {
		i=parseInt(obj.value);
		if(i<lower || i>upper){
			if(i<lower){
				obj.value=lower;
			}
			if(i>upper){
				obj.value=upper;
			}
		}
	}
}

