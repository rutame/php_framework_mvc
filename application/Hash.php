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

class Hash
{
    // Estático (static) puede ser llamado tanto en los modelos como en los controladores, sin necesidad de instanciar la clase
    // $algoritmo md5, sha1, etc
    // $data es los datos a encriptar, $key es la llave para esa encriptación desencriptación
    public static function getHash($algoritmo, $data, $key)
    {
        $hash = hash_init($algoritmo, HASH_HMAC, $key);
        hash_update($hash, $data);
        
        return hash_final($hash);
        
    //echo crypt("unTexto", HASH_KEY); 

    //password_hash('unTexto', PASSWORD_DEFAULT); algoritmo fuerte pero solo para PHP 5 >= 5.5.0
    }
}
