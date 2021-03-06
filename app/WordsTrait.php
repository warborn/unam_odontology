<?php

namespace App;

trait WordsTrait {

	public function removeAccentedChars($str) {
		// $transliterator = \Transliterator::createFromRules(':: NFD; :: [:Nonspacing Mark:] Remove; :: NFC;', \Transliterator::FORWARD);
		// return $transliterator->transliterate($str);
		$translated_chars = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E','Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U','Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c','è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o','ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );
		return strtr($str, $translated_chars);
	}

	public function removeInvalidCharacters($str) {
		// Replace all characters by a space except for letters, numbers and spaces
		$str = preg_replace('/[^a-z\s\d]/i', ' ', $str);
		// Remove intermediate one character word
		$str = preg_replace('/\s[aoyu]\s/', ' ', $str);
		// Remove spanish word "de" from string
		$str = preg_replace('/\sde\s/i', ' ', $str);
		// Replace spaces by a space
		$str = preg_replace('/\s+/', ' ', $str);
		return trim($str);
	}

	public function getCharsFromWords($str, $number_chars = 2)
	{
		$str = $this->removeAccentedChars($str);
		$str = $this->removeInvalidCharacters($str);
		$words = explode(' ', $str);
		if(count($words) == 1) return strtoupper($words[0]);
		$new_str = '';
		foreach ($words as $word) {
			if(strlen($word) > 1 && !$this->is_roman_number($word)) {
				$new_str .= $word[0];
				if($number_chars < 4) { 
					$new_str .= $this->middleChars($word, $number_chars - 1);
				} else {
					$new_str .= $this->middleChars($word, $number_chars - 2) . $word[strlen($word) - 1];
				}
			} else {
				$new_str .= $word;
			}
		}
		return strtoupper($new_str);
	}

	public function middleChars($str, $length) {
		return substr($str, (int)round((strlen($str) / 2) - 1), $length);
	}

	public function is_roman_number($string) {
		return preg_match('/^[IVXLCDM]+$/', $string);
	}
}