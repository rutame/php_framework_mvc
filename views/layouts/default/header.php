<!DOCTYPE html>
<!--
Copyright (C) 2014 Pedro Gabriel Manrique Gutiérrez <pedrogmanrique at gmail.com>

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $this->titulo; ?></title>
        <link rel="stylesheet" href="<?php echo $_layoutParams['ruta_css'];?>estilo_basico.css" />
        <meta name="author" content="<?php echo APP_COMPANY; ?>" />
        <script src="<?php echo BASE_URL;?>public/js/jquery.js"></script>
        <script src="<?php echo BASE_URL;?>public/js/jquery.validate.js"></script>
        <?php if(isset($_layoutParams['js']) && count($_layoutParams['js'])): ?>
        <?php for($i = 0 ; $i < count($_layoutParams['js']); $i++): ?>
            <script src="<?php echo $_layoutParams['js'][$i];?>"></script>
        <?php endfor; ?>
        <?php endif; ?>
    </head>
    <body>
        <header class="top">
            <nav id="top">
                <ul class="visible">
                    <li> Menú
                        <ul class="menu">
                            <?php if (isset($_layoutParams['menu'])): ?>
                                <?php for ($i = 0; $i < count($_layoutParams['menu']); $i++): ?>
                                    <li>
                                        <a href="<?php echo $_layoutParams['menu'][$i]['enlace']; ?>">
                                            <?php echo $_layoutParams['menu'][$i]['titulo']; ?>   
                                        </a>
                                    </li>
                                <?php endfor; ?>
                            <?php endif; ?>
                        </ul>
                    </li>
                </ul>
            </nav>
            <hgroup>
                <h1 class="logotipo"><?php echo APP_NAME; ?></h1> 
                <h3><?php echo APP_SLOGAN; ?></h3>
            </hgroup>     
        </header>
        <div id="contenido">
            <noscript><p>Para el correcto funcionamiento debes tener el soporte de JavaScript habilitado</p></noscript>
            <?php if (isset($this->_error)){ echo '<div id="error">' . $this->_error .'</div>';} ?>
            <?php if (isset($this->_mensaje)){ echo '<div id="mensaje">'. $this->_mensaje .'</div>';} ?>

            
        
