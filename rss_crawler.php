<?php
    include_once "simple_html_dom.php";

    function readFeed() {
        set_time_limit(0);
        $feed = file_get_contents("http://www.20minutos.es/rss/minuteca/juegos-olimpicos-rio-2016/");
        $stream = new SimpleXmlElement($feed);

        $count = 1;

        foreach($stream->item as $elemento) {

            if ($count==10){
                break;
            }

            $titulo = $elemento->title;
            $url = $elemento->link;

            try {
                $webpage = file_get_html($url);
                $imagen = 'img/news_placeholder.jpg';
                foreach($webpage->find('.article-photo') as $element) {
                    $img = $element->href;
                    //echo $img;
                    if ($imagen == 'img/news_placeholder.jpg'){
                        $imagen = $img;
                    }
                }
            } catch (Exception $e){
                echo "Error al obtener la imagen";
            }
            echo "";
            echo "<div class='col-custom col-md-5'  style=\"background-image:url('".$imagen."');  background-repeat:no-repeat; width: '50%'; height:'50%';\">";
            echo "<a href='".$url."' class='news-title'><h3 class='rss-title'>".$titulo."</h3></a>";
            //echo "<p>".$descripcion."</p>";
            echo "</div>";

            $count = $count + 1;
        }
        echo "";
    }

?>
