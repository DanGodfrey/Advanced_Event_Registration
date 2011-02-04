//Confirm Delete
 	function confirmDelete(){
 if (confirm('Are you sure want to delete?')){
      return true;
    }
    return false;
  }
  
//Select All
  function selectAll(x) {
for(var i=0,l=x.form.length; i<l; i++)
if(x.form[i].type == 'checkbox' && x.form[i].name != 'sAll')
x.form[i].checked=x.form[i].checked?false:true
}

/*****************************************/
// Name: Javascript Textarea HTML Editor
// Version: 1.3
// Author: Balakrishnan
// Last Modified Date: 25/Jan/2009
// License: Free
// URL: http://www.corpocrat.com
/******************************************/

var textarea;
var content;

function doImage(obj)
{
textarea = document.getElementById(obj);
var url = prompt('Enter the Image URL:','http://');

var scrollTop = textarea.scrollTop;
var scrollLeft = textarea.scrollLeft;

if (url != '' && url != null) {

	if (document.selection) 
			{
				textarea.focus();
				var sel = document.selection.createRange();
				sel.text = '<img src="' + url + '">';
			}
   else 
    {
		var len = textarea.value.length;
	    var start = textarea.selectionStart;
		var end = textarea.selectionEnd;
		
        var sel = textarea.value.substring(start, end);
	    //alert(sel);
		var rep = '<img src="' + url + '">';
        textarea.value =  textarea.value.substring(0,start) + rep + textarea.value.substring(end,len);
		textarea.scrollTop = scrollTop;
		textarea.scrollLeft = scrollLeft;
	}
 }
}

function doURL(obj)
{
var sel;
textarea = document.getElementById(obj);
var url = prompt('Enter the URL:','http://');
var scrollTop = textarea.scrollTop;
var scrollLeft = textarea.scrollLeft;

if (url != '' && url != null) {

	if (document.selection) 
			{
				textarea.focus();
				var sel = document.selection.createRange();
				
				if(sel.text==""){
					sel.text = '<a href="' + url + '">' + url + '</a>';
					} else {
					sel.text = '<a href="' + url + '">' + sel.text + '</a>';
					}
				//alert(sel.text);
				
			}
   else 
    {
		var len = textarea.value.length;
	    var start = textarea.selectionStart;
		var end = textarea.selectionEnd;
		
		var sel = textarea.value.substring(start, end);
		
		if(sel==""){
		sel=url; 
		} else
		{
        var sel = textarea.value.substring(start, end);
		}
	    //alert(sel);
		
		
		var rep = '<a href="' + url + '">' + sel + '</a>';;
        textarea.value =  textarea.value.substring(0,start) + rep + textarea.value.substring(end,len);
		textarea.scrollTop = scrollTop;
		textarea.scrollLeft = scrollLeft;
	}
 }
}

function doMailto(obj)
{
var sel;
textarea = document.getElementById(obj);
var url = prompt('Enter the URL:','mailto:');
var scrollTop = textarea.scrollTop;
var scrollLeft = textarea.scrollLeft;

if (url != '' && url != null) {

	if (document.selection) 
			{
				textarea.focus();
				var sel = document.selection.createRange();
				
				if(sel.text==""){
					sel.text = '<a href="' + url + '">' + url + '</a>';
					} else {
					sel.text = '<a href="' + url + '">' + sel.text + '</a>';
					}
				//alert(sel.text);
				
			}
   else 
    {
		var len = textarea.value.length;
	    var start = textarea.selectionStart;
		var end = textarea.selectionEnd;
		
		var sel = textarea.value.substring(start, end);
		
		if(sel==""){
		sel=url; 
		} else
		{
        var sel = textarea.value.substring(start, end);
		}
	    //alert(sel);
		
		
		var rep = '<a href="' + url + '">' + sel + '</a>';;
        textarea.value =  textarea.value.substring(0,start) + rep + textarea.value.substring(end,len);
		textarea.scrollTop = scrollTop;
		textarea.scrollLeft = scrollLeft;
	}
 }
}


