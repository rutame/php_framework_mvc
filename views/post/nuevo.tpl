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
<h3>Nuevo Post</h3>
<form id="form1" action="{$_layoutParams.root}post/nuevo" method="post" enctype="multipart/form-data">
    <input type="hidden" name ="guardar" value="1">
    
    <label for="titulo">Título</label><br />
    <input type="text" name="titulo" value="">
    <br />
    <label for="Imagen">Imagen</label><br />
    <input type="file" name="imagen[]" multiple="multiple">
    <br />
    <label for="cuerpo">Cuerpo</label><br />
    <textarea name="cuerpo">
  
    </textarea><br />
    <input type="submit" value="Guardar" class="btn long">
</form>