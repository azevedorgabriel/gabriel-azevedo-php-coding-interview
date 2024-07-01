<?php

namespace Src\controllers;

use Src\models\BookingModel;
use Src\models\DogModel;

class Booking {

	private $dogs;

	private function getBookingModel(): BookingModel {
		return new BookingModel();
	}

	private function getDogModel(): DogModel {
		return new DogModel();
	}

	public function getBookings() {
		return $this->getBookingModel()->getBookings();
	}

	/**
	 * Description: To book a new client (considering client id, price, check-in date and check-out date)
	 * @param int $clientId
	 * @param int $price
	 * @param string $checkIn
	 * @param string $checkOut
	 * @return array
	 */
	public function createBooking($clientId, $price, $checkIn, $checkOut) {
		//if client has dogs and check average age of dogs
		if ($this->clientHasDogs($clientId) && $this->clientDeserveDiscount()) {
			//giving 10% of discount
			$price = ($price * 0.9);
		}

		return $this->getBookingModel()->createBooking($clientId, $price, $checkIn, $checkOut);
	}

	private function clientHasDogs($clientId) {
		$this->dogs = $this->getDogModel()->getDogsByClientId($clientId);

		return count($this->dogs) > 0;
	}

	/**
	 * Description: To give a 10% discount in the booking if the average age of dogs of a client registered is less than 10 years
	 * @return boolean
	 */
	private function clientDeserveDiscount() {
		$sumAgeDogs = 0;

		foreach ($this->dogs as $dog) {
			$sumAgeDogs += $dog['age'];
		}

		$average = ($sumAgeDogs / count($this->dogs));

		return $average < 10;
	}
}