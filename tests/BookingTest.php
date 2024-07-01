<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Src\controllers\Booking;

class BookingTest extends TestCase {

	private $booking;

	/**
	 * Setting default data
	 * @throws \Exception
	 */
	public function setUp(): void {
		parent::setUp();
		$this->booking = new Booking();
	}

	/** @test */
	public function getBookings() {
		$results = $this->booking->getBookings();

		$this->assertIsArray($results);
		$this->assertIsNotObject($results);

		$this->assertEquals($results[0]['id'], 1);
		$this->assertEquals($results[0]['clientid'], 1);
		$this->assertEquals($results[0]['price'], 200);
		$this->assertEquals($results[0]['checkindate'], '2021-08-04 15:00:00');
		$this->assertEquals($results[0]['checkoutdate'], '2021-08-11 15:00:00');
	}

	/** @test */
	public function createBooking() {
		$clientId = 1;
		$price = 500;
		$checkIn = '2024-07-01 15:00:00';
		$checkOut = '2024-07-05 10:00:00';

		$this->booking->createBooking($clientId, $price, $checkIn, $checkOut);
		$results = $this->booking->getBookings();

		$this->assertIsArray($results);
	}

	/** @test */
	public function createBookingWithDiscount() {
		$clientId = 1;
		$price = 500;
		$checkIn = '2024-07-01 15:00:00';
		$checkOut = '2024-07-05 10:00:00';

		$booking = $this->booking->createBooking($clientId, $price, $checkIn, $checkOut);
		$results = $this->booking->getBookings();

		$this->assertIsArray($results);

		$bookingWithDiscount = end($results);

		$this->assertEquals($bookingWithDiscount['id'], $booking['id']);
		$this->assertEquals($bookingWithDiscount['clientid'], 1);
		$this->assertEquals($bookingWithDiscount['price'], 450);
		$this->assertEquals($bookingWithDiscount['checkindate'], '2024-07-01 15:00:00');
		$this->assertEquals($bookingWithDiscount['checkoutdate'], '2024-07-05 10:00:00');
	}

	/** @test */
	public function createBookingWithoutDiscount() {
		$clientId = 3;
		$price = 500;
		$checkIn = '2024-07-01 15:00:00';
		$checkOut = '2024-07-05 10:00:00';

		$booking = $this->booking->createBooking($clientId, $price, $checkIn, $checkOut);
		$results = $this->booking->getBookings();

		$this->assertIsArray($results);

		$bookingWithoutDiscount = end($results);

		$this->assertEquals($bookingWithoutDiscount['id'], $booking['id']);
		$this->assertEquals($bookingWithoutDiscount['clientid'], 3);
		$this->assertEquals($bookingWithoutDiscount['price'], 500);
		$this->assertEquals($bookingWithoutDiscount['checkindate'], '2024-07-01 15:00:00');
		$this->assertEquals($bookingWithoutDiscount['checkoutdate'], '2024-07-05 10:00:00');
	}
}