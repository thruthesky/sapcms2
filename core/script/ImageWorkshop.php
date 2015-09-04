<?php
/**
 *
 *
 * http://phpimageworkshop.com/
 * https://github.com/Sybio/ImageWorkshop
 *
 */
use PHPImageWorkshop\ImageWorkshop;

$layer = ImageWorkshop::initFromPath('c:/tmp/jaeho.jpg');
echo $layer->getWidth() . PHP_EOL;
echo $layer->getHeight() . PHP_EOL;
$layer->resizeInPixel(100, null, true);
echo $layer->getWidth() . PHP_EOL;
echo $layer->getHeight() . PHP_EOL;
$layer->save("c:/tmp", "jaeho2.jpg");
