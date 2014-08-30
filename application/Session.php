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
 * basado en los vídeo tutoriales de Cesar Cancino <http://www.cesarcancino.com>
 */

class Session
{
    public static function init()
    {
        session_start();
    }
    
    public static function destroy($clave = false)
    {
        if($clave){
            if(is_array($clave)):
                foreach ($clave as $value) {
                    if(isset($_SESSION[$value])):
                        unset($_SESSION[$value]);
                    endif;
                }
            else:
               if(isset($_SESSION[$clave])){
                        unset($_SESSION[$clave]);
               } 
            endif;
            
        }
        else{
            session_destroy();
        }
    }
    
    public static function set($clave, $valor)
    {
        if(!empty($clave))
        $_SESSION[$clave] = $valor;
    }
    
    // Obtener la clave de session
    public static function get($clave)
    {
        if(isset($_SESSION[$clave]))
            return $_SESSION[$clave];
    }
    
    // Método de acceso
    public static function acceso($level)
    {
        if(!Session::get('autentificado')){
            header('location:' . BASE_URL . 'error/access/5050');
            exit;
        }
        
        Session::tiempo();
        
        if(Session::getLevel($level) > Session::getLevel(Session::get('level'))){
            header('location:' . BASE_URL . 'error/access/5050');
            exit;
        }
    }
    
    public static function accesoView($level)
    {
        if(!Session::get('autentificado')){
            return FALSE;
        }
        
        if(Session::getLevel($level) > Session::getLevel(Session::get('level'))){
            return FALSE;
        }  
        
        return TRUE;
    }
    
    // Colocamos los diferentes niveles de acceso
    public static function getLevel($level)
    {
        $role = array('administrador' => 1,'especial' => 2,'usuario' => 4);
        
        if(!array_key_exists($level, $role)){
            throw new Exception("Error de acceso de Session");
        }
        else{
            return $role[$level];
        }
    }
    
    // Método para dar permisos a grupos de usuarios específicos
    public static function accesoEstricto(array $level, $noAdmin = FALSE)
    {
        if(!Session::get('autentificado')){
            header('location:' . BASE_URL . 'error/access/5050');
            exit;
        }
        
        Session::tiempo();
        
        if($noAdmin == FALSE){
            if(Session::get('level') == 'admin'){
                return;
            }
        }
        
        if(count($level)){
            if(in_array(Session::get('level'),$level)){
                return;
            }
        }
        header('location:' . BASE_URL . 'error/access/5050');
    }
    
    public static function accesoViewEstricto(array $level, $noAdmin = false)
    {
        if(!Session::get('autentificado')){
            return FALSE;
        }
        
        if($noAdmin == FALSE){
            if(Session::get('level') == 'admin'){
                return true;
            }
        }
        
        if(count($level)){
            if(in_array(Session::get('level'),$level)){
                return true;
            }
        }
        return false;  
    }
    
    public static function tiempo()
    {
        if(!Session::get('tiempo') || !defined('SESSION_TIME')){
            throw new Exception("No se ha definido el tiempo de session");
        }
        // Sesion por tiempo indefinido
        if(SESSION_TIME == 0){
            return;
        }
        
        if(time() - Session::get('tiempo') > (SESSION_TIME * 60)){
            Session::destroy();
            header('location:' . BASE_URL . 'error/access/8080');
        }
        else{
            Session::set('tiempo', time());
        }
    }
    
}
