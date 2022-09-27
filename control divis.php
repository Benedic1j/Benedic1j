<?php

class ControladorDivisas{

	/*=============================================
	MOSTRAR Divisas
	=============================================*/

	static public function ctrMostrarDivisas($item, $valor){

		$tabla = "divisas";

		$respuesta = ModeloDivisas::mdlMostrarDivisas($tabla, $item, $valor);

		return $respuesta;

	}

	// /*=============================================
	// MOSTRAR Divisas2
	// =============================================*/

	// static public function ctrMostrarDivisas3($item, $valor){

	// 	$tabla = "divisas3";

	// 	$respuesta = ModeloDivisas::mdlMostrarDivisas($tabla, $item, $valor);

	// 	return $respuesta;

	// }

}
