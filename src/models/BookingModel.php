<?php

namespace Src\models;
use Src\helpers\Helpers;

class BookingModel {

	private $bookingData;
	private $helper;

	public function __construct() {
		$this->helper = new Helpers();
		$string = file_get_contents(dirname(__DIR__) . '/../scripts/bookings.json');
		$this->bookingData = json_decode($string, true);
	}

	public function getBookings() {
		return $this->bookingData;
	}

	public function createBooking($clientId, $price, $checkIn, $checkOut) {
		$bookings = $this->getBookings();

		$data = [
			"clientid" => $clientId,
			"price" => $price,
			"checkindate" => $checkIn,
			"checkoutdate" => $checkOut
		];

		$data['id'] = end($bookings)['id'] + 1;

		$bookings[] = $data;

		$this->helper->putJson($bookings, 'bookings');

		return $data;
	}
}