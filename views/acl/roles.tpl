<h2>Administración de Roles</h2>

{if isset($roles) && count($roles)}
    <div class="bloque_blanco">
        <table>
            <tr>
                <th>IdRol</th>
                <th>Role</th>
                <th>Acción</th>
            </tr>
            {foreach $roles as $rol}
                <tr>
                    <td>{$rol.idrole}</td>
                    <td>{$rol.role}</td>
                    <td><a href="{$_layoutParams.root}acl/permisos_role/{$rol.idrole}">Permisos</a></td>
                </tr>
            {/foreach}
        </table>
    </div>
{/if}