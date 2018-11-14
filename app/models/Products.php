<?php

use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\StringLength; 
use Phalcon\Validation\Validator\Uniqueness;

class Products extends Model {

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

		$validator->add(
			'detail',
			new StringLength(
				[
					"max" => 500,
					"messageMaximum" => "Maximum is 500 characters"
				]
			)
		);

		$validator->add(
			'name',
			new Uniqueness(
				[
					'message' => 'name must be unique',
				]
			)
		);

		return $this->validate($validator);
	}
	
}











