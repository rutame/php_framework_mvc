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

/**
 * Modificada para ser modular
 * version 0.1a

 * @abstract
 * @access public
 * @version string
 */
abstract class Controller 
{
    //Esta clase es abstracta para que no pueda ser instanciada.
    /**
     * Atributos
     * @var type 
     */
    protected $_view;
    protected $_acl;
    protected $_request;


    public function __construct() {
        $this->_acl = new ACL();
        $this->_request = new Request();
        $this->_view = new View($this->_request, $this->_acl);
    }

    // Este método abstracto obliga a que todas las clases que heredan de controller 
    // implemente un método index por obligación aunque no tenga código
    abstract public function index();
    
    /**
     * Importa los modelos
     * @version string
     */
    protected function loadModel($modelo, $modulo = FALSE)
    {
        $modelo = $modelo . 'Model';
        $rutaModelo = ROOT . 'models' . DS . $modelo . '.php';
        
        // Usar módulo o controlador
        if(!$modulo){
            $modulo = $this->_request->getModulo();
        }
        
        if($modulo){
            if($modulo != 'default'){
               $rutaModelo = ROOT.'modules'.DS.$modulo.DS.'models'.DS.$modelo.'.php'; 
            }
        }
        
        if(is_readable($rutaModelo)){
            require_once $rutaModelo;
            $modelo = new $modelo;
            return $modelo;
        }
        else{
            throw new Exception('Error del modelo');
        }
        
    }
    
    /**
     * 
     * @param type $libreria
     * @throws Exception Método para cargar librerias
     */
    protected function getLibrary($libreria)
    {
        $rutaLiberia = ROOT . 'libs' . DS . $libreria . '.php';
        
        if(is_readable($rutaLiberia))
        {
            require_once $rutaLiberia;
        }
        else
        {
            throw new Exception("Error de librería");
        }
    }
    
    /**
     * 
     * @param type $clave
     * @return string Toma la variable, la filtra y la retorna filtrada
     */
    protected function getTexto($clave) 
    {
        if(isset($_POST[$clave]) && !empty($_POST[$clave])){
            $_POST[$clave] = htmlspecialchars($_POST[$clave], ENT_QUOTES);
            return $_POST[$clave];
        }
        return '';
    }
    
    protected function getInt($clave)
    {
        if(isset($_POST[$clave]) && !empty($_POST[$clave])){
            $clave = filter_input(INPUT_POST, $clave, FILTER_VALIDATE_INT);
            return $clave;
        }
        return 0;
    }
    
   /**
    * 
    * @param type $int
    * @return int Este método es el que viene en el vídeo tutorial, pero no funciona correctamente 
    */
    protected function filtrarInt($int)
    {
        $int = (int) $int;
        
        if(is_int($int)){
            return $int;
        }
        else{
            return 0;
        }
    } 
    
    /**
     * 
     * @param type $int
     * @return type Este método sí que funciona bien
     */
    protected function filtrarInt2($int)
    {
        foreach ($int as $value) {
            $entero = (int) $value;
        }
        return $entero;
    }
    
    /**
     * 
     * @param type $ruta
     */
    protected function redireccionar($ruta = false)
    {
        if($ruta){
            header('location:' . BASE_URL .$ruta);
            exit;
        }
        else{
            header('location:' . BASE_URL);
            exit;
        }
    }
    
    /**
     * @access public
     * @param type $id
     * @return type
     */
    protected function sacaId($id)
    {
        foreach ($id as $value) {
            $idint = (int)$value;
        }
        return $idint;
    }
    
    /**
     * 
     * @param type $clave
     * @return type
     */
    protected function getPostParam($clave)
    {
        if(isset($_POST[$clave])):
            return $_POST[$clave];
        endif;
    }
 
    /** 
     * 
     * @param type $clave
     * @return type
     * Sanitizar los parámetros
     */
    protected function getSql($clave)
    {
        if(isset($_POST[$clave]) && !empty($_POST[$clave])){ 
            
            $_POST[$clave] = strip_tags($_POST[$clave]);
            //$_POST[$clave] = (string) preg_replace('/[^A-Z]{3,250}/i', '',$_POST[$clave]);
        
            if(!get_magic_quotes_gpc()){
                $_POST[$clave] = $_POST[$clave];
            }
            
            return trim($_POST[$clave]);

        } 
    }
    
    /** 
     * 
     * @param type $clave
     * @return type
     * Limpiar y forzar para que el nombre de usuario Empiece por letra y pueda tener numeros y guiones
     */
    protected function getAlphaNum($clave)
    {
        if(isset($_POST[$clave]) && !empty($_POST[$clave])){
            
            $_POST[$clave] = (string) preg_replace('/[^A-Z0-9_]/i', '',$_POST[$clave]);
            
            return trim($_POST[$clave]);

        }
    }
    
    /**
     * Comprueba si el email tiene un formato válido
     */
    public function validarEmail($email)
    {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            return false;
        }
        return true;
    }
}
