
    <div class="page-header">
        <h1 class="all-tittles">Intento de Pagos &nbsp;&nbsp;<small><button type="button" name="btnNuevo" id="btnNuevo" class="btn btn-success btn-sm">Nuevo registro</button></small></h1>        
    </div>



<table class="table table-dark table-striped table-bordered">
    <thead>
        <tr>
            <th>Codigo</th>
            <th>Fecha</th>
            <th>Cliente</th>
            <th>Monto</th>
            <th>fecha Vencimiento</th>
            <th>Estado</th>
            <th>Acciones+</th>
        </tr>
    </thead>
    <tbody>
    {{foreach IntentosPagos}}
        <tr>   
            <td scope="row">{{id}}</td>
            <td>{{fecha}}</td>
            <td><a href="index.php?page=IntentosPago.IntentosPago&mode=DSP&id={{id}}" class="nav-link">{{cliente}}</a></td>
            <td>{{monto}}</td>
            <td>{{fecha_vencimiento}}</td>
             <td>{{estado}}</td>
            <td >
                <a type="button"  href="index.php?page=IntentosPago.IntentosPago&mode=UPD&id={{id}}" class="btn btn-primary">Editar</a> &nbsp;&nbsp;
                <a type="button" href="index.php?page=IntentosPago.IntentosPago&mode=DEL&id={{id}}" class="btn btn-danger">Eliminar</a>
            </td>
        </tr>
    {{endfor IntentosPagos}}
    </tbody>
</table>
            <script>
                document.addEventListener("DOMContentLoaded", (e) => {
                    var btnNuevo = document.getElementById("btnNuevo");
                    btnNuevo.addEventListener("click", (e) => {
                        e.preventDefault();
                        e.stopPropagation();
                        window.location.assign(
                            "index.php?page=IntentosPago_IntentosPago&mode=INS&id=0"
                        );
                    });
                });
            </script>