<h2>Listado de Usuarios</h2>
{if isset($usuarios) && count($usuarios)}
    <div class="bloque_blanco">
        <table>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>User Name</th>
                <th>Role</th>
                <th></th>
            </tr>
            {foreach $usuarios as $usuario}
                <tr>
                    <td>{$usuario.id}</td>
                    <td>{$usuario.nombre}</td>
                    <td>{$usuario.usuario}</td>
                    <td>{$usuario.role}</td>
                    <td>
                    <a href="{$_layoutParams.root}usuarios/permisos/{$usuario.id}">Permisos</a>
                    </td>
                </tr>
            {/foreach}
        </table>
    </div>
{/if}