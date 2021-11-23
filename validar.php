<?php

require __DIR__.'/vendor/autoload.php';

use \App\Validation\CNPJ;
use \App\Validation\CPF;

//$resultado = CNPJ::validar('22.222.222/2222-22');
$resultado = CPF::validar('352.299.840-58');

var_dump($resultado);