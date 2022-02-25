
    <div class="container-fluid">
        <div class="form">
            <h1 class="title-flat-form title-flat-blue">
                Categorías
            </h1>
            <form class="needs-validation" novalidate method="post">
                <div class="form-row">
                    <div class="col-md-4 mb-3">
                        <label for="catid">ID Categoría</label>
                        <input type="text" class="form-control" nombre="catid" id="catid" placeholder="Escriba el nombre de la Categoría"
                            value="{{catid}}" required />
                        <div class="valid-feedback">¡Se ve bien!</div>
                        <div class="invalid-feedback">Por favor ingrese un nombre!</div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="catnom">Nombre</label>
                        <input type="text" class="form-control" id="catnom" name="catnom" placeholder="Escriba el nombre de la Categoría"
                            value="{{catnom}}" required />
                        <div class="valid-feedback">¡Se ve bien!</div>
                        <div class="invalid-feedback">Por favor ingrese un nombre!</div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="catest">Estado</label>
                        <select class="form-control" name="catest" id="catest" placeholder="Last name" required>
                                    {{foreach catestOptions}}
                                        <option value="{{value}}" {{selected}}>{{text}}</option>
                                    {{endfor catestOptions}}
                        </select>
                        <div class="valid-feedback">¡Se ve bien!</div>
                    </div>

                    <button class="btn btn-primary" type="submit">Enviar</button>
                    <button name="btnCancelar" id="btnCancelar" class="btn btn-danger">Cancelar</button>
            </form>
            <script>
                // Example starter JavaScript for disabling form submissions if there are invalid fields
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
                            "index.php?page=mnt_Categorias_Categorias"
                        );
                    });
                });
            </script>
        </div>
    </div>