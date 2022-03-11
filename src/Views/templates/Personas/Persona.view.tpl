<div class="container-fluid">
  <div class="form">
   <figure class="text-center">
       <blockquote class="blockquote">
          <h1>Formulario de Persona</h1>
       </blockquote>
       <figcaption class="blockquote-footer">
           Descripción: <cite title="Source Title">{{modeDsc}}</cite>
       </figcaption>
   </figure> 
   <div class="form-row">  
           <form action="index.php?page=Personas.Persona&mode={{mode}}&id={{id}}" class="needs-validation" novalidate method="post">

               <input type="hidden" name="crsxToken" value="{{crsxToken}}" />
             <div class="col-md-4 mb-3">
               <label for="id">id</label>
               <input type="text" class="form-control" name="id" id="id" placeholder="id" value="{{id}}" required  />
               <div class="valid-feedback">¡Se ve bien!</div>
               <div class="invalid-feedback">Por favor ingrese los datos correctos!</div>
             </div>

             <div class="col-md-4 mb-3">
               <label for="identidad">identidad</label>
               <input type="text" class="form-control" name="identidad" id="identidad" placeholder="identidad" value="{{identidad}}"  />
               <div class="valid-feedback">¡Se ve bien!</div>
               <div class="invalid-feedback">Por favor ingrese los datos correctos!</div>
             </div>

             <div class="col-md-4 mb-3">
               <label for="nombre">nombre</label>
               <input type="text" class="form-control" name="nombre" id="nombre" placeholder="nombre" value="{{nombre}}"  />
               <div class="valid-feedback">¡Se ve bien!</div>
               <div class="invalid-feedback">Por favor ingrese los datos correctos!</div>
             </div>

             <div class="col-md-4 mb-3">
               <label for="edad">edad</label>
               <input type="text" class="form-control" name="edad" id="edad" placeholder="edad" value="{{edad}}"  />
               <div class="valid-feedback">¡Se ve bien!</div>
               <div class="invalid-feedback">Por favor ingrese los datos correctos!</div>
             </div>

       {{ifnot readonly}}

           <button class="btn btn-primary" type="submit">Enviar</button> &nbsp;
           <button name="btnCancelar" id="btnCancelar" class="btn btn-danger">Cancelar</button>

       {{endifnot readonly}}

       {{if readonly}}

           <button name="btnCancelar" id="btnCancelar" class="btn btn-success">Ver Lista de Pagos</button>

       {{endif readonly}}

           </form>
   </div>
  </div>
</div>

<script> 

 document.addEventListener("DOMContentLoaded", (e) => { 
  var btnNuevo = document.getElementById("btnCancelar"); 
  btnNuevo.addEventListener("click", (e) => { 
  e.preventDefault(); 
  e.stopPropagation(); 
  window.location.assign( 
     "index.php?page=Personas_Personas"
   ); 
  }); 
 }); 

</script> 

<script> 

 (function () {
   "use strict";
  window.addEventListener(
     "load",
    function () {
      var forms = document.getElementsByClassName("needs-validation");
     var validation = Array.prototype.filter.call(
    forms,
    function (form) { 
       form.addEventListener( 
          "submit", 
          function (event) { 
            if (form.checkValidity() === false) { 
               event.preventDefault(); 
               event.stopPropagation(); 
           }
           form.classList.add("was-validated");
       },
       false
   );
   }
  );
  },
  false
  );
  })();

</script> 