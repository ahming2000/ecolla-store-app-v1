<div id="imgSlide" class="carousel slide m-0" data-ride="carousel">
    <ol class="carousel-indicators">
        <?php

            for($i = 0; $i < $item->getImgCount(); $i++){
                echo "<li data-target=\"#imgSlide\" data-slide-to=\"".$i."\"";
                if($i == 0) echo " class=\"active\""; //Set active for the first slide
                echo "></li>";
            }

            // Original Pattern: <li data-target="#imgSlide" data-slide-to="{slide index}"></li>

        ?>
    </ol>

    <div class="carousel-inner">
        <?php

            for($i = 0; $i < $item->getImgCount(); $i++){
                echo "<div class=\"carousel-item";
                if($i == 0) echo " active"; //Set active for the first slide
                echo "\">";
                echo "<img class=\"d-block w-100\" src=\"../assets/images/items/".$item->getID()."/".$i.".png\" data-interval=\"10000\">";
                echo "</div>";
            }

            /* Original Pattern
            <div class="carousel-item">
                <img class="d-block w-100" src={img directory} data-interval="10000">
            </div>
            */
        ?>
    </div>

    <a class="carousel-control-prev" href="#imgSlide" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#imgSlide" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>
