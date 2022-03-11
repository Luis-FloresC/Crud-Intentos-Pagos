<div class="page-header">
<h1 class="all-tittles">Lista de Persona &nbsp;&nbsp;<small><button type="button" name="btnNuevo" id="btnNuevo" class="btn btn-success btn-sm">Nuevo registro</button></small></h1>
</div>

<table class="table table-dark table-striped table-bordered">
<thead>
<tr>
   <th>id</th>
   <th>identidad</th>
   <th>nombre</th>
   <th>edad</th>
   <th>Acciones</th>
</thead>
</tr>
<tbody>
{{foreach Personas}}
<tr>
   <td>{{id}}</td>
   <td><a href="index.php?page=Personas_Persona&mode=DSP&id={{id}}" class="nav-link">{{identidad}}</nav></td>
   <td>{{nombre}}</td>
   <td>{{edad}}</td>
    <td >
        <a type="button"  href="index.php?page=Personas_Persona&mode=UPD&id={{id}}" class="btn btn-primary">Editar</a> &nbsp;&nbsp;
        <a type="button" href="index.php?page=Personas_Persona&mode=DEL&id={{id}}" class="btn btn-danger">Eliminar</a>
    </td>
</tr>
{{endfor Personas}}
</tbody>
</table>
<script> 
 document.addEventListener("DOMContentLoaded", (e) => { 
  var btnNuevo = document.getElementById("btnNuevo"); 
  btnNuevo.addEventListener("click", (e) => { 
  e.preventDefault(); 
  e.stopPropagation(); 
  window.location.assign( 
     "index.php?page=Personas_Persona&mode=INS&id=0"
   ); 
  }); 
 }); 
</script> 
