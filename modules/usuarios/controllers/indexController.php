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
 * version 0.1
 */

class indexController extends usuariosController
{
    /**
     *
     * @var type _usuarios
     * @access public
     * 
     */
    private $_usuarios;
    
    public function __construct()
    {
        parent::__construct();
        $this->_usuarios = $this->loadModel('index');
    }
    
    /**
     * Asigna los usuarios a usuarios
     * @access public
     */
    public function index()
    {
        $this->_view->assign('titulo', 'Usuarios');
        $this->_view->assign('usuarios', $this->_usuarios->getUsuarios());
        $this->_view->renderizar('index');
    }
    
    /**
     * Hace de todo
     * @access public
     * @author Pedro Gabriel Manrique Gutiérrez <pedrogmanrique at gmail.com>
     */
    public function permisos($usuarioId)
    {
        $id = $this->filtrarInt2($usuarioId);
        
        if(!$id){
            $this->redireccionar('usuarios');
        }
        
        if($this->getInt('guardar') === 1):
            /**
             *  Añadido a un método
             */
            $this->guardar();
        endif;
        
        //var_dump($this->_usuarios->getUsuario($id));
        
        $permisosUsuario = $this->_usuarios->getPermisosUsuario($id);
        $permisosRole = $this->_usuarios->getPermisosRole($id);
        
        if(!$permisosUsuario || !$permisosRole):
            $this->redireccionar('usuarios');
        endif;
        
        $this->_view->assign('titulo', 'Permisos de usuario');
        

        $this->_view->assign('permisos', array_keys($permisosUsuario));
        $this->_view->assign('usuario', $permisosUsuario);
        $this->_view->assign('role', $permisosRole);
        $this->_view->assign('info', $this->_usuarios->getUsuario($id));
        
        $this->_view->renderizar('permisos'); 
        
    }
    
    /**
     * Método llamado desde el método permisos() para cambiar y eliminar permisos
     * @access public
     * @version string
     */
    public function guardar()
    {
        $values = array_keys($_POST);
            $replace = array();
            $eliminar = array();
            
            for($i=0; $i < count($values); $i++){
                if(substr($values[$i], 0, 5)== "perm_"):
                    if($_POST[$values[$i]] == 'x'):
                       $eliminar[] = array(
                           'usuario' => $id, 
                           'permiso' => str_replace("perm_", "", $values[$i]));
                    else:
                        if($_POST[$values[$i]] == 1):
                            $v = 1;
                        else:
                            $v = 0;
                        endif;
                        $replace[] = array(
                            'usuario' => $id, 
                            'permiso' => substr($values[$i], -1), 
                            'valor' => $v);
                    endif;
                endif;
            }
            
            for($i=0; $i < count($eliminar); $i++){
                $this->_usuarios->eliminarPermisoRole($eliminar[$i]['usuario'],
                                                  $eliminar[$i]['permiso']); 
            }
            
            for($i=0; $i<count($replace); $i++){
                $this->_usuarios->editarPermisoRole($replace[$i]['usuario'],
                                                $replace[$i]['permiso'],
                                                $replace[$i]['valor']); 
            }
        
    }
}
