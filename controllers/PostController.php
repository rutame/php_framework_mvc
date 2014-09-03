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

class PostController extends Controller
{
    private $_post;
    private $_titulo;
    private $_cuerpo;
    
    public function __construct()
    {
        parent::__construct();
        $this->_post = $this->loadModel('post');
    }
    
    /**
     * llama al index
     */
    public function index()
    {
        //$this->getLibrary('paginador');
        //$paginador = new Paginador();
        //$post = $this->loadModel('post');
        
        //$this->_view->posts = $post->getPosts();
        $this->_view->assign('posts', $this->_post->getPosts());
        //$this->_view->posts = $this->_post->getPosts();
        //$this->_view->assign('posts', $paginador->paginar($this->_post->getPosts(), $pagina));
        //$this->_view->titulo = "Todos los Posts";
        $this->_view->assign('titulo', 'Todos los posts');
        $this->_view->renderizar('index','post');
    }
    
    /**
     * Añadir un nuevo post
     * 
     * @access public
     */
    
    public function nuevo()
    {
        //Session::accesoEstricto(array('especial',false));
        //$this->_acl->acceso('nuevo_post');
        
        $this->_view->assign('titulo' ,"Nuevo Post");
        
        $this->_view->setJs(array('nuevo'));
        //$this->_view->valorGuardar = $this->getInt('guardar');
        //$this->_view->sacaTitulo = $this->getTexto('titulo');
        if($this->getInt('guardar') == 1)
        {
            $this->_view->assign('datos', $_POST);
            if(!$this->getTexto('titulo')){
                $this->_view->assign('_error', "Debe Introducir el título del post");
                $this->_view->renderizar('nuevo','post');      exit;
            }
            
            if(!$this->getTexto('cuerpo')){
                $this->_view->assign('_error',"Debe Introducir el cuerpo del post");
                $this->_view->renderizar('nuevo','post');      exit;
            }
            
            $imagen = "no hay";
            
            
            if(!empty($_FILES['imagen']['name'])){

                    //$imagen = $this->subeImagen($_FILES['imagen']['name']);
                
                $this->getLibrary('upload' . DS . 'class.upload');
                $ruta = ROOT . 'public' . DS . 'img' . DS . 'post' . DS;
                
                        $files = array();
                        foreach ($_FILES['imagen'] as $k => $l) {
                         foreach ($l as $i => $v) {
                         if (!array_key_exists($i, $files))
                           $files[$i] = array();
                           $files[$i][$k] = $v;
                         }
                        } 
                        foreach ($files as $file) {

                $upload = new upload($file);
                $upload->allowed = array('image/*');
                $upload->file_new_name_body = 'upl_' . uniqid();
                $upload->process($ruta);

                    if($upload->processed){
                    $imagen = $upload->file_dst_name;
                    $thumb = new upload($upload->file_dst_pathname);
                    $thumb->image_resize = true;
                    //$thumb->image_x = 160; $thumb->image_y = 90;
                    $thumb->image_ratio_crop = 200;
                    $thumb->file_name_body_pre = 'thumb_';
                    $thumb->process($ruta . 'thumb' . DS);
                    
                    }
 
                }
            }

            $this->_post->insertarPost(
                                        $this->getPostParam('titulo'),
                                        $this->getPostParam('cuerpo'),
                                        $imagen 
                                    );
            $this->redireccionar('post');
        }
        $this->_view->renderizar('nuevo','post');
    }
    
    /**
     * Upload una imagen y la procesa para cerar miniatura
     * 
     * @param type $imagen
     * @return type
     */
    public function subeImagen($imagen)
    {
        $this->getLibrary('upload' . DS . 'class.upload');
        $ruta = ROOT . 'public' . DS . 'img' . DS . 'post' . DS;
        $upload = new upload($_FILES['imagen']);
        $upload->allowed = array('image/*');
        $upload->file_new_name_body = 'upl_' . uniqid();
        $upload->process($ruta);

        if($upload->processed){
            $imagen = $upload->file_dst_name;
            $thumb = new upload($upload->file_dst_pathname);
            $thumb->image_resize = true;
            //$thumb->image_x = 160; $thumb->image_y = 90;
            $thumb->image_ratio_crop = 200;
            $thumb->file_name_body_pre = 'thumb_';
            $thumb->process($ruta . 'thumb' . DS);
            return $imagen;
        }
        else{
            $this->_view->assign('_error' ,"La imagen no ha subido " . $upload->error);
            $this->_view->renderizar('nuevo','post');
            exit;  
        }
        
        
    }
    
    /**
     * Ver el detalle de un post en concreto
     * 
     * @param type $id
     */
    public function ver($id)
    {   
        if(isset($id)):
        $titulo = $this->_post->getPost($this->sacaId($id));
        $this->_view->assign('post', $this->_post->getPost($this->sacaId($id)));
        $this->_view->assign('titulo', $titulo['titulo']);
        
        $this->_view->renderizar("ver","post");
        else:
        
        $this->_view->errorId = $id . "Error con el id";
        $this->_view->renderizar("ver","post");
        endif;
        
    }
    
    /**
     * Editar un post
     * 
     * @param type $id
     */
    public function editar($id)
    {
        //Session::accesoViewEstricto('Administrador');
        if(!$this->sacaId($id)){
            $this->redireccionar('post');
        }
        // verificar que existe el registro
        if(!$this->_post->getPost($this->sacaId($id))){
            $this->redireccionar('post');
        } 
        // existe
        $this->_view->assign('titulo', "Editar Post ".  $this->sacaId($id));
        $this->_view->setJs(array('nuevo'));
        
        if($this->getInt('guardar') == 1)
        {
            $this->actualizaPost($id,  $this->getPostParam('titulo'),  $this->getPostParam('cuerpo'));
        }
        $this->_view->assign('datos', $this->_post->getPost($this->sacaId($id)));
        $this->_view->renderizar('editar','post');
    }
    
    public function actualizaPost($id, $titulo, $cuerpo)
    {
        //$this->_view->datos = $_POST;

        if(!$this->getTexto('titulo')){
            $this->_view->assign('_error', "Debe Introducir el título del post");
            $this->_view->renderizar('editar','post');
            
            exit;
        }

        if(!$this->getTexto('cuerpo')){
            $this->_view->_error = "Debe Introducir el cuerpo del post";
            $this->_view->renderizar('editar','post');
            exit;
        }

        $this->_post->editarPost($this->sacaId($id),
                                    $this->getPostParam('titulo'),
                                    $this->getPostParam('cuerpo') );

        $this->redireccionar('post');        
    }
    
    public function eliminar($id)
    {
        Session::acceso('admin');
        if(!$this->sacaId($id)){
            $this->redireccionar('post');
        }
        if(!$this->_post->getPost($this->sacaId($id))){
            $this->redireccionar('post');
        }
        $this->_post->eliminarPost($this->sacaId($id));
        $this->redireccionar('post');
        
    }

}
