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
		console.log(destid+' REPONSE '+res);
		$(destid).html(res);
		//traitement d'erreur à prévoir
		/* $(destid).slideUp(300,function() {
			$(destid).html(res);
			$(destid).slideDown();
			});*/
		},'html');
	}

