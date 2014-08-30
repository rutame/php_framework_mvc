{* 
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
 *}

<h2>Darte de alta como usuario</h2>
<form name="form1" method="post" action="" id="form1" class="form">
    <input type="hidden" value="1" name ="enviar">
    <br />
    <label for="Nombre">Nombre</label>
    <input type="text" name="nombre" class="entrada" placeholder="Introduce el nombre" 
           value="{if isset($datos.nombre)}{$datos.nombre}{/if}">
    <br />
    
    <label for="Usuario">Usuario </label>{if isset($datos.error)}{$datos.error}{/if}
    <input type="text" name="usuario" class="entrada" placeholder="Introduce el usuario"
           value="{if isset($datos.usuario)}{$datos.usuario}{/if}">
    <br />
    <label for="Email">Email</label>
    <input type="email" name="email" class="entrada" placeholder="example@dom.dom"
           value="{if isset($datos.email)}{$datos.email}{/if}">
    <br />
    <label for="Password o Contraseña">Password</label>
    <input type="password" name="pass" class="entrada">
    <br />
    <label for="Password o Contraseña">Confirmar Password</label>
    <input type="password" name="confirmar" class="entrada">
    <br />

    <input type="submit" value="Enviar" class="btn long">

</form>