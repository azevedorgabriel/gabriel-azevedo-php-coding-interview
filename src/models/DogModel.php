<?php

namespace Src\models;

use Src\helpers\Helpers;

class DogModel {

	private $dogData;
	private $helper;

	function __construct() {
		$this->helper = new Helpers();
		$string = file_get_contents(dirname(__DIR__) . '/../scripts/dogs.json');
		$this->dogData = json_decode($string, true);
	}

	public function getDogs() {
		return $this->dogData;
	}

	public function getDogsByClientId($clientId) {
		$dogs = [];

		foreach ($this->dogData as $dog) {
			if ($dog['clientid'] == $clientId) {
				$dogs[] = $dog;
			}
		}

		return $dogs;
	}
}