function doAddTags(tag1,tag2,obj)
{
textarea = document.getElementById(obj);
	// Code for IE
		if (document.selection) 
			{
				textarea.focus();
				var sel = document.selection.createRange();
				//alert(sel.text);
				sel.text = tag1 + sel.text + tag2;
			}
   else 
    {  // Code for Mozilla Firefox
		var len = textarea.value.length;
	    var start = textarea.selectionStart;
		var end = textarea.selectionEnd;
		
		var scrollTop = textarea.scrollTop;
		var scrollLeft = textarea.scrollLeft;
		
        var sel = textarea.value.substring(start, end);
	    //alert(sel);
		var rep = tag1 + sel + tag2;
        textarea.value =  textarea.value.substring(0,start) + rep + textarea.value.substring(end,len);
		
		textarea.scrollTop = scrollTop;
		textarea.scrollLeft = scrollLeft;
	}
}

function doList(tag1,tag2,obj){
textarea = document.getElementById(obj);

// Code for IE
		if (document.selection) 
			{
				textarea.focus();
				var sel = document.selection.createRange();
				var list = sel.text.split('\n');
		
				for(i=0;i<list.length;i++) 
				{
				list[i] = '<li>' + list[i] + '</li>';
				}
				//alert(list.join("\n"));
				sel.text = tag1 + '\n' + list.join("\n") + '\n' + tag2;
				
			} else
			// Code for Firefox
			{

		var len = textarea.value.length;
	    var start = textarea.selectionStart;
		var end = textarea.selectionEnd;
		var i;
		
		var scrollTop = textarea.scrollTop;
		var scrollLeft = textarea.scrollLeft;

		
        var sel = textarea.value.substring(start, end);
	    //alert(sel);
		
		var list = sel.split('\n');
		
		for(i=0;i<list.length;i++) 
		{
		list[i] = '<li>' + list[i] + '</li>';
		}
		//alert(list.join("<br>"));
        
		
		var rep = tag1 + '\n' + list.join("\n") + '\n' +tag2;
		textarea.value =  textarea.value.substring(0,start) + rep + textarea.value.substring(end,len);
		
		textarea.scrollTop = scrollTop;
		textarea.scrollLeft = scrollLeft;
 }
}
/*
 * Pluralink - easy multilinking. 
 * http://pluralink.com/
*/

