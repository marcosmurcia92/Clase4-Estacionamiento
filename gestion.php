<?php

/*	1- si es un ingreso lo guardo en ticket.txt
 	2- si es salida leo el archivo:
 	leer del archivo todos los datos, guardarlos en un array
	si la patente existe en el archivo .
	 sobreescribo el archivo con todas las patentes
	 y su horario si la patente solicitada
	... calculo el costo de estacionamiento a 
	20$ el segundo y lo muestro.
	si la patente no existe mostrar mensaje y 
	el boton que me redirija al index  
	3- guardar todo lo facturado en facturado.txt*/

//var_dump($_POST['estacionar']);
$accion=$_POST['estacionar'];
$patente=$_POST["patente"];
$ahora=date("Y-M-d h:i:s");
$listaDeAutos=array();

if ($accion=="ingreso") {
	echo "Se guardo la patente ".$patente;
	$archivo=fopen("Ticket.txt", "a");
	fwrite($archivo, $patente."|".$ahora."\n");
	fclose($archivo);
}else{
	$archivo=fopen("Ticket.txt", "r");
	while (!feof($archivo)) {
		$linea=fgets($archivo);
		$auto=explode('|', $linea);
		if ($auto[0]!="") {
			$listaDeAutos[]=$auto;
		}
	}
	fclose($archivo);
	//var_dump($listaDeAutos);
	$esta=false;
	$precio=0;
	foreach ($listaDeAutos as $auto) {
		//echo $auto[0]."<br>";
		if ($auto[0]==$patente) {
			$esta=true;
			$fechainicio = $auto[1];
			$diferencia=strtotime($ahora)-strtotime($fechainicio);
			echo "El tiempo transcurrido es ".$diferencia." segundos.<br>";
		}
	}

	if ($esta) {
		$precio= 20*$diferencia;
		echo "Esta el auto <br>Debe abonar: $".$precio;
		$archivo=fopen("Ticket.txt", "w");
		foreach ($listaDeAutos as $auto) {
			//echo $auto[0]."<br>";
			if ($auto[0]!=$patente) {
				fwrite($archivo, $auto[0]."|".$auto[1]);
			}
		}
		fclose($archivo);
	}else{
		echo "No esta el auto";
	}
}
?>
<br>
<br>
<a href="index.php">volver</a>