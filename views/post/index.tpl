<h3>La Vista de Los Posts</h3>
{* if Session::accesoView('especial') *}
<p><a href="{$_layoutParams.root}post/nuevo" class="btn btnmas">Agregar Post</a></p>
{* /if *}

{*$posts|@var_dump*}
{if isset($posts)} 
    
    {foreach $posts as $post}
        <article>    
            
            <header>
                <h2>{$post.titulo}</h2>
                <time pubdate="{$post.fechaPub}">{$post.fechaPub}</time>
            </header>
            
            <p>
                {if isset($post.imagen)}
                    <a href="{$_layoutParams.root}public/img/post/{$post.imagen}">
                    <img src="{$_layoutParams.root}public/img/post/thumb/thumb_{$post.imagen}" 
                         alt="{$post.imagen}" class="imagen flotante">
                    </a>
                {/if}
                {if strlen($post.cuerpo) > 100}
                {$post.cuerpo|truncate:100}
                <a href="{$_layoutParams.root}post/ver/{$post.id}">Leer Más</a>
                {else}
                    {$post.cuerpo}
                {/if}
            </p>
            <footer>
            <p>
                Pedro Gabriel ha escrito 
                <cite>{$post.titulo|truncate:10}</cite> 
                el día <date>{$post.fechaPub}</date>
            </p>
            </footer>
            
            <div class="opciones">
            <a href="{$_layoutParams.root}post/imprimir/{$post.id}" clas="btn">imprimir</a>
            {if $_acl->permiso('editar')}
                <a href="{$_layoutParams.root}post/editar/{$post.id}">Editar Post</a>
                <a href="{$_layoutParams.root}post/eliminar/{$post.id}">Borrar Post</a>
            {/if}
            </div>
            
        </article>
    {/foreach}
{else}
        <strong>No hay posts!</strong>
{/if}
        





