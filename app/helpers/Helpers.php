<?php

namespace Helpers;

class Helpers extends \Nette\Object {

	static function sanitizeMceString($value, $allowedTags = '<p><b><i><u><a><ul><ol><li><strong><h1><h2><h3><h4><h5><h6><br><table><th><td><tr><tbody><span>'){
		if(!empty($value)){
			return strip_tags($value, $allowedTags);
		}
		else
			return '';
	}
	
    // 14:00:00 => 14:00
    static function hhmm($time) {
        return substr($time, 0, 5);
    }

    static function webalize($string) {
        $url = $string;
        $url = preg_replace('~[^\\pL0-9_]+~u', '-', $url);
        $url = trim($url, "-");
        $url = iconv("utf-8", "us-ascii//TRANSLIT", $url);
        $url = strtolower($url);
        $url = preg_replace('~[^-a-z0-9_]+~', '', $url);

        return $url;
    }
    
    public function generatePassword($length = 8) {

        // start with a blank password
        $password = "";

        // define possible characters - any character in this string can be
        // picked for use in the password, so if you want to put vowels back in
        // or add special characters such as exclamation marks, this is where
        // you should do it
        $possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ";

        // we refer to the length of $possible a few times, so let's grab it now
        $maxlength = strlen($possible);

        // check for length overflow and truncate if necessary
        if ($length > $maxlength) {
            $length = $maxlength;
        }

        // set up a counter for how many characters are in the password so far
        $i = 0;

        // add random characters to $password until $length is reached
        while ($i < $length) {

            // pick a random character from the possible ones
            $char = substr($possible, mt_rand(0, $maxlength - 1), 1);

            // have we already used this character in $password?
            if (!strstr($password, $char)) {
                // no, so it's OK to add it onto the end of whatever we've already got...
                $password .= $char;
                // ... and increase the counter by one
                $i++;
            }
        }

        // done!
        return $password;
    }
    
    public function newUserHash($email){
      //seed menici se kazdy den
      $srand = srand(floor(time() / (60 * 60 * 24)));
      $hash = sha1(time() . $email . (rand() % 100));
      return $hash;
    }

}