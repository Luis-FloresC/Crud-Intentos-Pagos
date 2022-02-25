
    <div class="page-header">
        <h1 class="all-tittles">Categorias &nbsp;&nbsp;<small><button type="button" name="btnNuevo" id="btnNuevo" class="btn btn-success btn-sm">Nuevo registro</button></small></h1>        
    </div>



<table class="table table-dark table-striped table-bordered">
    <thead>
        <tr>
            <th>Codigo</th>
            <th>Categoria</th>
            <th>Estado</th>
            <th>Acciones+</th>
        </tr>
    </thead>
    <tbody>
    {{foreach categorias}}
        <tr>   
            <td scope="row">{{catid}}</td>
            <td>{{catnom}}</td>
            <td>{{catest}}</td>
            <td >
                <a type="button"  href="index.php?page=mnt.categorias.categoria&mode=UPD&catid={{catid}}" class="btn btn-primary">Editar</a> &nbsp;&nbsp;
                <a type="button" href="index.php?page=mnt.categorias.categoria&mode=DEL&catid={{catid}}" class="btn btn-danger">Eliminar</a>
            </td>
        </tr>
    {{endfor categorias}}
    </tbody>
</table>
            <script>
                document.addEventListener("DOMContentLoaded", (e) => {
                    var btnNuevo = document.getElementById("btnNuevo");
                    btnNuevo.addEventListener("click", (e) => {
                        e.preventDefault();
                        e.stopPropagation();
                        window.location.assign(
                            "index.php?page=mnt_Categorias_Categoria&mode=INS&catid=0"
                        );
                    });
                });
            </script>