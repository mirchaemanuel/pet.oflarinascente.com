<?php

declare(strict_types=1);

namespace App\Actions\Bookings;

use App\Data\BookingData;
use App\Enums\BookingStatus;
use App\Models\Booking;

class CreateBookingAction
{
    public function execute(BookingData $data): Booking
    {
        return Booking::create([
            'service_id' => $data->serviceId,
            'pet_name' => $data->petName,
            'pet_species' => $data->petSpecies,
            'pet_breed' => $data->petBreed,
            'pet_weight_kg' => $data->petWeightKg,
            'customer_name' => $data->customerName,
            'customer_email' => $data->customerEmail,
            'customer_phone' => $data->customerPhone,
            'customer_address' => $data->customerAddress,
            'preferred_date' => $data->preferredDate,
            'preferred_time' => $data->preferredTime,
            'message' => $data->message,
            'special_requests' => $data->specialRequests,
            'status' => BookingStatus::Pending,
        ]);
    }
}
