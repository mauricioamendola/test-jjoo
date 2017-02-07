<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="css/custom.css" rel="stylesheet">
    <link href="css/header.css" rel="stylesheet">

    <title>Super Pag</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="http://getbootstrap.com.vn/examples/equal-height-columns/equal-height-columns.css" />
    <!-- Custom CSS -->
    <link href="css/modern-business.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
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
         
    	function readFeed(){
        	var xmlhttp = new XMLHttpRequest();
            xmlhttp.open("POST", "readFeed.php", true);

            xmlhttp.onreadystatechange = function() {
            	if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                	document.getElementById('feeds').innerHTML = xmlhttp.responseText;
				}
            }

        	xmlhttp.send();
       	}

		var originalText = "cargando noticias", i  = 0;
            setInterval(function() {
                switch (i){
                    case 0:
                        $('#loading').animate( { backgroundColor: "#60bf30" }, 500);
                        break;
                    case 1:
                        $('#loading').animate( { backgroundColor: "#FBCA06" }, 500);
                        break;
                    case 2:
                        $('#loading').animate( { backgroundColor: "#4ABEEE" }, 500);
                        break;
                    case 3:
                        $('#loading').animate( { backgroundColor: "#ff3333" }, 500);
                        break;
                    case 4:
                        $('#loading').animate( { backgroundColor: "#ffcc00" }, 500);
                        break;
                }


                $("#loading").append(".");
                i++;

                if(i == 4)
                {
                    $("#loading").html(originalText);
                    i = 0;
                }

            }, 500);


        function fillHistoricCommittess(tourny) {
                $("#athletesTable tr").remove();
                $("#placeholderText").remove();
                var tourny= 38;
                var xmlhttp = new XMLHttpRequest();
                console.log("ID de torneo seleccionado: " + tourny);
                xmlhttp.open("POST", "scripts/dataMgmt.php?q=fillHistoricCommittes&tid=" + tourny, true);
                console.log("Estado del XmlHttpRequest: " + xmlhttp.readyState);

                 xmlhttp.onreadystatechange = function() {
                    if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        console.log("Estado del XmlHttpRequest: " + xmlhttp.readyState);
                        document.getElementById('historicTable').innerHTML = xmlhttp.responseText;
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

<body onload="readFeed(); fillHistoricCommittess();">
   <nav class="navbar navbar-inverse sidebar navbar-fixed-top" role="navigation">
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
               <li class="active"><span style="font-size:16px;" class="pull-right hidden-xs showopacity"></span><a href="index.php">Home</a></li>
                <li ><a href="athlete.php">Deportistas<span style="font-size:16px;" class="pull-right hidden-xs showopacity"></span></a></li>
                <li ><a href="disciplinas.php">Deportes<span style="font-size:16px;" class="pull-right hidden-xs showopacit"></span></a></li>
                <li ><a href="historicos_delegaciones.php">Historicos Delegación<span style="font-size:16px;" class="pull-right hidden-xs showopacity"></span></a></li>
                <li ><a href="historicos_delegaciones.php">Historicos por Deportes<span style="font-size:16px;" class="pull-right hidden-xs showopacity"></span></a></li>
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
		<div class="row">
	        <h1 class="page-title" style="text-align: center;">Noticias<br></h1>
	        <div class="col-md-3" style=" height: 650px;">
				
            		<table  style="border-collapse: collapse; "  width="100%">
		                <thead>
		                    <th width="5%" style="text-align:center">Medallero Rio</th>
		                    <th width="2%" style="text-align:center"> <img src="img/oro.png" width="25" height=25></img> </th>
		                    <th width="2%" style="text-align:center"> <img src="img/plata.png" width="25" height=25></img></th>                
		                    <th width="2%" style="text-align:center"> <img src="img/bronce.png" width="25" height=25></img> </th>
		                </thead>
		            </table>
		            <div style="overflow-y: scroll; height: 600px;">
		                <table class="table table-striped" style="border-collapse: collapse;"  width="100%">
		                <tbody id="historicTable">
		                </tbody>
		                </table>
		            </div>
			</div>	        

	    	<div class="col-md-6" style="border: none; overflow-y: scroll; height: 650px;">
		    	<div id="feeds" class='rss-container'>
		        	<p id="loading" class="loading">Cargando noticias</p>
		       	</div>
	        </div>
            <div class="col-md-3" style="height: 650px;">
	            <a class="twitter-timeline"  href="https://twitter.com/hashtag/JJOO2016" data-widget-id="811532442356039680">Tweets sobre #JJOO2016</a>
	            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
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
