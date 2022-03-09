

  <div class="container-fluid">
        <figure class="text-center">
            <blockquote class="blockquote">
                <h1>Generador de Crud {{dato}}</h1>
            </blockquote>
        </figure>


        <div class="form">

        <form action="index.php?page=ORM_parameters"  method="post">
            <label for="table"><input id="table" name="table" placeholder="table" type="text"></label> 
            <label for="namespace"><input id="namespace" name="namespace"  placeholder="namespace" type="text"></label> 
            <label for="entity"><input id="entity"   name="entity" placeholder="entity" type="text"></label> 
            <button type="submit" class="btn btn-primary btn-lg">Generar</button>
        </form>
        </div>

   {{if ListaControlador}}
        <div class="highlight"> 
        <pre class="chroma">{{ListaControlador}}</pre>
        </div>
        {{endif ListaControlador}}

<br>
<br>
        {{if ModeloTabla}}
        <div class="highlight"> 
        <pre class="chroma">{{ModeloTabla}}</pre>
        </div>
        {{endif ModeloTabla}}
<br>
<br>
        <p>{{acum}}</p>


       
    </div>

    