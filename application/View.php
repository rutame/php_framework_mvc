<?php

/*
 * Copyright (C) 2014 almansor
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

require_once ROOT . 'libs' . DS . 'smarty' . DS . 'libs' . DS . 'Smarty.class.php';

class View extends Smarty{

    private $_request;
    private $_js;
    private $_acl;
    private $_rutas;
    
    public function __construct(Request $peticion, ACL $_acl) {
        parent::__construct();
        $this->_acl = $_acl;
        $this->_request = $peticion;
        $this->_js = array();
        $this->_rutas = array();
        
        $modulo = $this->_request->getModulo();
        $controlador = $this->_request->getControlador();
        
        if($modulo){
            $this->_rutas['view'] = ROOT.'modules'.DS.$modulo.DS.'views'.DS.$controlador.DS;
            $this->_rutas['js'] = BASE_URL . 'modules/' .$modulo . '/views/' . $controlador . '/js/'; 
        }
        else{
            $this->_rutas['view'] = ROOT . 'views' . DS .$controlador . DS;
            $this->_rutas['js'] = BASE_URL . 'views/' . $controlador . '/js/'; 
        }
    }
    
    /**
     * Renderiza la vista, es decir, que crea el archivo que vemos
     * 
     * @param type $vista
     * @param type $item
     * @throws Exception
     * @access public
     */
    public function renderizar($vista, $item = FALSE)
    {
        $this->template_dir = ROOT . 'views' . DS . 'layouts' . DS . DEFAULT_LAYOUT . DS;
        $this->config_dir = ROOT . 'views' . DS . 'layouts'  . DS . DEFAULT_LAYOUT . DS . 'configs'.DS;
        $this->cache_dir = ROOT . 'tmp' . DS . 'cache' . DS;
        $this->compile_dir = ROOT . 'tmp' . DS . 'template' . DS;
        
        $menu = array(
            array(
                'id' => 'inicio',
                'titulo' => 'Ir a Inicio',
                'enlace' => BASE_URL),
            array(
                'id' => 'post',
                'titulo' => 'Ver los Posts',
                'enlace' => BASE_URL . 'post')  
            );
        
        if(Session::get('autentificado')){
            
            array_push( $menu, array(
                                    'id' => 'login',
                                    'titulo' => 'Cerrar Sesión',
                                    'enlace' => BASE_URL . 'login/cerrar'
                                    )
                      );
        }
        else{
            array_push( $menu, array(
                                    'id' => 'login',
                                    'titulo' => 'Iniciar Sesión',
                                    'enlace' => BASE_URL . 'login'
                                    ),
                                array(
                                    'id' => 'registro',
                                    'titulo' => 'Registro de Usuarios',
                                    'enlace' => BASE_URL . 'registro'
                                    )
                        );
        }
        
        $js = array();
        
        if(count($this->_js)): $js = $this->_js;  endif;
        
        $_params = array(
            'ruta_css' => BASE_URL . 'views/layouts/' . DEFAULT_LAYOUT . '/css/',
            'ruta_img' => BASE_URL . 'views/layouts/' . DEFAULT_LAYOUT . '/img/',
            'ruta_js' => BASE_URL . 'views/layouts/' . DEFAULT_LAYOUT . '/js/',
            'menu' => $menu,
            'item' => $item,
            'js' => $js,
            'root' => BASE_URL,
            'configs' => array(
                'app_name'=>APP_NAME,
                'app_slogan'=>APP_SLOGAN,
                'app_company'=>APP_COMPANY )
        );
        
        //var_dump($this->_rutas);
         //       exit();
        
        //$rutaView = ROOT . 'views' . DS . $this->_controlador . DS . $vista . '.tpl';
        
        if(is_readable($this->_rutas['view'] . $vista . '.tpl')){
            $this->assign('_contenido', $this->_rutas['view'] . $vista . '.tpl');
        }
        else{
            throw new Exception('Error de vista');
        }
        
        $this->assign('_acl', $this->_acl);
        $this->assign('_layoutParams', $_params);
        $this->display('template.tpl');
    }
    
    /**
     * Método para cargar los js de cada vista
     * @param array $js
     * @throws Exception 
     * @access public
     */
    public function setJs(array $js)
    {
        if(is_array($js) && count($js)){
            for($i=0; $i < count($js); $i++){
                $this->_js[] = $this->_rutas['js'] . $js[$i] . '.js';
            }
        }
        else{
            throw new Exception('Error de js');
        }
    }
}
