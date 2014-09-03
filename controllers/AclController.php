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

class AclController extends Controller
{
    /**
     *
     * @var type string
     */
    private $_aclm;
    
    public function __construct()
    {
        parent::__construct(); 
        $this->_aclm = $this->loadModel('acl');
    }
    
    public function index()
    {
        $this->_view->assign('titulo', 'Listas de acceso');
        $this->_view->renderizar('index');
    }
    
    public function roles()
    {
        $this->_view->assign('titulo', 'Administración de roles');
        $this->_view->assign('roles', $this->_aclm->getRoles());
        $this->_view->renderizar('roles');   
    }
    
    public function permisos_role($roleId)
    {
        $id = $this->filtrarInt2($roleId);
        
        if(!$id):
            $this->redireccionar('acl/roles');
        endif;
        
        $row = $this->_aclm->getRole($id);
        
        if(!$row):
            $this->redireccionar('acl/roles');
        endif;
        
        $this->_view->assign('titulo', 'Administración de permisos de role');
        
        if($this->getInt('guardar') === 1):
            $values = array_keys($_POST);
            $replace = array();
            $eliminar = array();
            
            for($i=0; $i < count($values); $i++){
                if(substr($values[$i], 0, 5)== "perm_"):
                    if($_POST[$values[$i]] == 'x'):
                       $eliminar[] = array('role' => $id, 
                           'permiso' => str_replace('perm_',"", $values[$i]));
                    else:
                        if($_POST[$values[$i]] == 1):
                            $v = 1;
                        else:
                            $v = 0;
                        endif;
                        $replace[] = array('role' => $id, 
                            'permiso' => substr($values[$i], -1), 
                            'valor' => $v);
                    endif;
                endif;
            }
            
            for($i=0; $i < count($eliminar); $i++){
                $this->_aclm->eliminarPermisoRole($eliminar[$i]['role'],
                                                  $eliminar[$i]['permiso']); 
            }
            
            for($i=0; $i<count($replace); $i++){
                $this->_aclm->editarPermisoRole($replace[$i]['role'],
                                                $replace[$i]['permiso'],
                                                $replace[$i]['valor']); 
            }
        endif;
        
        $this->_view->assign('role', $row);
        $this->_view->assign('permisos', $this->_aclm->getPermisosRole($id));
        $this->_view->renderizar('permisos_role'); 
    }
 
}
