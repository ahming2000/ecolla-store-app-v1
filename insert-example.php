<?php 

include "assets/php/includes/class-auto-loader.inc.php"; //Auto include classes when needed.

$controller = new Controller();

$item1 = new Item("维生素饮料", "饮料", "脉动", "中国", 30);
$item1->addVariety(new Variety("6902538005141", "水蜜桃", "口味", 4.8, 600, "ml"));
$item1->addVariety(new Variety("6902538004045", "青柠", "口味", 4.8, 600, "ml"));
$item1->addVariety(new Variety("6902538007381", "仙人掌青橘", "口味", 4.8, 600, "ml"));
$item1->addVariety(new Variety("6902538007367", "芒果", "口味", 4.8, 600, "ml"));
$item1->addVariety(new Variety("6902538007886", "卡曼橘", "口味", 4.8, 500, "ml"));
$item1->addVariety(new Variety("6902538007862", "竹子青提", "口味", 4.8, 500, "ml"));
$item1->addImgPath("../assets/images/items/1/1.png");
$item1->addImgPath("../assets/images/items/1/2.png");
$item1->addImgPath("../assets/images/items/1/3.png");
$item1->addImgPath("../assets/images/items/1/4.png");
$item1->addImgPath("../assets/images/items/1/5.png");
$item1->addImgPath("../assets/images/items/1/6.png");
$controller->insertNewItem($item1);

$item2 = new Item("手撕素肉排", "零食", "好味屋", "中国", 20);
$item2->addVariety(new Variety("6931754804900", "香辣味", "口味", 1.5, 26, "g"));
$item2->addVariety(new Variety("6931754804917", "黑椒味", "口味", 1.5, 26, "g"));
$item2->addVariety(new Variety("6931754804931", "烧烤味", "口味", 1.5, 26, "g"));
$item2->addVariety(new Variety("6931754805655", "黑鸭味", "口味", 1.5, 26, "g"));
$item2->addVariety(new Variety("6931754804924", "山椒味", "口味", 1.5, 26, "g"));
$item2->addImgPath("../assets/images/items/2/1.png");
$item2->addImgPath("../assets/images/items/2/2.png");
$item2->addImgPath("../assets/images/items/2/3.png");
$item2->addImgPath("../assets/images/items/2/4.png");
$item2->addImgPath("../assets/images/items/2/5.png");
$controller->insertNewItem($item2);

$item3 = new Item("鹌鹑蛋", "零食", "湖湘贡", "中国", 10);
$item3->addVariety(new Variety("6941025700138", "盐焗", "口味", 1.2, 20, "g"));
$item3->addVariety(new Variety("6941025701074", "卤蛋", "口味", 1.2, 20, "g"));
$item3->addVariety(new Variety("6941025700084", "香辣", "口味", 1.2, 20, "g"));
$item3->addVariety(new Variety("6941025702019", "泡辣", "口味", 1.2, 20, "g"));
$item3->addImgPath("../assets/images/items/3/1.png");
$item3->addImgPath("../assets/images/items/3/2.png");
$item3->addImgPath("../assets/images/items/3/3.png");
$item3->addImgPath("../assets/images/items/3/4.png");
$item3->addImgPath("../assets/images/items/3/5.png");
$controller->insertNewItem($item3);



?>