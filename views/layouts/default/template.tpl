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
        <title>{$titulo|Default:"Sin Título"}</title>
        <link rel="stylesheet" href="{$_layoutParams.ruta_css}estilo_basico.css" />
        <meta name="author" content="<?php echo APP_COMPANY; ?>" />
        <script src="{$_layoutParams.root}public/js/jquery.js"></script>
        <script src="{$_layoutParams.root}public/js/jquery.validate.js"></script>
        
        {if isset($_layoutParams.js) && count($_layoutParams.js)}
            {foreach item=js from=$_layoutParams.js}
                <script src="{$js}" type="text/javascript"></script>
            {/foreach}
        {/if}
    </head>
    <body>
        <header class="top">
            <nav id="top">
                <ul class="visible">
                    <li> Menú
                        <ul class="menu">
                            {if isset($_layoutParams.menu)}
                                {foreach item=it from=$_layoutParams.menu}
                                    
                                    <li>
                                        <a href="{$it.enlace}" class="">
                                            {$it.titulo}  
                                        </a>
                                    </li>
                                {/foreach}
                            {/if}
                        </ul>
                    </li>
                </ul>
            </nav>
            <hgroup>
                <h1 class="logotipo">{$_layoutParams.configs.app_name}</h1> 
                <h3>{$_layoutParams.configs.app_slogan}</h3>
            </hgroup>     
        </header>
        <div id="contenido">
            <noscript>
            <p>Para el correcto funcionamiento debes tener el soporte de JavaScript habilitado</p>
            </noscript>
            {if isset($_error)} 
                <div id="error">{$_error}</div>
            {/if}
            {if isset($_mensaje)}
                <div id="mensaje">{$_mensaje}</div>
            {/if}

            {include file = $_contenido}  
        
        </div>   <!-- Cierra el contenido --> 
    <footer>

        <ul>
            <li>Copyright &copy 2014 {$_layoutParams.configs.app_company}</address></li>
        </ul>
        </footer>
    </body>
</html>

        
