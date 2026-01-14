<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
public function show(Booking $booking){
    if($booking->rating || $booking->status !=='completed'){
        return redirect('/')->with('message','Feedback already received. Thank you!');
    }
    return view('booking.rate', compact('booking'));

}

public function store(Request $request, Booking $booking){
    $data = $request->validate([
        'rating'=>'required|integer|min:1|max:5',
        'feedback_Comment'=>'nullable|string|max:500',
    ]);
    $booking->update($data);

    return view('booking.thank-you-feedback')->with('message','Feedback has been received!');
}
}
