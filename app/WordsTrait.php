<?php

namespace App;

trait WordsTrait {

	public function removeAccentedChars($str) {
		// $transliterator = \Transliterator::createFromRules(':: NFD; :: [:Nonspacing Mark:] Remove; :: NFC;', \Transliterator::FORWARD);
		// return $transliterator->transliterate($str);
		$translated_chars = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E','Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U','Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c','è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o','ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );
		return strtr($str, $translated_chars);
	}

	public function removeInvalidCharacters($str, $more_chars = false) {
		// Replace all characters by a space except for letters, numbers and spaces
		$str = preg_replace('/[^a-z\s\d]/i', ' ', $str);
		// Remove intermediate one character word
		if(!$more_chars)
			$str = preg_replace('/\s[a-z]\s/i', ' ', $str);
		// Replace spaces by a space
		$str = preg_replace('/\s+/', ' ', $str);
		return trim($str);
	}

	public function getCharsFromWords($str, $more_chars = false) {
		$str = $this->removeAccentedChars($str);
		$str = $this->removeInvalidCharacters($str, $more_chars);
		$words = explode(' ', $str);
		$new_str = '';
		foreach ($words as $word) {
			if(strlen($word) > 1 && !$this->is_roman_number($word)) {
				$new_str .= $word[0];
				if($more_chars) {
					$new_str .= substr($word, (int)round((strlen($word) / 2) - 1, 2)) . $word[strlen($word) - 1];
				} else {
					$new_str .= $word[(int)round((strlen($word) / 2) - 1)];
				}
			} else {
				$new_str .= $word;
			}
		}
		
		return strtoupper($new_str);
	}

	public function is_roman_number($string) {
		return preg_match('/^[IVXLCDM]+$/', $string);
	}
}