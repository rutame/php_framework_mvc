<!-- ajax -->
<h2>Vista de Ajax</h2>

<form>
    Pais: 
    <select id="pais">
        <option value=""> - Seleccione País - </option>
        
            {foreach $paises as $pais => $p}
                <option value="{$p.id}">{$p.pais}</option>
            {/foreach}
    </select> 
    
    Ciudad: 
    <select id="ciudad">
        <option value=""> - Seleccione Ciudad - </option>
    </select> 
    
    <p></p>
    Ciudad a Insertar:
    <input type="text" id="ins_ciudad">
    <input type="button" value="Insertar" id="btn_insertar" class="btn">
</form>