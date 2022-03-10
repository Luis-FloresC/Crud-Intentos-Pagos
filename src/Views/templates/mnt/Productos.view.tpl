<div class="page-header">
<h1 class="all-tittles">Lista de Productos &nbsp;&nbsp;<small><button type="button" name="btnNuevo" id="btnNuevo" class="btn btn-success btn-sm">Nuevo registro</button></small></h1>
</div>

<table class="table table-dark table-striped table-bordered">
<thead>
<tr>
   <th>invPrdId</th>
   <th>invPrdBrCod</th>
   <th>invPrdCodInt</th>
   <th>invPrdDsc</th>
   <th>invPrdTip</th>
   <th>invPrdEst</th>
   <th>invPrdPadre</th>
   <th>invPrdFactor</th>
   <th>invPrdVnd</th>
</thead>
</tr>
<tbody>
{{foreach productos}}
<tr>
   <td>{{invPrdId}}</td>
   <td>{{invPrdBrCod}}</td>
   <td>{{invPrdCodInt}}</td>
   <td>{{invPrdDsc}}</td>
   <td>{{invPrdTip}}</td>
   <td>{{invPrdEst}}</td>
   <td>{{invPrdPadre}}</td>
   <td>{{invPrdFactor}}</td>
   <td>{{invPrdVnd}}</td>
</tr>
{{endfor productos}}
</tbody>
</table>
<script> 
 document.addEventListener("DOMContentLoaded", (e) => { 
  var btnNuevo = document.getElementById("btnNuevo"); 
  btnNuevo.addEventListener("click", (e) => { 
  e.preventDefault(); 
  e.stopPropagation(); 
  window.location.assign( 
     "index.php?page=Mnt_Productos&mode=INS&invPrdId=0"
   ); 
  }); 
 }); 
</script>