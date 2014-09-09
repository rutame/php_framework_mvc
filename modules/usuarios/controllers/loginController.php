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

class loginController extends Controller
{
    private $_login;
    
    public function __construct()
    {
        parent::__construct();
        $this->_login = $this->loadModel('login');
    }
    
    public function index()
    {
        if(Session::get('autentificado')){
            $this->redireccionar();
        }
        //$this->_view->titulo = "Iniciar Sesión";
        $this->_view->assign('titulo', 'Iniciar Sesión');
        
        if($this->getInt('enviar') == 1):
            $this->_view->assign('datos', $_POST);
        
            if(!$this->getAlphaNum('usuario')){
                $this->_view->assign('_error', "Debe introducir su nombre de usuario!");
                $this->_view->renderizar('index', 'login');
                exit();
            }

            if(!$this->getSql('pass')){
                $this->_view->assign('_error',"Debe introducir su password!");
                $this->_view->renderizar('index', 'login');
                exit();
            }
            $row = $this->_login->getUsuario(//'admin','1234'
                            $this->getAlphaNum('usuario'), 
                            $this->getSql('pass')
                    );
            
            if(!$row){
                $this->_view->assign('_error',"Usuario y/o password incorrectos!");
                $this->_view->renderizar('index','login');
                exit();
            }

            if($row['estado'] != 1){
                $this->_view->assign('_error', "Este usuario no está habilitado!");
                $this->_view->renderizar('index','login');
                exit();
            }
            //var_dump($row);
        
            Session::set('autentificado', true);
            Session::set('level', $row['role']);
            Session::set('usuario', $row['usuario']);
            Session::set('id_usuario', $row['id']);
            Session::set('tiempo', time());
            
            //var_dump($_SESSION);
            $this->redireccionar('post');
        endif;
        
        $this->_view->renderizar('index', 'login');
    }
    
    public function cerrar($param = null)
    {
        Session::destroy();
        $this->redireccionar();
    }
    
    public function llamaValidaEmail($param)
    {
        $this->validarEmail($param);   
    }
    
}
