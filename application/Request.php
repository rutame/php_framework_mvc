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

class Request
{
    private $_controlador;
    private $_metodo;
    private $_argumentos;
    
    public function __construct() 
    {
        if(isset($_GET['url']))
        {
            $url = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            $url = array_filter($url);
        
            $this->_controlador = strtolower(array_shift($url)); //el primero
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
    }
    
    public function getControlador(){
        return $this->_controlador;
    }
    public function getMetodo(){
        return $this->_metodo;
    }
    public function getArgumentos(){
        return $this->_argumentos;
    }
}