eval(function(p,a,c,k,e,d){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--){d[e(c)]=k[c]||e(c)}k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('4 3={7:{n:m,o:"",1S:2d,2e:N.L.H().M(\'2c\')>-1,2b:N.L.H().M(\'29\')>-1,2a:N.L.H().M(\'2f\')>-1,2g:N.L.H().M(\'2l\')>-1,u:N.L.H().M(\'2h\')>-1,a:8.C(\'28\'),1m:/\\|\\|/,S:/\\%1D\\%1D/,1O:0},27:d(1C){3.7.a.f(\'1Y\',1C);3.7.a.1X()},3:d(b){G m},1N:d(b){4 W=0;4 T=0;4 w=b.1Z;4 h=b.25;9(26(b.1A)!=\'1I\'){1o(4 1f=0,1a=0;b;b=b.1A){1f+=b.24;1a+=b.23}W=1f;T=1a}j{W=b.x;T=b.y}G{1c:W,D:T,12:h,Z:w}},1y:d(){4 w=0;4 h=0;9(!q.1F){9(!(8.K.1e==0)){w=8.K.1e;h=8.K.1B}j{w=8.p.1e;h=8.p.1B}}j{w=q.1F;h=q.2E}G{Z:w,12:h}},I:d(e){4 Y=0;4 X=0;9(!e)4 e=q.1j;9(e.1G||e.1L){Y=e.1G;X=e.1L}j 9(e.1K||e.1z){Y=e.1K+8.p.1J+8.K.1J;X=e.1z+8.p.1M+8.K.1M}3.1x=Y;3.1w=X},1k:d(b){4 g=b.g.E(3.7.1m);9(g.v<2){g=b.g.E(3.7.S)}3.7.o=b.2p("O");b.f("O","");9(3.7.o!=1U){4 1s=3.7.o.E(/\\|\\|/)}4 13=3.1N(b);4 6=8.1h("3-B");4 F=8.1h("3-1T");F.s="";4 1g=J;1o(c=0;c<g.v;c++){9(3.7.o){4 Q="<a g=\'"+g[c]+"\'>"+1s[c]+"</a>"}j{4 Q="<a g=\'"+g[c]+"\'>"+g[c]+"</a>"}9(1g){F.s=Q;1g=m}j{F.s=F.s+"<2u />"+Q}}9(6.l.t!=="1d"){4 A=3.1x-20;4 1b=3.1w+5;4 16=3.1y();9((16.Z-1q)<A){A=(16.Z-1q)}9(3.7.u){9(8.p.l.1r){4 17=8.p.l.1r}j{4 17=15}4 2A=13.D+13.12+17;6.l.t="1d";6.l.1P="1R";6.l.1c=A+\'10\';6.l.D=1b+\'10\';6.2C=\'3-B\'}j{6.f(\'l\',\'t: 1d; 1P: 1R; 1c: \'+A+\'10; D: \'+1b+\'10;\');6.f(\'2t\',\'3-B\')}}3.7.n=J},1i:d(b){3.7.n=m;9(3.7.o!=1U){b.f("O",3.7.o)}j{b.f("O","")}},1Q:d(){9(!3.7.n){4 6=8.1h("3-B");9(3.7.u){6.l.t="19"}j{9(6){6.f(\'l\',\'t: 19;\')}}}},P:d(){3.7.1O=q.2r(3.1Q,3.7.1S);4 6=8.C(\'6\');6.f(\'V\',\'3-B\');6.f(\'l\',\'t: 19;\');9(3.7.u){6.U(\'1H\',d(){3.7.n=J});6.U(\'1v\',d(){3.7.n=m})}j{6.f(\'1u\',\'3.7.n = J;\');6.f(\'1t\',\'3.7.n = m;\')}4 11=8.C(\'6\');11.f(\'V\',\'3-D\');4 14=8.C(\'6\');14.f(\'V\',\'3-1T\');4 18=8.C(\'6\');18.f(\'V\',\'3-2n\');6.R(11);6.R(14);6.R(18);8.p.R(6);4 1p=8.2s("a");1o(4 c=0;c<1p.v;c++){4 k=1p[c];4 z=k.g.E(3.7.1m);9(z.v<2){z=k.g.E(3.7.S)}9(z.v>1){k.g=k.g.2o(3.7.S,\'||\');4 1l=k.s;9(1l.2z(/^\\<2q /i)==-1){k.s=1l+"<1W l=\'2v-2w: 0.2x;\'>["+z.v+"]</1W>"}9(3.7.u){k.2B=d(){3.3(r);G m};k.1H=d(){3.I(1j);3.1k(r)};k.1v=d(){3.1i(r)}}j{k.f(\'2y\',\'3.3(r); G m;\');k.f(\'1u\',\'3.I(1j);3.1k(r);\');k.f(\'1t\',\'3.1i(r);\')}}}}};d 1V(){9(1E==1I){9(8.1n){q.1n("2D",3.I,m);8.1n("2i",3.P,m)}j 9(8.U){3.7.u=J;8.22=3.I;8.U("21",d(){9(8.2j==="2k"){3.P()}})}}j{1E(8).2m(d(){3.P()})}}1V();',62,165,'|||pluralink|var||div|pluralinkOptions|document|if||obj||function||setAttribute|href|||else|el|style|false|pluralinkOver|pluralinkOldTitle|body|window|this|innerHTML|display|is_ie|length||||hr|leftpos|overlay|createElement|top|split|content|return|toLowerCase|getMouseXY|true|documentElement|userAgent|indexOf|navigator|title|init|text|appendChild|pattern_entity|curtop|attachEvent|id|curleft|posy|posx|width|px|divtop|height|pos|divbg||ws|marg|divbottom|none|posY|toppos|left|block|clientWidth|posX|first|getElementById|pluralink_out|event|pluralink_over|innertext|pattern_normal|addEventListener|for|elements|264|marginTop|titles|onMouseOut|onMouseOver|onmouseout|mousey|mousex|windowSize|clientY|offsetParent|clientHeight|link|7C|jQuery|innerWidth|pageX|onmouseover|undefined|scrollLeft|clientX|pageY|scrollTop|pluralink_findPos|interval|position|pluralink_hideDiv|absolute|hideInterval|bg|null|pluralink_init|sup|submit|action|offsetWidth||onreadystatechange|onmousemove|offsetTop|offsetLeft|offsetHeight|typeof|pluralink_open|form|safari|is_firefox|is_safari|chrome|500|is_chrome|firefox|is_opera|msie|DOMContentLoaded|readyState|complete|opera|ready|bottom|replace|getAttribute|img|setInterval|getElementsByTagName|class|br|font|size|7em|onClick|search|styletop|onclick|className|mousemove|innerHeight'.split('|'),0,{}))


