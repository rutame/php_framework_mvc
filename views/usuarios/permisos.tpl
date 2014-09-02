<h2>Administración de permisos de role</h2>
{*$info|@var_dump*}
{*$info.0.usuario*}
<!----><h3 class="lineag">Permisos del Usuario: {$info.0.usuario} | Role: {$info.0.role}</h3>

<form name="form1" method="post" action="" class="form medio relativo">
    <input type="hidden" name="guardar" value="1">
    {if isset($permisos) && count($permisos)}
        <table>
            <tr>
                <th>Permiso</th>
                <th>Habilitado</th>
            </tr>
            {foreach $permisos as $pr}
                
                {if $role.$pr.valor == 1}
                   {assign var = "v" value="habilitado"}
                {else}
                   {assign var = "v" value="habilitado"}
                {/if}
                
                <tr>
                    <td>{$usuario.$pr.permiso}</td>
                    
                    <td>
                        <select name="perm_{$usuario.$pr.id}">
                            <option value="x"{if ($usuario.$pr.heredado) } 
                                    selected="selected"{/if}>Heredado({$v})</option>
                            <option value="1"{if ($usuario.$pr.valor == 1 && $usuario.$pr.heredado == "")} 
                                    selected="selected"{/if}>Habilitado</option>
                            <option value=""{if ($usuario.$pr.valor == "" && $usuario.$pr.heredado == "")} 
                                    selected="selected"{/if}>Denegado</option>
                        </select>
                        
                    </td> 
                    
 
                
            {/foreach}
        </table>
    {/if}
    <input type="submit" value="Guardar" class="btn long relativo">
    <a href="{$_layoutParams.root}usuarios">
    <input type="button" value="Volver" class="btn">
    </a>
    
</form>