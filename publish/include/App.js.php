<?php
include '../mini.inc.php';
// header('text/plain;charset=utf-8'); //php fpm : ERR 500 ??
?>
//<SCRIPT> //triggers vi's JS syntax higlighting
function ttify(path,tplid,destid) {
	pdata={};
	pdata.path=btoa(path);
	pdata.tpl=btoa(unescape(encodeURIComponent($(tplid).html())));
	$.post('<?=SITE?>/doxplus.php',pdata,
		function(res) {
		// console.log(destid+' REPONSE '+res);
		$(destid).html(res);
		//traitement d'erreur à prévoir
		/* $(destid).slideUp(300,function() {
			$(destid).html(res);
			$(destid).slideDown();
			});*/
		},'html');
	}

function tsort(tid,header) {
	console.log('TSORT -'+tid+'- -'+header+'-');
	var i=0;
	var hi=-1;
	$(tid+' THEAD TH').each(function () {
		console.log($(this).html());
		if($(this).html()==header) {
			hi=i;
			return;
			};
		i++;
		});
	if(hi<0) return;
	hi++; //CSS : index de 1 à n
	var tab=[];	
	$(tid+' TBODY TR').each(function() {
		var key=$(this).children(':nth-child('+hi+')').data('sort'); //[hi].html();
		tab.push({key: key, value: $(this).html()});
		});
	console.log(tab);
	tab.sort(function(a,b) {return a.key>b.key;});
	$(tid+' TBODY').empty();
	tab.forEach(function (val) {
		$(tid+' TBODY').append('<TR>'+val.value+"</TR>\n");
		});
	}

$(function() {
	$('.TSORT').live('click',function(e) {
		console.log('Click sort');
		e.preventDefault();
		tsort('TABLE',$(this).html());
		return false;
		});
	});
