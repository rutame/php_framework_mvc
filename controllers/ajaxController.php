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

class ajaxController extends Controller
{
    private $_ajax;
    
    public function __construct()
    {
        parent::__construct();
        $this->_ajax = $this->loadModel('ajax');
    }
    
    public function index()
    {
        $this->_view->assign('titulo', 'Ejemplo de AJAX');
        $this->_view->setJs(array('ajax'));
        $this->_view->assign('paises', $this->_ajax->getPaises());
        $this->_view->renderizar('index');
    }
    
    public function getCiudades()
    {
        if($this->getInt('pais')){
           
            echo json_encode($this->_ajax->getCiudades($this->getInt('pais')));
 
        }
        else {
            $a = array("id" => 1, "ciudad" => "Paris", "pais" => "Francia");
            echo json_encode($a);
            echo $this->getInt('pais');
        }
    }
    
    public function insertarCiudad()
    {
        if($this->getInt('pais') && $this->getSql('ciudad')){
            $this->_ajax->insertarCiudad($this->getSql('ciudad'),  $this->getInt('pais') );
        }
    }
    
    public function prueba($param)
    {
        var_dump($this->_ajax->getCiudades($this->sacaId($param)));
    }
}
