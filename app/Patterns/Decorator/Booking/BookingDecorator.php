<?php
namespace App\Patterns\Decorator\Booking;

abstract class BookingDecorator implements BookingDecoratorInterface
{
    public function __construct(
        protected BookingDecoratorInterface $bookingDecoratorInterface
    ){}
}