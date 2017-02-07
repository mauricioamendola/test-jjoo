<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/custom.css" rel="stylesheet">
    <link href="css/header.css" rel="stylesheet">

    <title>OlimpicGames</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="http://getbootstrap.com.vn/examples/equal-height-columns/equal-height-columns.css" />
    <!-- Custom CSS -->
    <link href="css/modern-business.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel="apple-touch-icon" sizes="57x57" href="icon/apple-touch-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="icon/apple-touch-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="icon/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="icon/apple-touch-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="icon/apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="icon/apple-touch-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="icon/apple-touch-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="icon/apple-touch-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="icon/apple-touch-icon-180x180.png">
    <link rel="icon" type="image/png" href="icon/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="icon/android-chrome-192x192.png" sizes="192x192">
    <link rel="icon" type="image/png" href="icon/favicon-96x96.png" sizes="96x96">
    <link rel="icon" type="image/png" href="icon/favicon-16x16.png" sizes="16x16">
    <link rel="manifest" href="icon/manifest.json">
    <link rel="mask-icon" href="icon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="icon/mstile-144x144.png">
    <meta name="theme-color" content="#f2b420">

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery-1.12.3.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.color-2.1.2.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.js"></script>

    <!--Script para animar los tiles de noticias cuando se hace un mouseover-->
    <script>
        $('.carousel').carousel({
        interval: 500 //changes the speed
        });
         
        function fillCategories(id) {
                $("#categoryName option").remove();

                var xmlhttp = new XMLHttpRequest();
                console.log("ID de deporte seleccionado: " + id);
                xmlhttp.open("POST", "scripts/dataMgmt.php?q=fillCategory&id=" + id, true);
                console.log("Estado del XmlHttpRequest: " + xmlhttp.readyState);

                xmlhttp.onreadystatechange = function() {
                    if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        console.log("Estado del XmlHttpRequest: " + xmlhttp.readyState);
                        document.getElementById('selectedCategory').innerHTML = xmlhttp.responseText;
                    }
                }

               xmlhttp.send();
            }

            function fillAthlete(tourny, category) {
                $("#athletesTable tr").remove();
                $("#placeholderText").remove();

                var xmlhttp = new XMLHttpRequest();
                console.log("ID de torneo seleccionado: " + tourny);
                console.log("ID de categoría seleccionada: " + category);
                xmlhttp.open("POST", "scripts/dataMgmt.php?q=fillAthletes01&tid=" + tourny +"&cid=" + category, true);
                console.log("Estado del XmlHttpRequest: " + xmlhttp.readyState);

                 xmlhttp.onreadystatechange = function() {
                    if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        console.log("Estado del XmlHttpRequest: " + xmlhttp.readyState);
                        document.getElementById('athletesTable').innerHTML = xmlhttp.responseText;
                    }
                }

                xmlhttp.send();
            }
            
        </script>

        <style>
            .loading{
                font-family: sans-serif;
                font-size: 20px;
                background-color: #000000;
                color: #FFFFFF;
                width: 200px;
                margin-left: 40%;
                border-radius: 10px;
                padding: 10px;
            }
        </style>
</head>

<body onload="fillCategories(document.getElementById('selectedSport').value)">

   <nav class="navbar navbar-inverse sidebar" role="navigation">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-sidebar-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-sidebar-navbar-collapse-1">
            <ul class="nav navbar-nav">
               <li><span style="font-size:16px;" class="pull-right hidden-xs showopacity"></span><a href="index.php">Home</a></li>
                <li class="active"><a href="athlete.php">Deportistas<span style="font-size:16px;" class="pull-right hidden-xs showopacity"></span></a></li>
                <li ><a href="disciplinas.php">Deportes<span style="font-size:16px;" class="pull-right hidden-xs showopacit"></span></a></li>
                <li ><a href="historicos_delegaciones.php">Historicos por Torneo<span style="font-size:16px;" class="pull-right hidden-xs showopacity"></span></a></li>
                <li ><a href="historicos.php">Historicos por Deportes<span style="font-size:16px;" class="pull-right hidden-xs showopacity"></span></a></li>
                <li ><a href="places.php">Servicios<span style="font-size:16px;" class="pull-right hidden-xs showopacity"></span></a></li>

            </ul>
        </div>
    </div>
</nav>

    

    <header id="myCarousel" class="carousel slide">
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>

        <div class="carousel-inner">
            <div class="item active">
                <a href="places.php">
                    <div class="fill" style="background-image:url('img/slide1.jpg');"></div>
                    <div class="carousel-caption">
                        <h2>Servicios</h2>
                    </div>
                </a>
            </div>
            <div class="item">
                <div class="fill" style="background-image:url('img/slide2.jpg');"></div>
                <div class="carousel-caption">
                    <h2>Historia de los JJOO</h2>
                </div>
            </div>
             <div class="item">
                <a href="historicos.php">
                    <div class="fill" style="background-image:url('img/slide3.jpg');"></div>
                    <div class="carousel-caption">
                        <h2>Medalleros</h2>
                    </div>
                </a>
            </div>
        </div>

        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
            <span class="icon-prev"></span>
        </a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">
            <span class="icon-next"></span>
        </a>
    </header>
    
    <div>
        <br>
    </div>  
    
    <div class="todo">
        <div class="col-md-4 col-custom-list">
                    <div class="form-group">
                        <label for="tournyName" class="form-label">Torneo:</label>
                        <select name="tournyName" id="selectedTourny" class="form-control">
                            <?php
                                include_once "scripts/dataMgmt.php";
                                fillTournyDropdown();
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="sportName" class="form-label">Disciplina:</label>
                        <select name="sportName" id="selectedSport" class="form-control" onchange="fillCategories(this.value)">
                            <?php
                                fillSportsDropdown();
                            ?>
                        </select>
                        <div hidden="hidden"></div>
                    </div>
                    <div class="form-group">
                        <label for="categoryName" class="form-label">Categor&iacutea:</label>
                        <select name="categoryName" id="selectedCategory" class="form-control"></select>
                    </div>
                    <button onclick="fillAthlete(document.getElementById('selectedTourny').value, document.getElementById('selectedCategory').value)" type="button" class="btn btn-default form-control">Ver atletas&nbsp<span class="glyphicon glyphicon-chevron-right"></span></button>
        </div>
        <div class="table-responsive">
            </br>
            </br>

            <table class="table table-striped" style="border-collapse: collapse;"  width="100%">
                <thead>
                    <th width="25%" style="text-align:center">Nombre</th>
                    <th width="25%" style="text-align:center">Apellido</th>
                    <th width="25%" style="text-align:center">Sexo</th>
                    <th width="25%" style="text-align:center">Delegacion</th>
                    <th width="12,5%" style="text-align:center">Peso</th>
                    <th width="12,5%" style="text-align:center">Alturas</th>
                </thead>
                <tbody id="athletesTable">

                </tbody>
            </table>

            <p id="placeholderText" align="center"><i>Ajuste los par&aacutemetros a la izquierda y presione "Ver atletas"</i></p>
        </div>
    </div>
        
            
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p style="text-align: center; vertical-align: center;">Copyright &copy; Todos los derechos reservados - DevOps Crew Inc.</p>
                </div>
            </div>
        </footer>
    </div>
</body>

</html>
