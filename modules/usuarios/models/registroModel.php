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

class registroModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }
    
 
    /**
     * Método que comprueba si existe ese nombre de usuario
     * 
     * @param type $usuario
     * @return type 
     */
    public function verificarUsuario($usuario)
    {
        $id = $this->_db->prepare(
                "SELECT id, codigo FROM usuarios WHERE usuario = ':usuario' ");
        $id->bindParam(':usuario', $usuario);
        $id->execute();
        
        return $id->fetch();
    }
    
    // Comprueba si existe ese email 
    public function verificarEmail($email)
    {
        $id = $this->_db->prepare("SELECT id FROM usuarios WHERE email = ':email' ");
        $id->bindParam(':email', $email);
        $id->execute();
        
        if($id->fetch()){
            return true;
        }
        
        return FALSE;
    }
    /**
     * 
     * @param type $nombre
     * @param type $usuario
     * @param type $password
     * @param type $email
     * @param type $role
     */
    public function registrarUsuario($nombre, $usuario, $password, $email, $role = false)
    {
        $password = $this->codificaPassword($password);
        
        if(!isset($role)): $role = 'usuario'; else: $role = $role; endif;
        
        $random = rand(1111111111, 9999999999);
        
        $this->_db->prepare("INSERT INTO usuarios (nombre,usuario,pass,email,role,estado,codigo)"
                . "VALUES(:nombre,:usuario,:pass,:email,:role,:estado,:codigo )")
                ->execute(array(
                    ':nombre' => $nombre,
                    ':usuario' => $usuario,
                    ':pass'=> $password,
                    ':email' => $email,
                    ':role' => $role,
                    ':estado' => 0,
                    ':codigo' => $random
                     ));
    }
    
    public function getUsuario($id, $codigo)
    {
        $usuario = $this->_db->prepare(
                "SELECT * FROM usuarios WHERE id = :id AND codigo = :codigo")
        ->execute(array(
            ':id' => $id,
            ':codigo' => $codigo
        ));
        return $usuario->fetch();
    }
    
    public function activarUsuario($id, $codigo)
    {
        $this->_db->prepare(
                "UPDATE usuarios SET estado = 1 WHERE id = :id AND codigo = :codigo ")
                ->execute(array(
                    ':id' => $id,
                    ':codigo' => $codigo 
                ));
    }
}
