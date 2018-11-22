<?php
use App\Content;

$N_loginFail_m = 3;
$N_loginFail_h = 5;
function global_var($variable){
	switch ($variable) {
		case 'alertAt':
			return 5;

		case 'payment_method':
			return 'payu_std';
			//epayco, payu_std

		case 'payu_test':
			return 0;
		default:
			return;
	}
}

function trim_text($input, $length, $ellipses = true, $strip_html = true) {
    //strip tags, if desired
    if ($strip_html) {
        $input = strip_tags($input);
    }

    //no need to trim, already shorter than trim length
    if (strlen($input) <= $length) {
        return $input;
    }

    //find last space within length
    $last_space = strrpos(substr($input, 0, $length), ' ');
    $trimmed_text = substr($input, 0, $last_space);

    //add ellipses (...)
    if ($ellipses) {
        $trimmed_text .= '...';
    }

    return $trimmed_text;
}

function clean_url($dirty){
	   $dirty = preg_replace('~[^\\pL0-9_]+~u', '_', $dirty);
	   $dirty = trim($dirty, "-");
	   $dirty = iconv("utf-8", "us-ascii//TRANSLIT", $dirty);
	   $dirty = strtolower($dirty);
	   $clean = preg_replace('~[^-a-z0-9_]+~', '', $dirty);
	   return $clean;
}

function saludo_random($user){

	$greet[0] = "Hey ".$user->name." nos encanta tenerte aquí!";
	$greet[1] = $user->name.", es siempre un placer recibirte en Hippie Market";
	$greet[2] = "Hola hola ".$user->name.",<br><small>gracias por ser tan genial!</small>";
	$greet[3] = "¿Qué tal ".$user->name."? <br><small>esperamos encuentres todo en orden.</small>";
	$greet[4] = "Hola ".$user->name."!";
	$greet[5] = "Hey ".$user->name."!<br><small>esperamos disfrutes tu visita.</small>";
	$saludo = $greet[mt_rand(0, 5)];
	Log::debug($saludo);
	return($saludo);
}

function alertWindow($alertText){
	echo '
	<div class="alert alert-dismissible alert-danger">
	  <button type="button" class="close" data-dismiss="alert">&times;</button>
	  '.$alertText.'
	</div>
	';
}

function alertText($alertText){
	echo '
	<p class="text-danger"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> '.$alertText.'</p>
	';
}

function monetize($val){
	$val = (int)$val;
	$decimal = 0;
	if($val < 0){
		$val = $val * (-1);
		$sval = number_format($val, $decimal, '.', ',');
		return '-$'.$sval;
	}else{
		$sval = number_format($val, $decimal, '.', ',');
		return '$'.$sval;
	}
}
function parse_notification_title($type){
	switch ($type) {
		case 'fail_login':
			return '<i class="fa fa-exclamation-circle text-danger" aria-hidden="true"></i> Login fallido';
		case 'block_user':
			return 'Usuario bloqueado';
		case 'suspect_user':
			return 'Usuario_sospechoso';
		default:
			return ''.$type;
			break;
	}
}

function spanish_month($month){
	$month = (int)$month;
	switch ($month) {
		case 1:
			return "Enero";
		case 2:
			return "Febrero";
		case 3:
			return "Marzo";
		case 4:
			return "Abril";
		case 5:
			return "Mayo";
		case 6:
			return "Junio";
		case 7:
			return "Julio";
		case 8:
			return "Agosto";
		case 9:
			return "Septiembre";
		case 10:
			return "Octubre";
		case 11:
			return "Noviembre";
		case 12:
			return "Diciembre";
		default:
			return "".$month;
			break;
	}
}

function report_view($path){
	if(Auth::check()){
		Log::info(Auth::user()->email." visualizando ".$path);
	}else{
		$dir = Request::ip();
		Log::info("Visitante (".$dir.") visualizando ".$path);
	}
}

function print_image($properties, $content_id){
	$exits = null;
	$content = Content::where('id', $content_id)->first();
	//Log::debug("Solicitado: ".$content_id);
	if(isset($content)){
		$exists = Storage::disk('public')->exists($content->content);
	}else{
		$exists = 0;
	}
	if($exists){
		return("<img src='".url('/storage/'.$content->content)."' alt='".$content->description."' ".$properties.">");
	}
	else{
		return("");
	}
}

function parseUserType($userLevel){
	$userLevel = (int)$userLevel;
	switch ($userLevel) {
		case 1:
			return("Miembro Sitio");
			break;

		case 4:
			return("Cliente");
			break;

		case 8:
			return("Equipo de Ventas");
			break;

		case 16:
			return("Desarrollador");

		case 32:
			return("Administrador");

		default:
			# code...
			break;
	}
}

function parseUserColor($userLevel){
	$userLevel = (int)$userLevel;
	switch ($userLevel) {
		case 1:
			return("");
			break;

		case 4:
			return("success");
			break;

		case 8:
			return("info");
			break;

		case 16:
			return("warning");

		case 32:
			return("danger");

		default:
			# code...
			break;
	}
}
