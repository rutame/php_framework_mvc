<h2>Administración de permisos de role</h2>
<h3 class="lineag">Permisos del Role: {$role.role}</h3>

<form name="form1" method="post" action="" class="form medio relativo">
    <input type="hidden" name="guardar" value="1">
    {if isset($permisos) && count($permisos)}
        <table>
            <tr>
                <th>Permiso</th>
                <th>Habilitado</th>
                <th>Denegado</th>
                <th>Ignorar</th>
            </tr>
            {foreach $permisos as $pr}
                
                <tr>
                    <td>{$pr.nombre}</td>
                    <td>
                        <input type="radio" name="perm_{$pr.id}" value="1" 
                            {if ($pr.valor == 1) }
                                checked="checked"
                            {/if} >
                    </td> 
                    
                    <td>
                        <input type="radio" name="perm_{$pr.id}" value="" 
                            {if ($pr.valor == "") }checked="checked"{/if}>
                    </td>
                    
                    <td>
                        <input type="radio" name="perm_{$pr.id}" value="x" 
                            {if ($pr.valor === "x") }checked="checked"{/if}
                    </td>
                </tr>
                
            {/foreach}
        </table>
    {/if}
    <input type="submit" value="Guardar" class="btn long relativo">
    <a href="{$_layoutParams.root}acl/roles">
    <input type="button" value="Volver" class="btn">
    </a>
    
</form>