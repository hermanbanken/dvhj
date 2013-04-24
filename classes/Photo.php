<?php defined('SYSPATH') or die('No direct script access.');

class Photo {

	public static function resized($url, $dim){
		// Returns an absolute path to uploads/{name}.jpg
		$name = md5($url).".{$dim}x{$dim}";
		$file = Kohana::find_file('uploads', $name, 'jpg');
		
		// Store if not yet stored
		if(!$file){
			// Original size
			$full_name = md5($url);
			$full = Kohana::find_file('uploads', $full_name, 'jpg');
		
			if(!$full){
				$full = APPPATH."/uploads/$full_name.jpg";
				file_put_contents($full, file_get_contents($url));
			}
			
			$file = APPPATH."/uploads/$name.jpg";
			$img = Image::factory($full)->resize($dim, $dim, Image::AUTO)->save($file, 80);
		}
		
		return URL::site("uploads/".$name.".jpg");
	}
}