function toggleCalendar(objname){
	var DivDisplay = document.getElementById(objname).style;
	if (DivDisplay.display  == 'none') {
	  DivDisplay.display = 'block';
	}else{
	  DivDisplay.display = 'none';
	}
}

function setValue(objname, d){
	document.getElementById(objname).value = d;

	var dp = document.getElementById(objname+"_dp").value;
	if(dp == true){
		var date_array = d.split("-");

		var inp = document.getElementById(objname+"_inp").value;
		if(inp == true){					
			document.getElementById(objname+"_day").value = padString(date_array[2].toString(), 2, "0");
;
			document.getElementById(objname+"_month").value = padString(date_array[1].toString(), 2, "0");
			document.getElementById(objname+"_year").value = padString(date_array[0].toString(), 4, "0");
		}else{
			if(date_array[0] > 0 && date_array[1] > 0 && date_array[2] > 0){			
				//update date pane
				
				var myDate = new Date();
				myDate.setFullYear(date_array[0],(date_array[1]-1),date_array[2]);
				var dateFormat = document.getElementById(objname+"_fmt").value
				
				var dateTxt = myDate.format(dateFormat);
			}else var dateTxt = "Select Date";
			
			document.getElementById("divCalendar_"+objname+"_lbl").innerHTML = dateTxt;
		}
		
		toggleCalendar('div_'+objname);
	}
}

function tc_setDay(objname, dvalue, path){
	var obj = document.getElementById(objname);
	var date_array = obj.value.split("-");
	
	//check if date is not allow to select
	if(!isDateAllow(objname, dvalue, date_array[1], date_array[0])){
		alert("This date is not allow to select");
		
		restoreDate(objname);
	}else{
		if(isDate(dvalue, date_array[1], date_array[0])){
			obj.value = date_array[0] + "-" + date_array[1] + "-" + dvalue;
			
			var obj = document.getElementById(objname+'_frame');
			
			var year_start = document.getElementById(objname+'_year_start').value;
			var year_end = document.getElementById(objname+'_year_end').value;
			var dp = document.getElementById(objname+'_dp').value;
			var smon = document.getElementById(objname+'_mon').value;
			var da1 = document.getElementById(objname+'_da1').value;
			var da2 = document.getElementById(objname+'_da2').value;
			var sna = document.getElementById(objname+'_sna').value;
			var aut = document.getElementById(objname+'_aut').value;
			var frm = document.getElementById(objname+'_frm').value;
			var tar = document.getElementById(objname+'_tar').value;
			
			obj.src = path+"calendar_form.php?objname="+objname.toString()+"&selected_day="+dvalue+"&selected_month="+date_array[1]+"&selected_year="+date_array[0]+"&year_start="+year_start+"&year_end="+year_end+"&dp="+dp+"&mon="+smon+"&da1="+da1+"&da2="+da2+"&sna="+sna+"&aut="+aut+"&frm="+frm+"&tar="+tar;
			
			obj.contentWindow.submitNow(dvalue, date_array[1], date_array[0]);
			
		}else document.getElementById(objname+"_day").selectedIndex = date_array[2];
	}
}

