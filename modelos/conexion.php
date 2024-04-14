<?php

class Conexion {
    static public function conectar() {
        try {
            $link = new PDO("mysql:host=localhost;dbname=inventario_latin", "root", "");
            $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $link->exec("set names utf8");
            return $link;
        } catch (PDOException $e) {
            // En caso de una excepción, puedes manejarla aquí
            // Puedes registrarla, mostrar un mensaje al usuario o manejarla de otra manera adecuada
            // Por ejemplo:
            echo "Error al conectar a la base de datos: " . $e->getMessage();
            // O puedes lanzar la excepción nuevamente para que el código que llama a esta función la maneje
            // throw $e;
            return null; // O devuelve null, indicando que la conexión falló
        }
    }
}