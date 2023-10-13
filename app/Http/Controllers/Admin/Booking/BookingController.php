<?php

namespace App\Http\Controllers\Admin\Booking;

use App\Http\Controllers\Controller;
use App\Http\Requests\Booking\BookingRequest;
use App\Services\Booking\BookingService;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    protected $booking;

    public function __construct(BookingService $booking)
    {
        $this->booking = $booking;
    }

    public function index(Request $request)
    {
        return $this->booking->paginate(20, $request);
    }

    public function store(BookingRequest $request)
    {
        $booking = $this->booking->store($request->all());
        if ($booking)
            return response(['status' => "OK"], 200);
        return response(['status' => "ERROR"], 500);
    }

    public function show($id)
    {
        if ($booking = $this->booking->find($id))
            return response(['status' => "OK", 'booking' => $booking], 200);
        return response(['status' => "ERROR"], 500);
    }

    public function update(BookingRequest $request, $id)
    {
        $booking = $this->booking->update($request->all(), $id);
        if ($booking)
            return response(['status' => "OK"], 200);
        return response(['status' => "ERROR"], 500);
    }

    public function destroy($id)
    {
        if ($this->booking->delete($id))
            return response(['status' => "OK"], 200);
        return response(['status' => "ERROR"], 500);
    }
}
