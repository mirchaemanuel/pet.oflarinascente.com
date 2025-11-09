<?php

declare(strict_types=1);

namespace App\Services;

use App\Actions\Bookings\CreateBookingAction;
use App\Data\BookingData;
use App\Enums\BookingStatus;
use App\Models\Booking;

class BookingService
{
    public function __construct(
        private readonly CreateBookingAction $createAction,
    ) {}

    /**
     * Create a new booking
     */
    public function createBooking(BookingData $data): Booking
    {
        // TODO: Send notification email to customer
        // TODO: Send notification email to admin

        return $this->createAction->execute($data);
    }

    /**
     * Confirm a booking
     */
    public function confirmBooking(Booking $booking): Booking
    {
        $booking->confirm();

        // TODO: Send confirmation email to customer

        return $booking->fresh();
    }

    /**
     * Cancel a booking
     */
    public function cancelBooking(Booking $booking, ?string $reason = null): Booking
    {
        $booking->cancel();

        if ($reason) {
            $booking->update(['notes' => $booking->notes."\nCancellation reason: ".$reason]);
        }

        // TODO: Send cancellation email to customer

        return $booking->fresh();
    }

    /**
     * Complete a booking
     */
    public function completeBooking(Booking $booking): Booking
    {
        $booking->complete();

        return $booking->fresh();
    }

    /**
     * Get pending bookings count
     */
    public function getPendingCount(): int
    {
        return Booking::where('status', BookingStatus::Pending)->count();
    }
}
