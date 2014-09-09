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

class registroController extends Controller
{
    private $_registro;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->_registro = $this->loadModel('registro');
    }
    
    public function index()
    {
        if(Session::get('autentificado')){
            $this->redireccionar();
        }
        
        $this->_view->assign("titulo","Registro de Usuarios");
        
        if($this->getInt('enviar') == 1){
            $this->_view->assign('datos', $_POST);
            
            if(!$this->getSql('nombre')){
                $this->_view->assign('_error',"Debe introducir el nombre");
                $this->_view->renderizar('index', 'registro'); 
                exit();
            }
            
            if(!$this->getAlphaNum('usuario')){
                $this->_view->assign('_error', "Debe introducir el nombre de usuario");
                $this->_view->renderizar('index', 'registro'); 
                exit;  
            }
            /**
             * 
             */
            if($this->_registro->verificarUsuario($this->getAlphaNum('usuario'))){
                $this->_view->assign('_error', "¡Ya existe el usuario " . $this->getAlphaNum('usuario') ."!");
                $this->_view->renderizar('index', 'registro');
                exit;
            }
            
            if($this->_registro->verificarEmail('email')){
                $this->_view->assign('_error', "Esa dirección de email ya existe");
                $this->_view->renderizar('index', 'registro');
                exit();
            }
            
            if(!$this->validarEmail($this->getPostParam('email'))){
                $this->_view->assign('_error', "¡Dirección de email incorrecta!");
                $this->_view->renderizar('index', 'registro');
                exit();
            }
            
            if(!$this->getAlphaNum('pass')){
                $this->_view->assign('_error' , "Debe introducir la contraseña");
                $this->_view->renderizar('index', 'registro');  
                exit();
            }
            
            if($this->getPostParam('pass') != $this->getPostParam('confirmar') ){
                $this->_view->assign('_error', "Las contraseñas no coinciden");
                $this->_view->renderizar('index', 'registro'); 
                exit();
            }
            
            $this->getLibrary('class.phpmailer');
                $mail = new PHPMailer();
                    
            $this->_registro->registrarUsuario(
                    $this->getSql('nombre'), 
                    $this->getAlphaNum('usuario'),
                    $this->getPostParam('pass'),
                    $this->getAlphaNum('usuario')
                    );
            $usuario = $this->_registro->verificarUsuario($this->getAlphaNum('usuario'));
            
            if(!$usuario){
                $this->_view->assign('_error', "Error al registrar el usuario");
                $this->_view->renderizar('index', 'registro');
                exit();
            }
            $mail->From = "pedrog.grafycomp.com";
            $mail->FromName = "pedrog";
            $mail->Subject = "Activación de cuenta de usuario";
            $mail->Body = 'Hola <strong>' . $this->getSql('nombre') . '</strong>'.
                    '<p>Se ha registrado en ' . BASE_URL . 
                    'para activar la cuenta haga click sobre el siguiente '.
                    'enlace <a href=" ' . BASE_URL . 
                    'registro/activar/' .$usuario['id'] .'/'. $usuario['codigo'].
                    '"> activar </a>';
            
            $mail->AltBody = "Su servidor no soporta HTML";
            $mail->addAddress($this->getPostParam('email'));
            $mail->send();
            
            $this->_view->assign('datos', false);        
            $this->_view->assign('_mensaje', "Registro compleatado, revise su email para activar su cuenta");
            
        }
        $this->_view->renderizar('index', 'registro');
    }
    
    public function activar($id, $codigo)
    {
        if($this->filtrarInt($id) || !$this->filtrarInt($codigo)){
            $this->_view->assign('error', "Esta cuenta no existe");
            $this->_view->renderizar('activar', 'registro');
            exit();
        }
        
        $row = $this->_registro->getUsuario(
                $this->filtrarInt2($id),
                $this->filtrarInt2($codigo)
                );
        
        if(!$row){
            $this->_view->error = "Esta cuenta no existe";
            $this->_view->renderizar('activar', 'registro');
            exit();
        }
        
        if(!$row['estado'] == 1){
            $this->_view->error = "Esta cuenta ya ha sido activada";
            $this->_view->renderizar('activar', 'registro');
            exit();
        }
        
        $this->_registro->activarUsuario($this->filtrarInt($id),  $this->filtrarInt($codigo));
        
        if(!$row['estado'] == 0){
            $this->_view->error = "Error al activar la cuenta, por favor intentelo más tarde.";
            $this->_view->renderizar('activar', 'registro');
            exit();
        }
        
        $this->_view->_mensaje = "Su cuenta ha sido activada";
        $this->_view->renderizar('activar', 'registro');
                
    }

}

