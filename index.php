<?php

/* 
 * Copyright (C) 2014 Pedro Gabriel Manrique Gutiérrez <pedrogmanrique at gmail.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

ini_set('display_errors', 1);

// constantes
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', realpath(dirname(__FILE__)) . DS);
define('APP_PATH', ROOT . 'application' . DS);

// La encriptación MD5
//$md5 = md5('1234');
//printf("Clave md5 %s y la longitud de la cadena es de %d caracteres. ", $md5, strlen($md5));
//exit("Saliendo");
// El try atrapa todas las excepciones en cualquier parte de los scripts siguientes. 
// Declaradas como: throw new Exception("Mensaje")
try {
    require_once APP_PATH . 'ACL.php';
    require_once APP_PATH . 'Config.php';
    require_once APP_PATH . 'Request.php';
    require_once APP_PATH . 'Bootstrap.php';
    require_once APP_PATH . 'Controller.php';
    require_once APP_PATH . 'Model.php';
    require_once APP_PATH . 'View.php';
    require_once APP_PATH . 'Registro.php';
    require_once APP_PATH . 'Database.php';
    require_once APP_PATH . 'Session.php';
    require_once APP_PATH . 'Hash.php';

    //echo Hash::getHash('sha1', '1234', HASH_KEY); exit;

    Session::init();

    Bootstrap::run(new Request);  
    
} 
catch (Exception $exc) {
    echo $exc->getMessage();
}


