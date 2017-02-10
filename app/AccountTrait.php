<?php

namespace App;

trait AccountTrait {
	public function account(Clinic $clinic) {
    return $this->user->accounts()->fromClinic($clinic)->first();
  }
}