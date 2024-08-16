<?php

namespace App\Http\Controllers;
use Explicador\E2PaymentsPhpSdk\Mpesa;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function handlePayment(Request $request) {
        // Set the consumer key and consumer secret as follows
        $mpesa = new Mpesa();
        $mpesa->setClientId('9610234b-9e7e-4935-9557-c6770e7b0c72');
        $mpesa->setClientSecret('sBNnN5aa3VjZ38koBkJnIgSkMtoV3vyrO6hIkd8V');
        $mpesa->setWalletId('728381');// 'live' production environment 

        //This creates transaction between an M-Pesa short code to a phone number registered on M-Pesa.
        $phone_number = '844503505';
        $amount = 670;
        $reference = 'iMac';
        $result = $mpesa->c2b($phone_number, $amount, $reference);

        dd($result);
    }
}