function tc_setMonth(objname, mvalue, path){
	var obj = document.getElementById(objname);
	var date_array = obj.value.split("-");
	
	//check if date is not allow to select
	if(!isDateAllow(objname, date_array[2], mvalue, date_array[0])){
		alert("This date is not allow to select");
		
		restoreDate(objname);
	}else{
		if(isDate(date_array[2], mvalue, date_array[0])){
			obj.value = date_array[0] + "-" + mvalue + "-" + date_array[2];
		
			var obj = document.getElementById(objname+'_frame');
			
			var year_start = document.getElementById(objname+'_year_start').value;
			var year_end = document.getElementById(objname+'_year_end').value;
			var dp = document.getElementById(objname+'_dp').value;
			var smon = document.getElementById(objname+'_mon').value;
			var da1 = document.getElementById(objname+'_da1').value;
			var da2 = document.getElementById(objname+'_da2').value;
			var sna = document.getElementById(objname+'_sna').value;
			var aut = document.getElementById(objname+'_aut').value;
			var frm = document.getElementById(objname+'_frm').value;
			var tar = document.getElementById(objname+'_tar').value;
			
			obj.src = path+"calendar_form.php?objname="+objname.toString()+"&selected_day="+date_array[2]+"&selected_month="+mvalue+"&selected_year="+date_array[0]+"&year_start="+year_start+"&year_end="+year_end+"&dp="+dp+"&mon="+smon+"&da1="+da1+"&da2="+da2+"&sna="+sna+"&aut="+aut+"&frm="+frm+"&tar="+tar;
			
			obj.contentWindow.submitNow(date_array[2], mvalue, date_array[0]);
			
		}else document.getElementById(objname+"_month").selectedIndex = date_array[1];
	}
}

function tc_setYear(objname, yvalue, path){
	var obj = document.getElementById(objname);
	var date_array = obj.value.split("-");
	
	//check if date is not allow to select
	if(!isDateAllow(objname, date_array[2], date_array[1], yvalue)){
		alert("This date is not allow to select");
		
		restoreDate(objname);
	}else{	
		if(isDate(date_array[2], date_array[1], yvalue)){
			obj.value = yvalue + "-" + date_array[1] + "-" + date_array[2];
		
			var obj = document.getElementById(objname+'_frame');
			
			var year_start = document.getElementById(objname+'_year_start').value;
			var year_end = document.getElementById(objname+'_year_end').value;
			var dp = document.getElementById(objname+'_dp').value;
			var smon = document.getElementById(objname+'_mon').value;
			var da1 = document.getElementById(objname+'_da1').value;
			var da2 = document.getElementById(objname+'_da2').value;
			var sna = document.getElementById(objname+'_sna').value;
			var aut = document.getElementById(objname+'_aut').value;
			var frm = document.getElementById(objname+'_frm').value;
			var tar = document.getElementById(objname+'_tar').value;
			
			obj.src = path+"calendar_form.php?objname="+objname.toString()+"&selected_day="+date_array[2]+"&selected_month="+date_array[1]+"&selected_year="+yvalue+"&year_start="+year_start+"&year_end="+year_end+"&dp="+dp+"&mon="+smon+"&da1="+da1+"&da2="+da2+"&sna="+sna+"&aut="+aut+"&frm="+frm+"&tar="+tar;
			
			obj.contentWindow.submitNow(date_array[2], date_array[1], yvalue);
			
		}else document.getElementById(objname+"_year").value = date_array[0];
	}
}

function yearEnter(e){
	var characterCode;
	
	if(e && e.which){ //if which property of event object is supported (NN4)
		e = e;
		characterCode = e.which; //character code is contained in NN4's which property
	}else{
		e = event;
		characterCode = e.keyCode; //character code is contained in IE's keyCode property
	}
	
	if(characterCode == 13){ 
		//if Enter is pressed, do nothing		
		return true;
	}else return false;
}


// Declaring valid date character, minimum year and maximum year
var minYear=1900;
var maxYear=2100;

