<?php
try{
require "wmv_core/config.php";
require "wmv_core/core.php";
require "wmv_core/functions.php";
require "wmv_core/models.php";
require "wmv_core/variables.php";
require "wmv_core/routers.php";

$request=array_diff(@explode("/", ltrim(strtok($_SERVER['REQUEST_URI'], "?"), '/')),array(""));

$trimmed=trim(trim(SITE_URL, "https://"), "http://");
if (strpos($trimmed, "/")) {
   	$exp=explode("/", $trimmed);
    if (empty(trim($exp[1]))==FALSE){
        $script_dir=count($exp)-1;
        for ($i=0; $i < $script_dir ; $i++) { 
			unset($request[$i]);
			$request=array_values(array_filter($request));
		}
    }
}

$slashcount=count($request)-1;

if (empty($request[0]) == FALSE){

	$slash='';
	$i=0;
	foreach ($request as $value) {
		$endstr=$i==$slashcount?"":"/";
		$slash.=ltrim($value, '_').$endstr;
	$i++;
	}

	try {
		$router=$routers[trim($slash,'/')];
	}catch (Exception $e) {

	}

	$slash=empty($router)==FALSE?$router:$slash;

	$require = VIEW_FOLDER.$slash.'.php';
	
	if (@file_exists($require) == TRUE){
		require $require;
	}else {
		$require = @file_exists(VIEW_FOLDER.ERROR_PAGE)==""?die(ERROR_WORD):VIEW_FOLDER.ERROR_PAGE;
		require $require;
	}

}else {
	$require = @file_exists(VIEW_FOLDER.DEFAULT_INDEX)==""?die(ERROR_WORD):VIEW_FOLDER.DEFAULT_INDEX;
	require $require;
}

} catch(Throwable $e) {
	$error=array(
		'message' => $e->getMessage(),
		'line' => $e->getLine(),
		'file' => $e->getFile(),
		'include_file' => $e->getTrace()[0]['file'],
		'include_line' => $e->getTrace()[0]['line'],

	);

	echo '<!DOCTYPE html><html><head><title>Hata!</title><style>body{color:#F0F000;}.content{border: 2px solid #6afc91; background-color: #fc8f6a; padding:50px; width: 700px; margin: auto;}.bigtext{display: flex; /* or inline-flex */ align-items: center; justify-content: center; font-size: 2em; font-weight: bold; padding:10px;}.right{float: right;}</style></head><body><div class="content"><div class="bigtext">HATA!</div>Hata mesajı:<b style="color:#FFF;"> '.$error['message'].'</b><br/><br/> Satır: <b style="color:#FFF;">'.$error['line'].'</b> | Dosya: <b style="color:#FFF;">'.$error['file'].'</b> <hr/> <div class="right"> Satır: <b style="color:#FFF;">'.$error['include_line'].'</b> </div><div class="left"> Nereden dahil edildi: <b style="color:#FFF;">'.$error['include_file'].'</b> </div></div></body></html>';
	exit;
}
?>