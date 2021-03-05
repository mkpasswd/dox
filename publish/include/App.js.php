<?php
include '../mini.inc.php';
// header('text/plain;charset=utf-8'); //php fpm : ERR 500 ??
?>
//<SCRIPT> //triggers vi's JS syntax higlighting

//Call WS PRoxy + perform GOLANG template processing
function ttify(path,tplid,destid,endfunc) {
	pdata={};
	pdata.path=btoa(path);
	// tricky to get utf8 characters/html entity correct
	pdata.tpl=btoa(unescape(encodeURIComponent($(tplid).html())));
	$.post('<?=SITE?>/doxplus.php',pdata,
		function(res) {
		// console.log(destid+' REPONSE '+res);
		// $(destid).html(res);
		//traitement d'erreur à prévoir
		$(destid).slideUp(100,function() {
			$(destid).html(res);
			if(typeof endfunc=='function') {
				// console.log('Call endfunc');
				endfunc();
				};
			$(destid).slideDown(300);
			});
		},'html');
	}

//Direct call to WS Proxy, supposed to get plain stream output
function dcall(path,destid,endfunc) {
	var ws='<?=SITE?>/dox'+path;
	console.log('dscall WS '+ws);
	$.post(ws,{},function(res) {
		// console.log(destid+' REPONSE '+res);
		// $(destid).html(res);
		//traitement d'erreur à prévoir
		$(destid).slideUp(100,function() {
			$(destid).html('<TEXTAREA class="POP">'+res+'</TEXTAREA>');
			if(typeof endfunc=='function') {
				// console.log('Call endfunc');
				endfunc();
				};
			$(destid).slideDown(300);
			});
		},'text');
	}

function tsort(tid,header) {
	console.log('TSORT -'+tid+'- -'+header+'-');
	var i=0;
	var hi=-1;
	$(tid+' THEAD TH').each(function () {
		// console.log($(this).html());
		if($(this).html()==header) {
			hi=i;
			return;
			};
		i++;
		});
	if(hi<0) return;
	hi++; //CSS : index de 1 à n
	// console.log('Tri sur colonne '+hi);
	var tab=[];	
	$(tid+' TBODY TR').each(function() {
		var key=$(this).children(':nth-child('+hi+')').data('sort');
		if(key==undefined) key=$(this).children(':nth-child('+hi+')').html();  //[hi].html();
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
	$('.LINK').click(function() {window.location=$(this).data('dest');});
	$('.TSORT').live('click',function(e) {
		console.log('Click sort');
		e.preventDefault();
		var idtable=$(this).closest('TABLE').attr('id');
		// console.log($(this).closest('TABLE'));
		// console.log("TABLE:"+idtable);
		tsort('#'+idtable,$(this).html());
		return false;
		});
	});
