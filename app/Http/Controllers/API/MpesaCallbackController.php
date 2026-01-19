<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MpesaCallbackController extends Controller
{
   public function handleStkCallback(Request $request)
{
    $data = $request->all();
    $callback = $data['Body']['stkCallback'] ?? null;

    if (!$callback) {
        return response()->json(['ResultCode' => 1, 'ResultDesc' => 'Invalid Data']);
    }

    $checkoutRequestID = $callback['CheckoutRequestID'];
    $resultCode = $callback['ResultCode'];

    $booking = Booking::where('gateway_transaction_id', $checkoutRequestID)->first();

    if (!$booking) {
        \Log::error("Mpesa Callback: Booking not found for ID $checkoutRequestID");
        return response()->json(['ResultCode' => 1, 'ResultDesc' => 'Booking not found']);
    }

    if ($resultCode == 0) {
        // Safe way to extract the Receipt Number from the Item array
        $items = $callback['CallbackMetadata']['Item'] ?? [];
        $receipt = null;

        foreach ($items as $item) {
            if ($item['Name'] === 'MpesaReceiptNumber') {
                $receipt = $item['Value'];
                break;
            }
        }

        $booking->update([
            'payment_status' => 'paid',
            'mpesa_receipt' => $receipt, // Saves "UAJ86426E8"
        ]);

        return response()->json(['ResultCode' => 0, 'ResultDesc' => 'Success']);
    }

    // Handle failure (e.g., Cancelled)
    $booking->update(['payment_status' => 'failed']);
    return response()->json(['ResultCode' => 0, 'ResultDesc' => 'Failure acknowledged']);
}
}
