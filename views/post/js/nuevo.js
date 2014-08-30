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
// bassistance es el validador de jquery (bassistance.de)
    $(document).ready(function()
    {
        $('#form1').validate({
            rules:{ titulo:{required:true}, cuerpo:{required: true}  },
            messages:{
                    titulo:{ required: "Debe introducir el titulo del post" },
                    cuerpo:{ required: "Debe introducir el cuerpo del post" }
                    }
                            });
    }
                    );



