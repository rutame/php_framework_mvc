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

class errorController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function index()
    {
        $this->_view->assign("titulo", "Ha habido un error");
        $this->_view->assign('mensaje',$this->_getError());
        $this->_view->renderizar('index');
    }
    
    public function access($codigo)
    {
        $this->_view->assign("titulo", "Ha habido un error de acceso");
        $this->_view->assign('mensaje',$this->_getError($codigo));
        $this->_view->renderizar('access');   
    }
    
    private function _getError($codigo = false)
    {
        if($codigo){
            
            $codigo = $this->filtrarInt2($codigo);
            
            if(is_int($codigo)){
                $codigo = $codigo;
            }
        }
        else{
            $codigo = 'default';
        }
        
        $error['default'] = "Ha ocurrido un error y la página no puede mostrarse ".$codigo;
        $error['5050'] = "Acceso restringido ".$codigo;
        $error['404'] = "La página no se encuentra :-)";
        $error['403'] = "Caritas ;-) :-) :? )";
        $error['8080'] = "Tiempo de sesión agotado!";
        if(array_key_exists($codigo, $error)){
            return $error[$codigo];
        }
        else{
            return $error['default'];
        }
    }
}
