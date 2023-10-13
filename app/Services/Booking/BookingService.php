<?php

namespace App\Services\Booking;

use App\Http\Resources\Booking\BookingResource;
use App\Models\Booking\Booking;
use FFI\Exception;

class BookingService
{
    protected $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function paginate($limit, $request)
    {
        $bookings = $this->booking->where(function ($query) use ($request) {

            if ($request->filled('title')) {
                $query->where('title', 'like', '%' . $request->title . '%');
            }

            if ($request->filled('is_active')) {
                $query->whereIsActive($request->is_active);
            }
        })->orderBy('id', 'DESC');

        $bookings = $bookings->paginate($limit);

        return BookingResource::collection($bookings);
    }

    public function find($id)
    {
        $booking = $this->booking->find($id);
        return new BookingResource($booking);
    }

    public function store($data)
    {
        try {
            return $this->booking->create($data);
        } catch (Exception $e) {
            return false;
        }
    }

    public function update($data, $id)
    {
        try {
            $booking = $this->find($id);
            return $booking->update($data);
        } catch (Exception $e) {
            return false;
        }
    }

    public function delete($id)
    {
        try {
            $booking = $this->find($id);
            return $booking->delete($id);
        } catch (Exception $e) {
            return false;
        }
    }
}
