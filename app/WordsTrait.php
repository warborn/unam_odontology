<?php

namespace App;

trait WordsTrait {

	public function removeAccentedChars($str) {
		$transliterator = \Transliterator::createFromRules(':: NFD; :: [:Nonspacing Mark:] Remove; :: NFC;', \Transliterator::FORWARD);
		return $transliterator->transliterate($str);
	}

	public function removeInvalidCharacters($str) {
		// Replace all characters by a space except for letters, numbers and spaces
		$str = preg_replace('/[^a-z\s\d]/i', ' ', $str);
		// Remove intermediate one character word
		$str = preg_replace('/\s[a-z]\s/i', ' ', $str);
		// Replace spaces by a space
		$str = preg_replace('/\s+/', ' ', $str);
		return trim($str);
	}

	public function getCharsFromWords($str) {
		$str = $this->removeAccentedChars($str);
		$str = $this->removeInvalidCharacters($str);
		$words = explode(' ', $str);
		$new_str = '';
		foreach ($words as $word) {
			if(strlen($word) > 1) {
				$new_str .= $word[0] . $word[(int)round((strlen($word) / 2) - 1)];
			} else {
				$new_str .= $word;
			}
		}
		return strtoupper($new_str);
	}
}