
    <div class="container-fluid">
        <div class="form">

    <figure class="text-center">
        <blockquote class="blockquote">
            <h1>Formulario de Pagos</h1>
        </blockquote>
        <figcaption class="blockquote-footer">
            Descripción: <cite title="Source Title">{{modeDsc}}</cite>
        </figcaption>
    </figure>       
            <form action="index.php?page=IntentosPago.IntentosPago&mode={{mode}}&id={{id}}" class="needs-validation" novalidate method="post">
                <div class="form-row">
                {{ifnot isInsert}}
                    <div class="col-md-4 mb-3">
                        <label for="id">ID Categoría</label>
                        <input type="text" class="form-control" nombre="id" id="id" placeholder="Id Pago"
                            value="{{id}}" required />
                        <div class="valid-feedback">¡Se ve bien!</div>
                        <div class="invalid-feedback">Por favor ingrese un nombre!</div>
                    </div>
                {{endifnot isInsert}}
                    <div class="col-md-4 mb-3">
                        <label for="cliente">Cliente</label>
                        <input type="text" class="form-control" id="cliente" name="cliente" placeholder="Escriba el nombre de la Categoría"
                            value="{{cliente}}" required />
                        <div class="valid-feedback">¡Se ve bien!</div>
                        <div class="invalid-feedback">Por favor ingrese un nombre!</div>
                    </div>
                     <div class="col-md-4 mb-3">
                        <label for="monto">Monto</label>
                        <input type="text" class="form-control" id="monto" name="monto" placeholder="Escriba el nombre de la Categoría"
                            value="{{monto}}" required />
                        <div class="valid-feedback">¡Se ve bien!</div>
                        <div class="invalid-feedback">Por favor ingrese un nombre!</div>
                    </div>
                     <div class="col-md-4 mb-3">
                        <label for="fecha_vencimiento">Fecha de Vencimiento</label>
                        <input type="date" class="form-control" id="fecha_vencimiento" name="fecha_vencimiento"
                            value="{{fecha_vencimiento}}" min="2000-01-01T00:00" max="2032-12-31T00:59" required />
                        <div class="valid-feedback">¡Se ve bien!</div>
                        <div class="invalid-feedback">Por favor ingrese un nombre!</div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="estado">Estado</label>
                        <select class="form-control" name="estado" id="estado" placeholder="Last name" required>
                                    {{foreach estOptions}}
                                        <option value="{{value}}" {{selected}}>{{text}}</option>
                                    {{endfor estOptions}}
                        </select>
                        <div class="valid-feedback">¡Se ve bien!</div>
                    </div>

                    <button class="btn btn-primary" type="submit">Enviar</button> &nbsp;
                    <button name="btnCancelar" id="btnCancelar" class="btn btn-danger">Cancelar</button>
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
                            "index.php?page=IntentosPago_IntentosPagos"
                        );
                    });
                });
            </script>
        </div>
    </div>



