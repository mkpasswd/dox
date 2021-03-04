<?
define('DELTMP',true);

include('mini.inc.php');
include('T.class.php');


//on passe tout en base64 sinon ça va être la merde pour dépatouiller l'URL du WS
$path=base64_decode(trim(T::gp('path')));
$template=base64_decode(trim(T::gp('tpl','',4096)));
/*
$path=rawurldecode(trim(T::gp('path')));
$template=rawurldecode(trim(T::gp('tpl','',16384)));
*/

// echo "PATH=$path\n";
// echo "<PRE>".htmlentities($template)."</PRE>\n";

$ftpl=tempnam('/tmp','TPL-tpl-');
$fjson=tempnam('/tmp','TPL-json-');

file_put_contents($ftpl,$template);

exec("sudo -u dockerlogs ../bin/dox '$path' > $fjson",$tab,$ret);
// var_dump($tab);
// echo "RET=$ret";

if($ret==0) {
	// echo "COMMANDE PASSée\n";
	// file_put_contents($fjson,implode("\n",$tab));
	// echo "qsmlkmqlsdk ".getcwd()."  RET gotemp =$ret";
	// echo "Comande : ./gotemp -j $fjson -t $ftpl";
	exec("../bin/gotemp -j $fjson -t $ftpl",$tab,$ret);
	header('content-type: text/html');
	echo implode("\n",$tab);
	//gestion d'erreur à rajouter ici
	};
if(DELTMP) {
	if(file_exists($ftpl)) unlink($ftpl);
	if(file_exists($fjson)) unlink($fjson);
	};
?>
