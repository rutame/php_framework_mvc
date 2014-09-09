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

/**
 * Modificada para ser modular
 * version 0.1a
 */

class Bootstrap
{
    public static function run(Request $peticion)
    {
        $modulo = $peticion->getModulo();
        $controller = $peticion->getControlador() . 'Controller';
        $rutaControlador = ROOT . 'controllers' . DS . $controller . '.php';
        $metodo = $peticion->getMetodo();
        $args = $peticion->getArgumentos();
        
        // para el modulo
        if($modulo){
            $rutaModulo = ROOT . 'controllers' . DS . $modulo . 'Controller.php';
            
            if(is_readable($rutaModulo)){
                require_once $rutaModulo;
                $rutaControlador = 
                        ROOT . 'modules' . DS . $modulo . DS . 'controllers' . DS . $controller . '.php';
            }
            else {
                throw new Exception("Error de base de modulo");
            }
        }
        else {
            $rutaControlador = ROOT . 'controllers' . DS . $controller . '.php'; 
        }
        
        //echo $rutaControlador;
        //        exit();
        
        if(is_readable($rutaControlador))
        {
            require_once $rutaControlador;
            //$controller = new indexController();
            $controller = new $controller;
            
            if(is_callable(array($controller, $metodo)))
            {
                //echo "$controller es llamable";
                $metodo = $peticion->getMetodo();
            }
            else{
                $metodo = 'index';
            }
            
            // Verificar argumentos
            if(isset($args)){
                call_user_func(array($controller,$metodo), $args);
            }
            else{
                call_user_func(array($controller,$metodo));
            }
        }
        else {
            //throw new Exception("No encontrado " . $rutaControlador);
            header('location:' . BASE_URL . 'error');
            
        }
        
    }
}
