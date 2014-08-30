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

class AclModel extends Model
{
    public function __construct()
    {
        parent::__construct();   
    }
    
    /**
     * 
     * @param type $roleId
     */
     
    public function getRole($roleId)
    {
      $role = $this->_db->query("select * from roles where idrole = '$roleId' ");
      return $role->fetch();
    }
    
    /**
     * 
     * @return type array
     */
    public function getRoles()
    {
        $role = $this->_db->query("select * from roles ");
        return $role->fetchAll();   
    }
    
    /**
     * 
     * @return array
     */
    public function getPermisosAll()
    {
      $sql = $this->_db->query("select * from permisos ");
      $permisos = $sql->fetchAll(PDO::FETCH_ASSOC);  
      
      for($i = 0; $i < count($permisos); $i++):
          if($permisos[$i]['key'] == ''){continue;}
          
          $data[$permisos[$i]['key']] = array(
              'key' => $permisos[$i]['key'], 
              'valor' => 'x', 
              'nombre' => $permisos[$i]['permiso'],
              'id' => $permisos[$i]['idpermiso']);
      endfor;
      
      return $data;
    }
    
    
    /**
     * Selecciona los permisos para un determinado Rol
     * @param type $roleId
     * @return type
     */
    public function getPermisosRole($roleId)
    {
        $data = array();
        
        $sql = $this->_db->query("SELECT * FROM permisos_roles WHERE role = $roleId ");
        $permisos = $sql->fetchAll(PDO::FETCH_ASSOC);  

        for($i = 0; $i < count($permisos); $i++):

            $key = $this->getPermisoKey($permisos[$i]['permiso']);

            if($key == ''){continue;}
            
            if($permisos[$i]['valor'] == 1):
                $v = 1;
            else:
                $v = 0;
            endif;
            
            $data[$key] = array(
                                'key' => $key, 
                                'valor' => $v, 
                                'nombre' =>  $this->getPermisoNombre($permisos[$i]['permiso']),
                                'id' => $permisos[$i]['permiso']
                            );
        endfor;
        
        $data = array_merge($this->getPermisosAll(), $data);
        
        return $data;  
    }
    
    
    /**
     * Eliminar permiso de un Rol
     * @param type $roleId
     * @param type $permisoId
     */
    public function eliminarPermisoRole($roleId, $permisoId)
    {
        $this->_db->query("DELETE FROM permisos_roles "
                . "WHERE role = $roleId and permiso = $permisoId") ;  
    }
    
    /**
     * 
     * @param type $roleId
     * @param type $permisoId
     * @param type $valor
     */
    public function editarPermisoRole($roleId, $permisoId, $valor)
    {
        $this->_db->query("REPLACE INTO permisos_roles "
                . "SET role = $roleId, permiso = $permisoId, valor = $valor ");   
    }
    
    /**
     * Obtiene la clave del permiso
     * 
     * @param type $permisoId
     * @return type
     */
    public function getPermisoKey($permisoId)
    {
        $permisoId = (int) $permisoId;
        
        $key = $this->_db->query("SELECT `key` FROM permisos WHERE idpermiso = $permisoId ");
        
        $key = $key->fetch();
        
        return $key['key'];
    }
    
    /**
     * Obtiene el nombre de ese permiso
     * 
     * @param type $permisoId
     * @return type
     */
    public function getPermisoNombre($permisoId)
    {
        $permisoId = (int) $permisoId;
        
        $key = $this->_db->query("SELECT permiso FROM permisos WHERE idpermiso = '$permisoId' ");
        
        $key = $key->fetch();
        
        return $key['permiso'];
    }
}
