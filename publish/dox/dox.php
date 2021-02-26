<?
$path=substr($_SERVER['REQUEST_URI'],strlen(dirname($_SERVER['SCRIPT_NAME'])));
exec("sudo -u dockerlogs ../../bin/dox -x '$path'",$tab,$ret);
if(!empty($tab)) {
	header($tab[0]);
	unset($tab[0]);
	echo implode("\n",$tab);
	};
// passthru("id -a ; pwd");
//echo exec("../../bin/dox",$out,$ret);
//echo $ret
//echo '<pre>';var_dump($tab);
//echo $ret;
//echo '</pre>';
?>
