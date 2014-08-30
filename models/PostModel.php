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
class PostModel extends Model{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getPosts()
    {
        try {
            $post = $this->_db->query("SELECT "
                    . "id, titulo, LEFT(cuerpo, 200)AS cuerpo, fechaPub, imagen "
                    . "FROM posts ORDER BY fechapub DESC");
            return $post->fetchAll();   
        } 
        catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    
    /**
     * 
     * @param type $id
     * @return type
     */
    public function getPost($id)
    {
           // try {
            $id = (int)$id;    
                $post = $this->_db->query("SELECT * FROM posts WHERE id = $id ");
                return $post->fetch();
           // } catch (Exception $exc) {
                echo $exc->getTraceAsString();
                echo "No ha podido";
           // }
    }
    
    public function insertarPost($titulo, $cuerpo, $imagen)
    {
        $controlaIndice = "ALTER TABLE `posts` auto_increment = 1";
        $this->_db->prepare("INSERT INTO posts(titulo, cuerpo, imagen) VALUES (:titulo, :cuerpo, :imagen)")
                ->execute(
                        array(
                            ':titulo' => $titulo,
                            ':cuerpo' => $cuerpo,
                            ':imagen' => $imagen
                            )   );
    }
    
    public function editarPost($id, $titulo, $cuerpo)
    {
        $id = (int) $id;
        $this->_db->prepare("UPDATE posts SET titulo = :titulo, cuerpo = :cuerpo WHERE id = :id")
                ->execute(
                        array(
                            ':id' => $id,
                            ':titulo' => $titulo,
                            ':cuerpo' => $cuerpo
                            )
                        );
    }
    
    public function eliminarPost($id)
    {
        $id = (int) $id;
        $this->_db->query("DELETE FROM posts WHERE id = $id ");
    }
}
