<?php include "assets/php/includes/class-auto-loader.inc.php"; //Auto include all the classes. ?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <title>Add a new Item</title>
        <link rel="stylesheet" href="../assets/vendor/bootstrap-4.5.2-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="../assets/vendor/icofont/icofont.min.css">
    </head>

<?php 

    function createNewItem(){
        
        $item = new Item($_POST["itemName"], $_POST["itemCatogory"], array($_POST["itemImgPath"]));

        $newPHPFile = fopen("../items/".str_replace(" ", "-", $item->getName()).".php", "w") or die("Error on creating new php file!");
        $template = fopen("../items/item-page-template.txt", "r") or die("Error on opening the item php file template!");

        while(!feof($template)){
            $str = fgets($template);

            if($str === "<!--Name-->"){
                fwrite($newPHPFile, strval($item->getName()));
            }

            if(UsefulFunction::startsWith($str, "<!--")){
                //Implement dynamic information
                if(UsefulFunction::startsWith($str, "<!--Catogory-->")){
                    fwrite($newPHPFile, strtolower($item->getCatogory()));
                } 
                else if(UsefulFunction::startsWith($str, "<!--Name-->")){
                    fwrite($newPHPFile, $item->getName());
                } 
                else if(UsefulFunction::startsWith($str, "<!--ImgPath-->")){
                    for($i = 0; $i < sizeof($item->getImgPath()); $i++){
                        fwrite($newPHPFile, $item->getImgPath[$i]);
                    }
                } 
            } else{ 
                fwrite($newPHPFile, $str); //Read from template
            }

            
        }
        fclose($template);
        fclose($newPHPFile);
        
    }
?>

    <body>
        <!-- Important Thing To Declare -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="../assets/vendor/bootstrap-4.5.2-dist/js/bootstrap.min.js"></script>        
        

        

        <h1>Add a new item</h1>
        <form action="new.php" method="post">
            Name: <input type="text" name="itemName"><br>
            Catogory: <input type="text" name="itemCatogory"><br>
            Images Path: <input type="text" name="itemImgPath"><br>
            <input type="submit">
        </form>

        <?php
           if($_SERVER['REQUEST_METHOD']=='POST')
           {
               createNewItem();
           } 
        ?>
    
    </body>
</html>