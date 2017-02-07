<?php
    //session_start();
    include_once('includes/disciplinas.php');
    include_once('includes/categorias.php');
    include_once('dbcfg.php');

    $deportes = new disciplinas();
    $deportes->poblar();

    function fillSports() {
        $deportes = new disciplinas();
        $deportes->poblar();

        echo "<select class='form-control' id='pais'>";
        echo "<option selected='selected'>Seleccionar una disciplina</option>";
        for ($i = 1; $i < $deportes->largo(); $i++){
            echo "<option value='".$deportes->getValor($i)->GetId_Disciplina()."'>".$deportes->getValor($i)->GetNombre_Disciplina()."</option>";
        }
        echo "</select>";
    }

    function getSportsTable(){
        $deportes = new disciplinas();
        $deportes->poblar();

        for ($i = 1; $i < $deportes->largo(); $i++){
            echo "<tr>";
            echo "<td>".$deportes->getValor($i)->GetId_Disciplina()."</td>";
            echo "<td><img src='../img/sport-icon/".$deportes->getValor($i)->GetId_Disciplina().".png' width='24px' height='24px'></td>";
            $sportName = utf8_encode($deportes->getValor($i)->GetNombre_Disciplina());
            echo "<td>".$sportName."</td>";
            $sport = urlencode($deportes->getValor($i)->GetNombre_Disciplina());
            $uri = "modsport.php?id=".$deportes->getValor($i)->GetId_Disciplina()."&name=".$sport."";
            $catUri = "category.php?sid=".$deportes->getValor($i)->GetId_Disciplina()."&sname=".$sport;
            echo "<td><button type='button' class='btn btn-link btn-xs' onclick='location.href=\"".$uri."\"'><span class='glyphicon glyphicon-pencil'></span>&nbsp&nbsp&nbspModificar</button></td>";
            echo "<td><button type='button' class='btn btn-link btn-xs' onclick='confirmDeleteSport(".$deportes->getValor($i)->GetId_Disciplina().")'><text class='text-danger'><span class='glyphicon glyphicon-trash'></span>&nbsp&nbsp&nbspEliminar</text></button></td>";
            echo "<td><button type='button' class='btn btn-success btn-xs' onclick='location.href=\"".$catUri."\"'><span class='glyphicon glyphicon-ok'></span>&nbsp&nbsp&nbspVer Categorías</button></td>";
            echo "</tr>";
        }

    }

    function getSportsGrid() {
        $deportes = new disciplinas();
        $deportes->poblar();

        for ($i = 1; $i < $deportes->largo(); $i++){
            echo "<div class='col-xs-4 sport-icon' onlick='getSportInfo(this.value)'>
                    <button class='sport-button btn btn-default'>
                        <img src='img/sport-icon/".$deportes->getValor($i)->GetId_Disciplina().".png' width='40px' height='40px'>
                        <p>".$deportes->getValor($i)->GetNombre_Disciplina()."</p>
                        <p hidden='hidden'>".$deportes->getValor($i)->GetId_Disciplina()."</p>
                    </button>
                </div>";
        }
    }

    function deleteSport($id){
        $deporte = new Disciplina($id, "", "");
        if ($deporte->delete() == 0){
            header("Location: ../cpanel/sports.php?q=deleteSuccess");
        } else {
            header("Location: ../cpanel/sports.php?q=error");
        }
    }

    function getCategoryTable($id){

        $categorias = new categorias();
        $categorias->poblar($id);

        for ($i = 1; $i < $categorias->largo(); $i++){
            echo "<tr>";
            $categoryId = urlencode($categorias->getValor($i)->GetId_Categoria());
            echo "<td>".$categoryId."</td>";
            $categoryName1 = utf8_encode($categorias->getValor($i)->GetNombre_Categoria());
            $categoryGender1 = utf8_encode($categorias->getValor($i)->GetGenero_Categoria());
            $categoryName2 = ucfirst($categoryName1);
            $categoryGender2 = ucfirst($categoryGender1);
            echo "<td>".$categoryName2."</td>";
            echo "<td>".$categoryGender2."</td>";
            $categoryId = urlencode($categorias->getValor($i)->GetId_Categoria());
            $category = urlencode($categorias->getValor($i)->GetNombre_Categoria());
            $gender = urlencode($categorias->getValor($i)->GetGenero_Categoria());

            $uri = "modcategory.php?id=".$categoryId."&name=".$category."&gender=".$gender."";
            echo "<td><button type='button' class='btn btn-link btn-xs' onclick='location.href=\"".$uri."\"'><span class='glyphicon glyphicon-pencil'></span>&nbsp&nbsp&nbspModificar</button></td>";
            echo "<td><button type='button' class='btn btn-link btn-xs' onclick='confirmDeleteCategory(".$categoryId.")'><text class='text-danger'><span class='glyphicon glyphicon-trash'></span>&nbsp&nbsp&nbspEliminar</text></button></td>";
            echo "</tr>";
        }
    }

    function insertCategory($sid, $name, $gender, $description){
        $dbuser = "toInsert";
        $dbpass = "toInsert";

        $connection = new mysqli(DBSERV, $dbuser, $dbpass);

        if ($connection->connect_error) {
            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
        } else {
            mysqli_select_db($connection, DBNAME);
            $connection->set_charset("utf8");
            echo "INSERT INTO categoria VALUES(0, '$sid', '$name', '$gender', '$description')";
            echo "<br>";
            $sql = "INSERT INTO categoria VALUES(0, '$sid', '$name', '$gender', '$description')";
            /*$query = $connection->query($sql);*/
            $connection->query($sql);
            $connection->close();


            header("Location: ../cpanel/sports.php?q=add");
        }
    }

    function updateCategory($id, $name, $gender, $description,$sid ,$sportname){
        $dbuser = "toUpdate";
        $dbpass = "toUpdate";

        echo "entro en funcion<br>";
        $Nameminus = strtolower($name);


        $connection = new mysqli(DBSERV, $dbuser, $dbpass, DBNAME);

        if ($connection->connect_error) {
            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
        }

        mysqli_select_db($connection, DBNAME);
            $connection->set_charset("utf8");

            $sql1 ="SELECT NombreCategoria from Categoria where lower(NombreCategoria)='$Nameminus'";
            $consulta=$connection->query($sql1);
            $row=mysqli_num_rows($consulta);

        if($row1 != 0)
        {
                $connection->close();
                header("Location: ../cpanel/modcategory.php?q=existecategoria");}
        else {
            echo "entro en sql<br>";
            mysqli_select_db($connection, DBNAME);
            $connection->set_charset("utf8");
            $sql = "UPDATE categoria set nombrecategoria='$name', genero='$gender', descripcioncategoria='$description' WHERE idcategoria=".intval($id)."";
            echo $sql."<br>";
            /*$query = $connection->query($sql);*/
            $res = $connection->query($sql) or die(mysqli_error($connection));
            $connection->close();
            header("Location: ../cpanel/category.php?sid=".$sid."&sname=".$sportname."&q=update");
        }

    }

    function deleteCategory($id){
        $dbusername = "toDelete";
        $dbpass = "toDelete";

        $connection = new mysqli(DBSERV, $dbusername, $dbpass);
        echo "entro en funcion <br>";

        if ($connection->connect_error) {
            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
        } else {
            mysqli_select_db($connection, DBNAME);
            $sql = "DELETE FROM categoria WHERE idcategoria=".$id.";";
            echo $sql;
            /*$query = $connection->query($sql);*/
            $result = mysqli_query($connection, $sql);
            if (!$result) {
                printf("Error: %s\n", mysqli_error($connection));
                exit();
            }
            header("Location: ../cpanel/sports.php?q=deleteSuccess");
        }
    }

    function fillCategorySearch($term, $id){
        $dbusername = "toInsert";
        $dbpass = "toInsert";

        $connection = new mysqli(DBSERV, $dbusername, $dbpass);

        if ($connection->connect_error) {
            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
        } else {
            mysqli_select_db($connection, DBNAME);
            $sql = "SELECT idcategoria, nombrecategoria, genero, descripcioncategoria FROM categoria WHERE IdDisciplina='$id' AND nombrecategoria LIKE '%".$term."%' ORDER BY NombreCategoria";
            /*$query = $connection->query($sql);*/
            $result = mysqli_query($connection, $sql);
            if (!$result) {
                printf("Error: %s\n", mysqli_error($connection));
                exit();
            }
        }

        if(mysqli_num_rows($result)==0){
            echo "<p style='text-align: center; font-style: italic;'>No se han encontrado categorías que coincidan con los parámetros ingresados.</p>";
        }

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$row['idcategoria']."</td>";
            $sportName = utf8_encode($row['nombrecategoria']);
            $sportGender = utf8_encode($row['genero']);
            echo "<td>".$sportName."</td>";
            echo "<td>".$sportGender."</td>";

            $idcat = urlencode($row['idcategoria']);
            $sport = urlencode($row['nombrecategoria']);
            $gender =urlencode($row['genero']);
            $Desc = urlencode($row['descripcioncategoria']);

            $uri = "modcategory.php?id=".$row['idcategoria']."&name=".$sport."&gender=".$gender."&desc=".$Desc."";
            $catUri = "category.php?sid=".$row['idcategoria']."&sname=".$sport;
            echo "<td><button type='button' class='btn btn-link btn-xs' onclick='location.href=\"".$uri."\"'><span class='glyphicon glyphicon-pencil'></span>&nbsp&nbsp&nbspModificar</button></td>";
            echo "<td><button type='button' class='btn btn-link btn-xs' onclick='confirmDeleteCategory(".$row['idcategoria'].")'><text class='text-danger'><span class='glyphicon glyphicon-trash'></span>&nbsp&nbsp&nbspEliminar</text></button></td>";
            echo "</tr>";
        }
    }


    function selectSport($cid){
        
        include_once "includes/disciplinas.php";

        $lista = new disciplinas();
        $lista->poblarPorPais($cid);

        for($i=0; $i<$lista->largo(); $i++){
            //echo $lista->getValor($i+1)->getId_Disciplina();
            echo "<option value='".$lista->getValor($i+1)->GetId_Disciplina()."'>".$lista->getValor($i+1)->getNombre_Disciplina()."</option>";
        }
    }

    function poblarCategorias($id){
        $lista = new categorias();
        $lista->poblar($id);

        for($i=1; $i<=$lista->largo(); $i++){
            $lugar = $lista->getValor($i);
            $toReturn[] = array(
                            "id" => $lugar->GetId_Categoria(),
                            "nombre" => rawUrlEncode($lugar->GetNombre_Categoria()),
                            "genero" => $lugar->GetGenero_Categoria(),
                            "descripcion" => $lugar->GetDescrip_Categoria(),
                            "disciplina" =>$lugar->GetId_Disciplina()
                          );
        }
        echo json_encode($toReturn); //Encodeo en JSON el array para que JavaScript lo pueda leer
        //print_r($toReturn);
    }

    ////////////////////////////////////////////////////////////////////////////
    // De acá para abajo se manejan los casos en los que se llama el archivo. //
    ////////////////////////////////////////////////////////////////////////////

    if (isset($_REQUEST['q'])){
        switch($_REQUEST['q']){
            case 'insertCategory':
                insertCategory($_REQUEST['sportId'], $_REQUEST['categoryName'], $_REQUEST['categoryGender'], $_REQUEST['categoryDescription']);
                break;
            case 'deleteSport':
                deleteSport($_REQUEST['id']);
                break;
            case 'updateCategory':
                updateCategory($_REQUEST['categoryId'], $_REQUEST['categoryName'], $_REQUEST['categoryGender'], $_REQUEST['categoryDescription']);
                break;
            case 'deleteCategory':
                deleteCategory($_REQUEST['id']);
                break;
            case 'searchcat':
                fillCategorySearch($_REQUEST['s'], $_REQUEST['id']);
                break;
            case 'selectSport':
                selectSport($_REQUEST['countryid']);
                break;
            case 'poblarCategorias':
                poblarCategorias($_REQUEST['id']);
                break;    
        }
    }

?>
