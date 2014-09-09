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
 * Modificado para que sea modular
 * versión 0.1a
 */
class Request
{
    private $_modulo;
    private $_controlador;
    private $_metodo;
    private $_argumentos;
    private $_modules;
    
    public function __construct() 
    {
        if(isset($_GET['url']))
        {
            $url = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            $url = array_filter($url);
            
            // Para el modulo
            // Conseguir 2 tipos de direcion: 
            // 1 modulo/controlador/metodo/argumentos
            // 2 controlador/metodo/argumentos
            
            $this->_modules = array('usuarios'); // En esta array colocamos los modulos que vamos creando.
            $this->_modulo = strtolower(array_shift($url));
            
            if(!$this->_modulo){
                $this->_modulo = FALSE;
            }
            else{
                if(count($this->_modules)){
                    if(!in_array($this->_modulo, $this->_modules)){
                        $this->_controlador = $this->_modulo;
                        $this->_modulo = FALSE;
                    }
                    else{
                        $this->_controlador = strtolower(array_shift($url));
                        if(!$this->_controlador){
                            $this->_controlador = 'index';
                        }
                    }
                }
                else{
                    $this->_controlador = $this->_modulo;
                        $this->_modulo = FALSE;
                    }
            }

            $this->_metodo = strtolower(array_shift($url)); // el segundo
            $this->_argumentos = $url; // coge el resto como argumentos
        }
        
        if(!$this->_controlador){
            $this->_controlador = DEFAULT_CONTROLLER;
        }
        
        if(!$this->_metodo){
            $this->_metodo = 'index';
        }
        
        if(!isset($this->_argumentos)){
            $this->_argumentos = array();
        }
        
        //echo $this->_modulo . '/' . $this->_controlador . '/' . $this->_metodo . '/'; 
    //print_r($this->_argumentos);
    //exit();
    }
    
    /**
     * 
     * @return type
     */
    public function getModulo()
    {
        return $this->_modulo;
    }
    
    /**
     * 
     * @return type
     */
    public function getControlador(){
        return $this->_controlador;
    }
    
    /**
     * 
     * @return type
     */
    public function getMetodo(){
        return $this->_metodo;
    }
    
    /**
     * 
     * @return type
     */
    public function getArgumentos(){
        return $this->_argumentos;
    }
}