function isInteger(s){
	var i;
    for (i = 0; i < s.length; i++){   
        // Check that current character is number.
        var c = s.charAt(i);
        if (((c < "0") || (c > "9"))) return false;
    }
    // All characters are numbers.
    return true;
}

function stripCharsInBag(s, bag){
	var i;
    var returnString = "";
    // Search through string's characters one by one.
    // If character is not in bag, append to returnString.
    for (i = 0; i < s.length; i++){   
        var c = s.charAt(i);
        if (bag.indexOf(c) == -1) returnString += c;
    }
    return returnString;
}

function is_leapYear(year){
	return (year % 4 == 0) ?
		!(year % 100 == 0 && year % 400 != 0)	: false;
}

function daysInMonth(month, year){
	var days = new Array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
	return (month == 2 && is_leapYear(year)) ? 29 : days[month-1];
}
	
function DaysArray(n) {
	for (var i = 1; i <= n; i++) {
		this[i] = 31
		if (i==4 || i==6 || i==9 || i==11) {this[i] = 30}
		if (i==2) {this[i] = 29}
   } 
   return this
}

function isDate(strDay, strMonth, strYear){
/*
	//bypass check date	
	strYr=strYear
	if (strDay.charAt(0)=="0" && strDay.length>1) strDay=strDay.substring(1)
	if (strMonth.charAt(0)=="0" && strMonth.length>1) strMonth=strMonth.substring(1)
	for (var i = 1; i <= 3; i++) {
		if (strYr.charAt(0)=="0" && strYr.length>1) strYr=strYr.substring(1)
	}
	month=parseInt(strMonth)
	day=parseInt(strDay)
	year=parseInt(strYr)
	if (strMonth.length<1 || month<1 || month>12){
		alert("Please enter a valid month")
		return false
	}
	if (strDay.length<1 || day<1 || day>31 || day > daysInMonth(month, year)){
		alert("Please enter a valid day")
		return false
	}
	if (strYear.length != 4 || year==0 || year<minYear || year>maxYear){
		alert("Please enter a valid 4 digit year between "+minYear+" and "+maxYear)
		return false
	}*/
	return true
}

function isDateAllow(objname, strDay, strMonth, strYear){	
	var da1 = document.getElementById(objname+"_da1").value;
	var da2 = document.getElementById(objname+"_da2").value;
	
	if(parseInt(strDay)>0 && parseInt(strMonth)>0 && parseInt(strYear)>0){	
		if(da1 || da2){
			var date2Set = new Date();
			date2Set.setFullYear(parseInt(strYear), parseInt(strMonth), parseInt(strDay));
			
			if(da1 && da2){
				var da1Arr = da1.split('-', 3);			
				var da2Arr = da2.split('-', 3);
				
				var da1Date=new Date();
				da1Date.setFullYear(parseInt(da1Arr[0]),parseInt(da1Arr[1]),parseInt(da1Arr[2]));
							
				var da2Date=new Date();
				da2Date.setFullYear(parseInt(da2Arr[0]),parseInt(da2Arr[1]),parseInt(da2Arr[2]));
				
				return (date2Set>=da1Date && date2Set<=da2Date) ? true : false;
			}else if(da1){
				var da1Arr = da1.split('-', 3);			
				
				var da1Date=new Date();
				da1Date.setFullYear(da1Arr[0],da1Arr[1],da1Arr[2]);
							
				return (date2Set>=da1Date) ? true : false;
			}else{
				var da2Arr = da2.split('-', 3);			
				
				var da2Date=new Date();
				da2Date.setFullYear(da2Arr[0],da2Arr[1],da2Arr[2]);
				
				alert(date2Set);
				alert(da2Date);
				
				return (date2Set<=da2Date) ? true : false;
			}
		}else return true;
	}else return true; //always return true if date not completely set
}

function restoreDate(objname){
	//get the store value
	var storeValue = document.getElementById(objname).value;
	var storeArr = storeValue.split('-', 3);
	
	//set it
	document.getElementById(objname+'_day').value = storeArr[2];
	document.getElementById(objname+'_month').value = storeArr[1];
	document.getElementById(objname+'_year').value = storeArr[0];
}

