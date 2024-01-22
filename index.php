<?php

require 'flight/Flight.php';
require 'flight/rb.php';

R::setup( 'mysql:host=localhost;dbname=test', 'root', '' );

Flight::route('/', function () {
    echo 'Flight API de PHP con Base de Datos';
    echo '';
});

Flight::route('GET /alumnos', function () {
    echo 'VISUALIZA los Alumnos desde la Base de Datos';
    $alumnos = R::find('alumnos');
    echo Flight::json($alumnos);
});

Flight::route('GET /alumnos/@id', function ($id) {
    echo 'VISUALIZA un Alumno desde la Base de Datos';
    $alumno  = R::findOne( 'alumnos', ' id = ? ', [ $id ] );
    echo Flight::json($alumno);
});

Flight::route('POST /alumnos', function () {
    echo 'INSERTA Alumno a la Base de Datos';
    $alumno = R::dispense('alumnos');
    $nombres=Flight::request()->data->nombres;
    $apellidos=Flight::request()->data->apellidos;
    $alumno->nombres=$nombres;
    $alumno->apellidos=$apellidos;
    $id=R::store($alumno);
    Flight::jsonp(["Alumno agregado..."]);
});

Flight::route('PUT /alumnos', function () {
    echo 'MODIFICA Alumno a la Base de Datos';
    $alumno = R::dispense('alumnos');
    $id=Flight::request()->data->id;
    $nombres=Flight::request()->data->nombres;
    $apellidos=Flight::request()->data->apellidos;
    $alumno->id=$id;
    $alumno->nombres=$nombres;
    $alumno->apellidos=$apellidos;
    $id=R::store($alumno);
    Flight::jsonp(["Alumno modificado..."]);
});


Flight::route('DELETE /alumnos', function () {
    echo 'BORRA Alumno a la Base de Datos';
    $id=Flight::request()->data->id;
    $alumno = R::load('alumnos',$id);
    R::trash($alumno);
    Flight::jsonp(["Alumno Borrado..."]);
});
//Inicializa el FrameWork
Flight::start();
