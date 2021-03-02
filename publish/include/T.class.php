<?
class T {
public static function dealinput($inp,$maxlen,$maxtabentries) {
	if(is_array($inp)) {
		$ret=array();
		foreach($inp as $v) $ret[]=substr($v,0,$maxlen);
		return $ret;
		}
	else return substr($inp,0,$maxlen);
	}

public static function gp($name,$default=NULL,$maxlen=512,$maxtabentries=20) {
	if(isset($_POST[$name])) return self::dealinput($_POST[$name],$maxlen,$maxtabentries);
	if(isset($_GET[$name])) return self::dealinput($_GET[$name],$maxlen,$maxtabentries);
	if(isset($default)) return $default;
	return false;
	}

public static function cuts() {	return time();	}

public static function currenthttpdir() {
	$url='http'.((!empty($_SERVER['HTTPS']))? 's':'').'://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
	preg_match('=^(.*)/=',$url,$match);
	return $match[1];
}

}; // fin definition de la classe
?>