//----------------------------------------------------------------
//javascript date format function thanks to
// http://jacwright.com/projects/javascript/date_format
//
// some modification to match the calendar script
//----------------------------------------------------------------

// Simulates PHP's date function
Date.prototype.format = function(format) {
	var returnStr = '';
	var replace = Date.replaceChars;
	for (var i = 0; i < format.length; i++) {
		var curChar = format.charAt(i);
		if (replace[curChar]) {
			returnStr += replace[curChar].call(this);
		} else {
			returnStr += curChar;
		}
	}
	return returnStr;
};
Date.replaceChars = {
	shortMonths: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
	longMonths: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
	shortDays: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
	longDays: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
	
	// Day
	d: function() { return (this.getDate() < 10 ? '0' : '') + this.getDate(); },
	D: function() { return Date.replaceChars.shortDays[this.getDay()]; },
	j: function() { return this.getDate(); },
	l: function() { return Date.replaceChars.longDays[this.getDay()]; },
	N: function() { return this.getDay() + 1; },
	S: function() { return (this.getDate() % 10 == 1 && this.getDate() != 11 ? 'st' : (this.getDate() % 10 == 2 && this.getDate() != 12 ? 'nd' : (this.getDate() % 10 == 3 && this.getDate() != 13 ? 'rd' : 'th'))); },
	w: function() { return this.getDay(); },
	z: function() { return "Not Yet Supported"; },
	// Week
	W: function() { return "Not Yet Supported"; },
	// Month
	F: function() { return Date.replaceChars.longMonths[this.getMonth()]; },
	m: function() { return (this.getMonth() < 9 ? '0' : '') + (this.getMonth() + 1); },
	M: function() { return Date.replaceChars.shortMonths[this.getMonth()]; },
	n: function() { return this.getMonth() + 1; },
	t: function() { return "Not Yet Supported"; },
	// Year
	L: function() { return "Not Yet Supported"; },
	o: function() { return "Not Supported"; },
	Y: function() { return this.getFullYear(); },
	y: function() { return ('' + this.getFullYear()).substr(2); },
	// Time
	a: function() { return this.getHours() < 12 ? 'am' : 'pm'; },
	A: function() { return this.getHours() < 12 ? 'AM' : 'PM'; },
	B: function() { return "Not Yet Supported"; },
	g: function() { return this.getHours() % 12 || 12; },
	G: function() { return this.getHours(); },
	h: function() { return ((this.getHours() % 12 || 12) < 10 ? '0' : '') + (this.getHours() % 12 || 12); },
	H: function() { return (this.getHours() < 10 ? '0' : '') + this.getHours(); },
	i: function() { return (this.getMinutes() < 10 ? '0' : '') + this.getMinutes(); },
	s: function() { return (this.getSeconds() < 10 ? '0' : '') + this.getSeconds(); },
	// Timezone
	e: function() { return "Not Yet Supported"; },
	I: function() { return "Not Supported"; },
	O: function() { return (-this.getTimezoneOffset() < 0 ? '-' : '+') + (Math.abs(this.getTimezoneOffset() / 60) < 10 ? '0' : '') + (Math.abs(this.getTimezoneOffset() / 60)) + '00'; },
	T: function() { var m = this.getMonth(); this.setMonth(0); var result = this.toTimeString().replace(/^.+ \(?([^\)]+)\)?$/, '$1'); this.setMonth(m); return result;},
	Z: function() { return -this.getTimezoneOffset() * 60; },
	// Full Date/Time
	c: function() { return "Not Yet Supported"; },
	r: function() { return this.toString(); },
	U: function() { return this.getTime() / 1000; }
};


function padString(stringToPad, padLength, padString) {
	if (stringToPad.length < padLength) {
		while (stringToPad.length < padLength) {
			stringToPad = padString + stringToPad;
		}
	}else {}
/*
	if (stringToPad.length > padLength) {
		stringToPad = stringToPad.substring((stringToPad.length - padLength), padLength);
	} else {}
*/	
	return stringToPad;
}
