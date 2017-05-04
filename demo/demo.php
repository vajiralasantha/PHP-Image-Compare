<?php

use BigV\ImageCompare;

require __DIR__ . "/../vendor/autoload.php";

/**
 * These two images are almost the same so the hammered distance will be less than 10
 * Try it with images like below:
 * 1. Two slightly different images
 * 2. Two completely different images
 * 3. Two same images (returned value 0)
 * 4. Two same image but with different size/aspect ratio (returned value ~0)
 */

$image = new ImageCompare();
echo $image->compare(__DIR__ . '/image2-resize.jpg',__DIR__ . '/image2.jpg');

?>