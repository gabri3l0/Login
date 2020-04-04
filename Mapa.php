<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

<script src="imap5customcore.js" type="application/javascript"></script><script type="application/javascript">imap5custom.init({usermap:44104518,local:true,base:"",responsivemap:false});</script>


<?php  
$archivo = file_get_contents("imap5customusermap_44104518.js"); //lees el js del mapa aqui esta las ubicaciones y nombres de mesas

$archivo = html_entity_decode($archivo);//decodificas el archivo  

$pos1 = strpos($archivo,"\/44i");//obtienes donde empeiza la mesa a modificar VARIA

$pos2 = strpos($archivo,"\/44f");//obtiones donde se temrmina la mesa a modificar VARIA

$fin = strlen($archivo);//sacas el tamano total de tu archivo

$inicioHastaPos = substr($archivo, 0, $pos1);//cortas del inicio hasta el principio de la mesa

$posHastaFinal = substr($archivo, $pos2, $fin);//cortas del final de la mesa al final del archivo

$inyeccion = "\/44i>\.r\.n<div>\.r\.n<p><b>RP: Alan<\/b><\/p>\.r\.n<p><b>fefef<\/b><\/p>\.r\.n<p><b>Px Ing: 10<\/b><\/p>\.r\.n<\/div>\.r\.n<";//inyectas los nuevos datos a agregar VARIA

$inicioHastaPos .= $inyeccion;//juntas el inicio con la nueva mesa

$inicioHastaPos .= $posHastaFinal;//juntas todo el archivo

$archivo = str_replace("\.r\.n",'\r\n',$inicioHastaPos);//remplazas los valores criticos para que se lea bien el archivo

$myfile = fopen("imap5customusermap_44104518.js", "w") or die("No se puede abrir este archivo!");//abres el archivo a leer y la w es para sobre escribir la informacion

fwrite($myfile, $archivo);//sobreescribes el archivo con la nueva informaicion

fclose($myfile);//cierras el archivo y se guarda la info


?>
</body>
</html>