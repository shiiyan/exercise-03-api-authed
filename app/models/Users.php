<?php

use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\StringLength; 
use Phalcon\Validation\Validator\Uniqueness;

class Users extends Model {

	public function validation() {
		$validator = new Validation();

		$validator->add(
			'name',
			new StringLength(
				[
					"max" => 100,
					"messageMaximum" => "Maximum is 100 characters"
				]
			)
		);
		
		return $this->validate($validator);
	}
	
}
