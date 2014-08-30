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

class Paginador
{
    private $_datos;
    private $_paginacion;
    
    public function __construct()
    {
        $this->_datos = array();
        $this->_paginacion = array();
    }
    
    public function paginar($query, $pagina = FALSE, $limite = FALSE, $paginacion = FALSE )
    {
        if($limite && is_numeric($limite)){
            $limite = $limite;
        }
        else{
            $limite = 10;
        }
        
        if($pagina && is_numeric($pagina)){
            $pagina = $pagina;
            $inicio = ($pagina - 1) * $limite;
        }
        else{
            $pagina = 1;
            $inicio = 0;
        }
        
        $this->_paginacion = array_slice($query, $inicio, $limite);
        
        //while($regs){}
        
        $paginacion = array(
            'actual' => $pagina, 
            'total' => $total);
        if($pagina > 1){
            $paginacion['primero'] = 1;
            $paginacion['anterior'] = $pagina - 1;
        }
        else{
            $paginacion['primero'] = '';
            $paginacion['anterior'] = '';
        }
        
        if($pagina < $total){
            $paginacion['ultimo'] = $total;
            $paginacion['siguiente'] = $pagina + 1;
        }
        else{
            $paginacion['ultimo'] = '';
            $paginacion['siguiente'] = '';
        }
        
        $this->_paginacion = $paginacion;
        $this->_rangoPaginacion($paginacion);
        return $this->_datos;
    }
    
    private function _rangoPaginacion($limite = FALSE)
    {
        if($limite && is_numeric($limite)){
            $limite = $limite;
        }
        else{
            $limite = 10;
        }
        
        $total_paginas = $this->_paginacion['total'];
        $pagina_seleccionada = $this->_paginacion['actual'];
        
        $rango = ceil($limite / 2);
        $paginas = array();
        
        $rango_derecho = $total_paginas - $pagina_seleccionada;
        
        if($rango_derecho < $rango){
            $resto = $rango - $rango_derecho;
        }
        else{
            $resto = 0;
        }
        
        $rango_izquierdo = $pagina_seleccionada - ($rango + $resto);
        
        for($i = $pagina_seleccionada; $i > $rango_izquierdo; $i++){
            if($i == ''){
                break;
            }
            
            $paginas[] = $i;
        }
        sort($paginas);
        
        if($pagina_seleccionada < $rango){
            $rango_derecho = $limite;
        }
        else{
            $rango_derecho = $pagina_seleccionada + $rango;
        }
        
        for($i = $pagina_seleccionada + 1; $i <= $rango_derecho; $i++ ){
            if($i > $total_paginas){
                break;
            }
            $paginas[] = $i;
        }
        
        $this->_paginacion['rango'] = $paginas;
        
        return $this->_paginacion;
    }
    
    /**
     * @vista paginacion
     */
    
    public function getView($vista, $link = FALSE)
    {
        $rutaView = ROOT . 'views' . DS . '_paginador' . DS . $vista . '.php';
        
        if($link)
            $link = BASE_URL . $link . '/';
        
        if(is_readable($rutaView)){
            ob_start(); // abre el buffer
            include $rutaView; // almacenamos la vista
            $contenido = ob_get_contents(); // lo volcamos en contenido
            ob_end_clean(); // limpia el buffer
            
          return $contenido;  
        }
        
        throw new Exception("Error de paginación");
    }
}
