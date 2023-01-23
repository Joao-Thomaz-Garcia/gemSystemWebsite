<?php
include 'vendor/stripe/stripe-php/init.php';
require 'vendor/autoload.php';

class StripeService
{

  private $client;

  public function __construct()
  {
    $this->client = new \Stripe\StripeClient(
      'sk_test_51M75igLDunJKo5PYS7EZAfZoIhg7Se76S1N2GQJeLQWK02xehLKMT9OPNfFZRguduxjBJmkdfz3zvBRN9lLn7u8b00rQkkRSft'
    );
  }

  public function createProduct($id, $name, $image = null)
  {
    $data = [
      'id' => $id,
      'name' => $name,
    ];
    if (isset($image)) {
      $data['images'] = [$image];
    }
    return $this->client->products->create($data);
  }

  public function getProduct($id)
  {
    try {
      return $this->client->products->retrieve($id);
    } catch (\Stripe\Exception\InvalidRequestException $e) {
      if ($e->getHttpStatus() == 404) {
        return null;
      }
      throw $e;
    }
  }

  public function createPrice($productId, $value)
  {
    return $this->client->prices->create([
      'unit_amount' => $value,
      'currency' => 'usd',
      'product' => $productId,
    ]);
  }

  public function startCheckout($priceId)
  {
    $url = 'http://localhost/stripe/';
    return $this->client->checkout->sessions->create([
      'success_url' => $url . 'public/success.html',
      'cancel_url' => $url . 'public/cancel.html',
      'line_items' => [
        [
          'price' => $priceId,
          'quantity' => 1,
        ],
      ],
      'mode' => 'payment',
    ]);
  }
}
