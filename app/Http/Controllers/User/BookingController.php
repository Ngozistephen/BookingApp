<?php

namespace App\Http\Controllers\User;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookingResource;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;

class BookingController extends Controller
{
    public function index()
    {
        $this->authorize('bookings-manage');
 
        $bookings = auth()->user()->bookings()
            ->with('apartment.property')
            ->withTrashed()
            ->orderBy('start_date')
            ->get();

        return BookingResource::collection($bookings);
    }

    public function store(StoreBookingRequest $request)
    {
        $booking = auth()->user()->bookings()->create($request->validated());
    
        return new BookingResource($booking);
    }

    public function show(Booking $booking)
    {
        $this->authorize('bookings-manage');
 
        if ($booking->user_id != auth()->id()) {
            abort(403);
        }
 
        return new BookingResource($booking);
    }

    public function destroy(Booking $booking)
    {
        $this->authorize('bookings-manage');
 
        if ($booking->user_id != auth()->id()) {
            abort(403);
        }
 
        $booking->delete();
 
        return response()->noContent();
    }

    public function update(Booking $booking, UpdateBookingRequest $request)
    {
        if ($booking->user_id != auth()->id()) {
            abort(403);
        }
    
        $booking->update($request->validated());
    
        return new BookingResource($booking);
    }
}
