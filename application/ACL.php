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
 * @Control de permisos de usuarios
 */
class ACL
{
    /**
     * @var type Description
     * @var type 
     */
    private $_db;
    private $_id;
    private $_role;
    private $_permisos;
    
    /**
     * 
     * @param type $id
     */
    public function __construct($id = false)
    {
        if($id){
            $this->_id = (int) $id;
        }
        else{
            if(Session::get('id_usuario')){
                $this->_id = Session::get('id_usuario');  
            }
            else{
                $this->_id = 0;   
            }
        }
        
        $this->_db = new Database();
        $this->_role = $this->getRole();
        $this->_permisos = $this->getPermisosRole();
        $this->compilarAcl();
    }
    
    public function compilarAcl()
    {
        $this->_permisos = array_merge(
                    $this->_permisos,
                    $this->getPermisosUsuario()
                );
    }
    
    public function getRole()
    {
        $id = $this->_id;
        $role = $this->_db->query(
                "SELECT role FROM usuarios WHERE id = '{$this->_id}' ");
                $role = $role->fetch();
                return $role['role'];
    }
    
    public function getPermisosRoleId()
    {
       $sql = $this->_db->query(
               "SELECT permiso FROM permisos_roles WHERE role = '{$this->_role}' ");
       
             $ids = $sql->fetchAll(PDO::FETCH_ASSOC);
             
             for($i = 0; $i < count($ids); $i++){
                 $id[] = $ids[$i]['permiso'];
             }
             if(!empty($id)):
                 $id = $id;
             else:
                 $id = 0;
             endif; 
             
             return $id;
    }
    
    public function getPermisosRole()
    {
        $sth = $this->_db->query("SELECT * FROM permisos_roles WHERE role = '{$this->_role}' ");
        //$sth->bindParam(':role', $this->_role);
        //$sth->execute();
        
        $permisos = $sth->fetchAll(PDO::FETCH_ASSOC);
        $data = array();
        
        for($i = 0; $i < count($permisos); $i++){
            $key = $this->getPermisoKey($permisos[$i]['permiso']);
            if($key == ''){continue;}
            if($permisos[$i]['valor'] == 1){   $v = true;   }
            else{         $v = false;        }
            $data[$key] = array(
                'key' => $key,
                'permiso' => $this->getPermisoNombre($permisos[$i]['permiso']),
                'valor' => $v,
                'heredado' => FALSE,
                'id' => $permisos[$i]['permiso']
            );
        }
        
        return $data;
    }
    
    /**
     * 
     * @param type $permisoId
     * @return type
     */
    public function getPermisoKey($permisoId)
    {
        $permisoId = (int) $permisoId;
        
        $key = $this->_db->query("SELECT `key` FROM permisos WHERE idpermiso = '$permisoId' ");
        
        $key = $key->fetch();
        
        return $key['key'];
    }
    
    public function getPermisoNombre($permisoId)
    {
        $permisoId = (int) $permisoId;
        
        $key = $this->_db->query("SELECT permiso FROM permisos WHERE idpermiso = $permisoId ");
        
        $key = $key->fetch();
        
        return $key['permiso'];
    }
    
    public function getPermisosUsuario()
    {
        $ids = $this->getPermisosRoleId();
        
        if(!empty($ids)):
        $permisos = $this->_db->query(
                "SELECT * FROM permisos_usuarios WHERE "
                . "usuario = '{$this->_id}' "
                . " AND permiso IN (". implode(",", $ids) . ")"
                        );
                
        $permisos = $permisos->fetchAll(PDO::FETCH_ASSOC);
        else:
            $permisos = array();
        endif;
        
        $data = array();
        
        for($i = 0; $i < count($permisos); $i++){
            $key = $this->getPermisoKey($permisos[$i]['permiso']);
            if($key == ''){continue;}
            if($permisos[$i]['valor'] == 1){
                $v = true;
            }
            else{
                $v = false;
            }
            $data[$key] = array(
                'key' => $key,
                'permiso' => $this->getPermisoNombre($permisos[$i]['permiso']),
                'valor' => $v,
                'heredado' => true,
                'id' => $permisos[$i]['permiso']
            );
        }
        
        return $data;
    }
    
    public function getPermisos()
    {
        if(isset($this->_permisos) && count($this->_permisos)){
            return $this->_permisos;
        }
    }
    
    public function permiso($key)
    {
        if(array_key_exists($key, $this->_permisos)){
            if($this->_permisos[$key]['valor'] == true || $this->_permisos[$key]['valor'] == 1 ){
                return true;
            }
        }
        return false;
    }
    
    /**
     * 
     * @param type $key
     * @return type
     */
    public function acceso($key)
    {
        Session::tiempo();
        
        if($this->permiso($key)){
            Session::tiempo();
            return;
        }
        
        \header("location:" . BASE_URL . "error/access/5050");
        exit();
    }
}
