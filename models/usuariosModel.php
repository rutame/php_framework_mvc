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

class usuariosModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Devuelve los usuarios y los roles de usuario coincidentes
     * 
     * @return type array asociativo
     */
    public function getUsuarios()
    {
        $sql = $this->_db->query("SELECT u.*, r.role "
                . "FROM  "
                . "usuarios u, roles r WHERE u.role = r.idrole");
        
        $usuarios = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $usuarios;
    }
    
    /**
     * Devuelve un array asociativo del usuario y role
     * 
     * @param type $usuarioId
     * @return type Description
     * @access public
     */
    public function getUsuario($usuarioId)
    {
        $sql = $this->_db->prepare("SELECT u.usuario, r.role "
                . "FROM "
                . "usuarios u, roles r "
                . "WHERE u.role = r.idrole AND u.id = ? ");
        
                $sql->bindparam(1, $usuarioId, PDO::PARAM_INT);
                $sql->execute();
                
                return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * 
     * @param type $usuarioId
     * @return type Description
     * @access public
     */
    public function getPermisosUsuario($usuarioId)
    {
        $acl = new ACL($usuarioId);
        return $acl->getPermisos();
    }
    
    /**
     * 
     * @param type $usuarioId
     * @return type
     */
    public function getPermisosRole($usuarioId)
    {
        $acl = new ACL($usuarioId);
        return $acl->getPermisosRole(); 
    }
    
    /**
     * 
     * @param type $usuarioId
     * @param type $permisoId
     */
    public function eliminarPermiso($usuarioId, $permisoId)
    {
        $this->_db->prepare("DELETE FROM permisos_usuarios "
                . "WHERE usuario = ? AND permiso = ? ")
                ->execute(array(
                    1 => $usuarioId, 
                    2 => $permisoId));
    }
    
    /**
     * 
     * @param type $usuarioId
     * @param type $permisoId
     * @param type $valor
     */
    public function editarPermiso($usuarioId, $permisoId, $valor)
    {
        $stm = $this->_db->prepare("REPLACE INTO permisos_usuarios "
                . "SET usuario = ?, permiso = ?, valor = ? ");
        $stm->bindParam(1, $usuarioId);
        $stm->bindParam(2, $permisoId);
        $stm->bindParam(1, $valor, PDO::PARAM_INT);
        
        $stm->execute();
    }
    
}
