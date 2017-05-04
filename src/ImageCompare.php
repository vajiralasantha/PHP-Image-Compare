<?php
namespace BigV;

class ImageCompare {

    /**
     * Main function. Returns the hammering distance of two images' bit value.
     *
     * @param string $pathOne Path to image 1
     * @param string $pathTwo Path to image 2
     *
     * @return bool|int Hammering value on success. False on error.
     */
    public function compare($pathOne, $pathTwo) {
        $i1 = $this->createImage($pathOne);
        $i2 = $this->createImage($pathTwo);

        if (!$i1 || !$i2) {
            return false;
        }

        $i1 = $this->resizeImage($pathOne);
        $i2 = $this->resizeImage($pathTwo);

        imagefilter($i1, IMG_FILTER_GRAYSCALE);
        imagefilter($i2, IMG_FILTER_GRAYSCALE);

        $colorMeanOne = $this->colorMeanValue($i1);
        $colorMeanTwo = $this->colorMeanValue($i2);

        $bits1 = $this->bits($colorMeanOne);
        $bits2 = $this->bits($colorMeanTwo);

        $hammeringDistance = 0;

        for ($x = 0; $x < 64; $x++) {
            if ($bits1[$x] != $bits2[$x]) {
                $hammeringDistance++;
            }
        }

        return $hammeringDistance;
    }

    /**
     * Returns array with mime type and if its jpg or png. Returns false if it isn't jpg or png.
     *
     * @param string $path Path to image.
     *
     * @return array|bool
     */
	private function mimeType($path) {
		$mime = getimagesize($path);
		$return = array($mime[0],$mime[1]);
      
		switch ($mime['mime']) {
			case 'image/jpeg':
				$return[] = 'jpg';
				return $return;
			case 'image/png':
				$return[] = 'png';
				return $return;
			default:
				return false;
		}
    }

    /**
     * Returns image resource or false if it's not jpg or png
     *
     * @param string $path Path to image
     *
     * @return bool|resource
     */
	private function createImage($path) {
		$mime = $this->mimeType($path);
      
		if ($mime[2] == 'jpg') {
			return imagecreatefromjpeg ($path);
		} else if ($mime[2] == 'png') {
			return imagecreatefrompng ($path);
		} else {
			return false; 
		} 
    }

    /**
     * Resize the image to a 8x8 square and returns as image resource.
     *
     * @param string $path Path to image
     *
     * @return resource Image resource identifier
     */
	private function resizeImage($path) {
		$mime = $this->mimeType($path);

		$t = imagecreatetruecolor(8, 8);
		
		$source = $this->createImage($path);
		
		imagecopyresized($t, $source, 0, 0, 0, 0, 8, 8, $mime[0], $mime[1]);
		
		return $t;
	}

    /**
     * Returns the mean value of the colors and the list of all pixel's colors.
     *
     * @param resource $resource Image resource identifier
     *
     * @return array
     */
    private function colorMeanValue($resource) {
		$colorList = array();
		$colorSum = 0;
		for ($a = 0; $a<8; $a++) {
			for ($b = 0; $b<8; $b++) {
				$rgb = imagecolorat($resource, $a, $b);
				$colorList[] = $rgb & 0xFF;
				$colorSum += $rgb & 0xFF;
			}
		}
		
		return array($colorSum/64,$colorList);
	}

    /**
     * Returns an array with 1 and zeros. If a color is bigger than the mean value of colors it is 1
     *
     * @param array $colorMean Color Mean details.
     *
     * @return array
     */
    private function bits($colorMean) {
		$bits = array();
		foreach ($colorMean[1] as $color) {
		    $bits[] = ($color >= $colorMean[0]) ? 1 : 0;
		}

		return $bits;

	}
}
  
?>