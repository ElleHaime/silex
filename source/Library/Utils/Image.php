<?php 

namespace Library\Utils;

use Symfony\Component\Filesystem\Filesystem,
	Silex\Application,
	Library\Utils\Misc as _U;


class Image
{
	public $app;
	
	
	public function saveTempImage($image)
	{
		$path = $this -> app['appConfig'] -> upload -> tempPath;
		$fileName = self::genFilename($image -> guessExtension());
		
		try {
			$image -> move($path, $fileName);
			chmod($path . $fileName, 0777);
			
			$result = ['path' => '/img/temp/' . $fileName,
					   'name' => $image -> getClientOriginalName()];
			return $result;
				
		} catch(\Exception $e) {
			$this -> errors -> add('tempImage', $e -> getMessage());
			return false;
		}
	}
	
	
	public function resize($image, $newPath, $height=0, $width=0)
	{
		// Get current dimensions
		$imageDetails = $this -> getImageDetails($image);
		$name = $imageDetails -> name;
		$height_orig = $imageDetails -> height;
		$width_orig = $imageDetails -> width;
		$fileExtention = $imageDetails -> extension;
		$ratio = $imageDetails -> ratio;
		$jpegQuality = 75;
		
		//Resize dimensions are bigger than original image, stop processing
		if ($width > $width_orig && $height > $height_orig){
			return false;
		}
		
		if($height > 0){
			$width = $height * $ratio;
		} else if($width > 0){
			$height = $width / $ratio;
		}
		$width = round($width);
		$height = round($height);
		
		$gd_image_dest = imagecreatetruecolor($width, $height);
		$gd_image_src = null;
		switch($fileExtention)
		{
			case 'png' :
					$gd_image_src = imagecreatefrompng($image);
					imagealphablending($gd_image_dest, false);
					imagesavealpha($gd_image_dest, true);
				break;
				
			case 'jpeg': 
			case 'jpg': 
					$gd_image_src = imagecreatefromjpeg($image);
				break;
				
			case 'gif': 
					$gd_image_src = imagecreatefromgif($image);
				break;
				
			default: break;
		}
		
		imagecopyresampled($gd_image_dest, $gd_image_src, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
		
		$filesystem = new Filesystem();
		$filesystem -> mkdir($newPath, 0744);
		$newFileName = $newPath . $name . "." . $fileExtention;
		
		switch($fileExtention)
		{
			case 'png': 
					imagepng($gd_image_dest, $newFileName); 
				break;
				
			case 'jpeg': 
			case 'jpg': 
					imagejpeg($gd_image_dest, $newFileName, $jpegQuality); 
				break;
				
			case 'gif': 
					imagegif($gd_image_dest, $newFileName); 
				break;
				
			default: break;
		}
		
		return $newPath;		
	} 	
	
	
	private function getImageDetails($imageWithPath)
	{
		$size = getimagesize($imageWithPath);
	
		$imgParts = explode("/", $imageWithPath);
		$lastPart = $imgParts[count($imgParts) - 1];
	
		if(stristr("?", $lastPart)) {
			$lastPart = substr($lastPart, 0, stripos("?", $lastPart));
		}
		if(stristr("#", $lastPart)){
			$lastPart = substr($lastPart, 0, stripos("#", $lastPart));
		}
	
		$dotPos = stripos($lastPart, ".");
		$name = substr($lastPart, 0, $dotPos);
		$extension = substr($lastPart, $dotPos + 1);
	
		$details = new \stdClass();
		$details -> height = $size[1];
		$details -> width = $size[0];
		$details -> ratio = $size[0] / $size[1];
		$details -> extension = $extension;
		$details -> name = $name;
	
		return $details;
	}
	
	
	public static function genFilename($ext)
	{
		return md5(uniqid()) . '.' . $ext;
	}
	
	
	public function setApp(Application $app)
	{
		$this -> app = $app;
		return $this;
	}
	
	
	public static function parseImagesInText($text, $sourcePath, $destinationPath, $replacePath, $imgUploaded = [])
	{
		//$text = htmlentities($text);
		
		if (!empty($imgUploaded)) {
			if (!is_dir($destinationPath)) {
				mkdir($destinationPath, 0777);
			}
	
			foreach ($imgUploaded as $key => $i) {
_U::dump($text, true);
_U::dump($i, true);
				if (strpos($text, $i)) {
	
					// copy file from temp to training directory
					$iToArray = explode('/', $i);
_U::dump($iToArray, true);					
					$fileName = end($iToArray);
_U::dump($fileName, true);					
					rename($sourcePath . $fileName, $destinationPath . $fileName);
					chmod($destinationPath . $fileName, 0777);
						
					// replace href in text
					$text = preg_replace($i, $replacePath . $fileName, $text);
_U::dump($text);					
				}
			}
		}
_U::dump('done');	
		return $text;
	}
}
