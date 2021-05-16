<?php

namespace App\Services;


class Payement {

    public function checkout($total){
        \Stripe\Stripe::setApiKey('sk_test_51IrUFOIPqsC3XcMtWqQrKCcHNcaQBh3qjY5CDNRhLgYLzYlCxS3VGDYUQjVdJsK9sZCnvOq1EuT5dBGezn1H04Ns00ZrM6FeNX');
        header('Content-Type: application/json');
        $YOUR_DOMAIN = 'http://localhost:8082';
        $checkout_session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                'currency' => 'usd',
                'unit_amount' => $total,
                'product_data' => [
                    'name' => 'Stubborn Attachments',
                    'images' => ["https://i.imgur.com/EHyR2nP.png"],
                ],
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
                'success_url' => $YOUR_DOMAIN . '/panier/payementy/success',
            'cancel_url' => $YOUR_DOMAIN . '/cancel.html',
            ]);

            return $checkout_session;
    }
}