<?php

namespace App\Http\Controllers;


use App\Mail\PriceAlertMail;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function sendPriceTargetMail($product, $user, $target)
    {
        $subject = 'Target Price Reached for ' . $product->name . '!';

        Mail::to($user->email)->send(new PriceAlertMail($subject, $product, $user, $target));

        return "Email sent successfully!";
    }
}
