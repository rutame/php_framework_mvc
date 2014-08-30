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
$(document).ready(function(){
    
    var idPais = $('#pais').val();
    var nombreCiudad = $("#ins_ciudad").val();
    
    function getLasCiudades()
    {   var idPais = $('#pais').val();
        $.post('/aprendomvc/ajax/getCiudades','pais=' + idPais, function(datos){
        $('#ciudad').html('');

             for(var i = 0; i < datos.length; i++){
                 $('#ciudad').append('<option value="' + datos[i].id + '">' + datos[i].ciudad + '</option>');
             }

        }, 'json'); 
    }; 
   
    $("#pais").change(function()
    {
          //if(!$('#pais').val()){
              //$('#ciudad').html('');
            //}
            //else{
                getLasCiudades();
           // }
    });
    
    $("#btn_insertar").click(function(){
        var idPais = $('#pais').val();
        var nombreCiudad = $("#ins_ciudad").val();
        $.post("/aprendomvc/ajax/insertarCiudad", "pais=" + idPais + "&ciudad=" + nombreCiudad);
        $("#ins_ciudad").val("");
        getLasCiudades();
    });
   
});


