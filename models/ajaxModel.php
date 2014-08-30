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

class ajaxModel extends Model
{
        
    public function __construct()
    {
        parent::__construct();
    }
    
    public function getPaises()
    {
        $paises = $this->_db->query("SELECT * FROM paises"); 
        $paises->setFetchMode(PDO::FETCH_ASSOC);
        return $paises->fetchAll();
    }
    
    public function getCiudades($pais)
    {
        $ciudades = $this->_db->prepare("SELECT * FROM ciudades WHERE pais = :pais ");
        
        $ciudades->bindParam(':pais', $pais, PDO::PARAM_INT);
        $ciudades->execute();
        
        $ciudades->setFetchMode(PDO::FETCH_ASSOC);
        return $ciudades->fetchAll();
    }
    
    public function insertarCiudad($ciudad, $pais)
    {
        $this->_db->prepare("INSERT INTO ciudades (ciudad, pais) VALUES (:ciudad, :pais ) ")
                ->execute(array(':ciudad'=>$ciudad, ':pais'=>$pais) );
    }
}
