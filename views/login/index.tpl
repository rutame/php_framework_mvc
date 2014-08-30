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
 */
*}
<h2>Iniciar Sesión</h2>
<form name="form1" method="post" action="" id="form1" class="form">
    <input type="hidden" value="1" name ="enviar">
    <br />
    <label for="Usuario">Usuario:</label>
    <input type="text" name="usuario" class="entrada" 
           value="{*if isset($datos.usuario)}{$datos.usuario}{/if *}">
    <br />
    <label for="Password o Contraseña">Password:</label>
    <input type="password" name="pass" class="entrada">
    <br />
    <input type="submit" value="Enviar" class="btn long">
    <a href="">¿Olvidaste la clave? !Enviar una nueva!</a>
</form>