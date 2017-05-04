# PHP-Image-Compare
A light weight PHP class that can compare two (jpg/png) images to find if they are similar.

Supported files: "png","jpg".

Usage:

Install via composer

```"vajiral/php-image-compare": "1.0.1"```

In your PHP file

```php
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
```

Originally taken from https://www.phpclasses.org/package/8255-PHP-Compare-two-images-to-find-if-they-are-similar.html and name-spaced and added to ```Composer```
