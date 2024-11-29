<?php namespace ProcessWire;

// Add a hook to modify the Items array
wire()->addHookAfter('Item::getJsonArray', function ($event) {
  $data = $event->return;

  // Get the product page using the ID in the data
  $product = wire()->pages->get($data['product']);
  if (!$product->id) {
    // Return if the product doesn't exist
    return;
  }

  if ($product->rockcommerce_productfields->product_image) {
    // Add the product image URL if it exists
    $data['pic'] = $product->rockcommerce_productfields->product_image->width(
      60
    )->url;
  }

  // Add the product description if it's available
  $data['description'] =
    $product->rockcommerce_productfields->product_description ?? null;

  // Set the modified data back to the event return
  $event->return = $data;
});

// Add a hook to handle form submissions at the '/payment/' URL
wire()->addHook('/payment/', function ($event) {
  // Create a new order using RockCommerce cart
  $order = rockcommerce()->cart()->createOrder('New Order');

  // Create a payment for the order and set '/thanks/' as the redirect URL after payment
  $payment = $order->createPayment('/thanks/');

  // If the payment was successfully created, redirect to the checkout URL
  if ($payment) {
    wire()->session->redirect($payment->getCheckoutUrl());
  } else {
    throw new WireException('Payment creation failed.');
  }
});
