<?php

class Conexion{

	static public function conectar(){

		$link = new PDO("mysql:host=localhost;dbname=bd_logistica",
			            "root",
			            "");

		$link->exec("set names utf8");

		return $link;
		$link=null;
		

	}

}