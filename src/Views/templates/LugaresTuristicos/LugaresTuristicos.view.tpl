   <div class="page-header">
        <h1 class="all-tittles">Lugares Turisticos &nbsp;&nbsp;<small><button type="button" name="btnNuevo" id="btnNuevo" class="btn btn-success btn-sm">Nuevo registro</button></small></h1>        
    </div>



<table class="table table-dark table-striped table-bordered">
    <thead>
        <tr>
            <th>Codigo</th>
            <th>Lugar</th>
            <th>Pais</th>
            <th>Ciudad</th>
            <th>Latitud</th>
            <th>Longitud</th>
            <th>Estado</th>
            <th>Acciones+</th>
        </tr>
    </thead>
    <tbody>
    {{foreach LugaresTuristicos}}
        <tr>   
            <td scope="row">{{lugarid}}</td>
            <td>{{lugar}}</td>
            <td><a href="index.php?page=LugaresTuristicos_LugaresTuristico&mode=DSP&lugarid={{lugarid}}" class="nav-link">{{pais}}</a></td>
            <td>{{ciudad}}</td>
            <td>{{latitud}}</td>
             <td>{{longitud}}</td>
             <td>{{estado}}</td>
            <td >
                <a type="button"  href="index.php?page=LugaresTuristicos_LugaresTuristico&mode=UPD&lugarid={{lugarid}}" class="btn btn-primary">Editar</a> &nbsp;&nbsp;
                <a type="button" href="index.php?page=LugaresTuristicos_LugaresTuristico&mode=DEL&lugarid={{lugarid}}" class="btn btn-danger">Eliminar</a>
            </td>
        </tr>
    {{endfor LugaresTuristicos}}
    </tbody>
</table>
            <script>
                document.addEventListener("DOMContentLoaded", (e) => {
                    var btnNuevo = document.getElementById("btnNuevo");
                    btnNuevo.addEventListener("click", (e) => {
                        e.preventDefault();
                        e.stopPropagation();
                        window.location.assign(
                            "index.php?page=LugaresTuristicos_LugaresTuristico&mode=INS&lugarid=0"
                        );
                    });
                });
            </script>