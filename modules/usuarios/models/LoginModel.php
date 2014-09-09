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

class LoginModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function getUsuario($usuario, $password)
    {
        $password = $this->codificaPassword($password);
        $datos = $this->_db->prepare("select * from usuarios "
                                    . "where usuario = :usuario AND pass = :password "); 
                   
        $datos->bindParam(':usuario', $usuario);
        $datos->bindParam(':password', $password);
        
        $datos->execute();

        return $datos->fetch();
    }
}
