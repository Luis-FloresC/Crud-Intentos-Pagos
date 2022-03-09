<div class="container-fluid">
        <div class="form">

    <figure class="text-center">
        <blockquote class="blockquote">
            <h1>Formulario de Lugares Turisticos</h1>
        </blockquote>
        <figcaption class="blockquote-footer">
            Descripción: <cite title="Source Title">{{modeDsc}}</cite>
        </figcaption>
    </figure>    
    <div class="form-row">   
            <form action="index.php?page=LugaresTuristicos.LugaresTuristico&mode={{mode}}&lugarid={{lugarid}}" class="needs-validation" novalidate method="post">
                
                <input type="hidden" name="crsxToken" value="{{crsxToken}}" />
                {{ifnot isInsert}}
                    <div class="col-md-4 mb-3">
                        <label for="id">ID Lugar</label>
                        <input type="text" class="form-control" nombre="lugarid" id="lugarid" placeholder="Id Lugar"
                            value="{{lugarid}}" required readonly />
                        <div class="valid-feedback">¡Se ve bien!</div>
                        <div class="invalid-feedback">Por favor ingrese un id!</div>
                    </div>
                {{endifnot isInsert}}
                    <div class="col-md-4 mb-3">
                        <label for="lugar">Lugar</label>
                        <input type="text" class="form-control" id="lugar" name="lugar" placeholder="Escriba el nombre del lugar"
                            value="{{lugar}}" required  {{if readonly}} readonly {{endif readonly}} />
                        <div class="valid-feedback">¡Se ve bien!</div>
                        <div class="invalid-feedback">Por favor ingrese un nombre!</div>
                    </div>
                     <div class="col-md-4 mb-3">
                        <label for="pais">Pais</label>
                        <input type="text" class="form-control" id="pais" name="pais" placeholder="Escriba el pais del lugar"
                            value="{{pais}}" required  {{if readonly}} readonly {{endif readonly}} />
                        <div class="valid-feedback">¡Se ve bien!</div>
                        <div class="invalid-feedback">Por favor ingrese un pais!</div>
                    </div>
                     <div class="col-md-4 mb-3">
                        <label for="estado">Estado</label>
                        <select class="form-control" name="estado" id="estado" placeholder="Last name" {{if readonly}} disabled {{endif readonly}} required>
                                    {{foreach estOptions}}
                                        <option value="{{value}}" {{selected}}>{{text}}</option>
                                    {{endfor estOptions}}
                        </select>
                        <div class="valid-feedback">¡Se ve bien!</div>
                    </div>
                     <div class="col-md-4 mb-3">
                        <label for="ciudad">Ciudad</label>
                        <input type="text" class="form-control" id="ciudad" name="ciudad" placeholder="Escriba el nombre de la ciudad"
                            value="{{ciudad}}" required  {{if readonly}} readonly {{endif readonly}} />
                        <div class="valid-feedback">¡Se ve bien!</div>
                        <div class="invalid-feedback">Por favor ingrese una ciudad!</div>
                    </div>

                     <div class="col-md-4 mb-3">
                        <label for="latitu">Latitud</label>
                        <input type="text" class="form-control" id="latitud" name="latitud" placeholder="Escriba la latitud del lugar"
                            value="{{latitud}}" required {{if readonly}} readonly {{endif readonly}} />
                        <div class="valid-feedback">¡Se ve bien!</div>
                        <div class="invalid-feedback">Por favor ingrese un nombre!</div>
                    </div>
                <div class="col-md-4 mb-3">
                        <label for="longitud">Longitud</label>
                        <input type="text" class="form-control" id="longitud" name="longitud" placeholder="Escriba la longitud del lugar"
                            value="{{longitud}}" required  {{if readonly}} readonly {{endif readonly}} />
                        <div class="valid-feedback">¡Se ve bien!</div>
                        <div class="invalid-feedback">Por favor ingrese la longitud!</div>
                    </div>
                   
                    {{ifnot readonly}}
                    <button class="btn btn-primary" type="submit">Enviar</button> &nbsp;
                    <button name="btnCancelar" id="btnCancelar" class="btn btn-danger">Cancelar</button>
                   
                 
                    {{endifnot readonly}}

                    {{if readonly}}
                        <button name="btnCancelar" id="btnCancelar" class="btn btn-success">Ver Lista de lugares</button>
                    {{endif readonly}}

                    
                   
                    
            </form>

            <script>
           
                /* Example starter JavaScript for disabling form submissions if there are invalid fields */
                (function () {
                    "use strict";
                    window.addEventListener(
                        "load",
                        function () {
                         
                            /* Obtener todos los formularios a los que queremos aplicar estilos de validación de Bootstrap personalizados */
                            var forms = document.getElementsByClassName("needs-validation");
                            /* Bucle sobre ellos y evitar la sumisiónn */
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
            <script>
                
                document.addEventListener("DOMContentLoaded", (e) => {
                    
                    var btnCancelar = document.getElementById("btnCancelar");
                    btnCancelar.addEventListener("click", (e) => {
                        e.preventDefault();
                        e.stopPropagation();
                        window.location.assign(
                            "index.php?page=LugaresTuristicos_LugaresTuristicos"
                        );
                    });
                });
            </script>
        </div>
    </div>

