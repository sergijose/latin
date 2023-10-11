<?php

class Conexion{

	static public function conectar(){

		$link = new PDO("mysql:host=localhost;dbname=inventario_latin",
			            "root",
			            "");

		$link->exec("set names utf8");

		return $link;
		$link=null;
		

	}

}