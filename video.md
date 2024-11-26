# Video Skeleton

### **Intro**

### **Store Frontend Look and Feel**
- Add HTML placeholder markup for the homepage.
- Add RockCommerce.js and demonstrate the `rc-cart-count` functionality.

### **Preparing the Templates and Pages**
- Create the product template with `product_image` and `product_description` fields.
- Build a custom class `site/classes/ProductPage.php` to convert product pages into RockCommerce products.
- Create two T-shirt product pages with content (Image, description, title and price) andshow the Shop tab.
- Brief explanation of the separation between the frontend and backend in RockCommerce.
- Update the homepage product html with real products and introduce the `addToCart` magic attribute.

### **Updating the Cart**
- Walk through the `rockcommerce.php` hook file.
- Explain how the hook adds image and description data to the cart.
- Update the cart code, explaining the `deleteItem` function.

### **Payment**
- Install the Mollie module.
- Guide viewers on registering and adding the API key to `config.php`.
- Add the payment hook.
- Add the payment button HTML to call the hook.

### **Thanks Page**
- Create the Thanks template and page.
- Paste html markup.
- Explain the `rc-cart-reset` and how it resets the cart after checkout.

### **Demo**
- Walk through the complete process: adding products to the cart, checking out, and completing the payment.



# Skeleton with content

And here's the same skeleton but with the code you will need for every part.

### **Intro**

### **Store Frontend Look and Feel**
- Add HTML placeholder markup for the homepage.
- Add RockCommerce.js and demonstrate the `rc-cart-count` functionality.

```html
<?php namespace ProcessWire; ?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/uikit@3.21.13/dist/css/uikit.min.css" />
    <script
      src="<?= $config->urls->siteModules ?>RockCommerce/dst/RockCommerce.min.js"
      defer></script>
  </head>
  <body>
    <main>
      <div class="uk-container uk-container-small uk-section">
        
        <!-- Store Title -->
        <h1 id="title">T-Shirts</h1>
        
        <div class="uk-grid uk-grid-column-medium">
        
          <!-- Products region -->
          <div id="products" class="uk-width-2-3">
            <div class="uk-grid uk-grid-medium uk-child-width-expand">
              <div>
                <img src="https://placehold.co/400x400/jpg" />
                <h2>Product title</h2>
                <p>Product description.</p>
                <p><strong>€ 30,00</strong></p>
                <a class="uk-button uk-button-primary" href="">Add to cart</a>
              </div>
            </div>
          </div>
          
          <!-- Cart region -->
          <div class="uk-width-1-3">
            <div id="cart" class="uk-card uk-card-default uk-card-body">
              <p>Products added: <span rc-cart-count></span></p>
              <p>Subtotal € 0,00</p>
            </div>
          </div>
        
        </div>
      </div>
      </main>
  </body>
</html>
```

### **Preparing the Templates and Pages**
- Create the product template with `product_image` and `product_description` fields.
- Build a custom class `site/classes/ProductPage.php` to convert product pages into RockCommerce products.

```php
<?php

namespace ProcessWire;

class ProductPage extends Page
{
  use \RockCommerce\Product;
}
```

- Create two T-shirt product pages with content (Image, description, title and price) and show the Shop tab.

- **Title:** Black T-Shirt
- **Image:** [T-shirt image](https://tailwindui.com/plus/img/ecommerce-images/product-page-01-related-product-01.jpg)
- **Description:** Classic black basic tee, soft cotton, versatile and timeless.
- **Price:** 30

> Tip: By default, the currency is set to Euro. To change it, go to `Modules > Site > RockMoney`.

Also, please create another product:

- **Title:** Aspen White T-Shirt
- **Description:** Clean white Aspen tee, soft cotton, perfect for any outfit.
- **Image:** [Aspen T-shirt](https://tailwindui.com/plus/img/ecommerce-images/product-page-01-related-product-02.jpg)
- **Price:** 40 (in the Shop tab)

- Brief explanation of the separation between the frontend and backend in RockCommerce.
- Update the homepage product html with real products and introduce the `addToCart` magic attribute.

```php
<!-- Products region -->
<div id="products" class="uk-width-2-3">
  <div class="uk-grid uk-grid-medium uk-child-width-expand">

    <?php foreach (pages('template=product') as $product): ?>
      <div <?= $product->rcAttributes() ?>>
        <img src="<?= $product->product_image->url ?>" />
        <h2><?= $product->title ?></h2>
        <p><?= $product->product_description ?></p>
        <p><strong><?= $product->rockcommerce_net ?></strong></p>
        <a class="uk-button uk-button-primary" href="#" @click='addToCart'>Add to cart</a>
      </div>
    <?php endforeach; ?>

    </div>
</div>
```

### **Updating the Cart**
- Walk through the `rockcommerce.php` hook file.

```php
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

  if ($product->product_image) {
    // Add the product image URL if it exists
    $data['pic'] = $product->product_image->width(60)->url;
  }

  // Add the product description if it's available
  $data['description'] = $product->product_description ?? null;

  // Set the modified data back to the event return
  $event->return = $data;
});
```

- Explain how the hook adds image and description data to the cart.
- Update the cart code, explaining the `deleteItem` function.

```php
<!-- Cart region -->
<div class="uk-width-1-3">
  <div
    id="cart"
    class="uk-card uk-card-default uk-card-body"
    x-data="RcCart"
    rc-reload
  >
    <p>Products added: <span rc-cart-count></span></p>
    <template x-for="item in items">
      <div class="uk-flex uk-text-small">
        <div class="uk-width-1-4"><img :src="item.pic" /></div>
        <div class="uk-width-3-4 uk-padding-small uk-padding-remove-top">
          <span x-text="`${item.title} x ${item.amount}`"></span><br />
          <span x-text="item.totalNet"></span><br />
          <a href="#" @click="deleteItem(item.id)">remove</a>
        </div>
      </div>
    </template>
    <hr class="uk-divider-small" />
    <p>Subtotal <span x-text="itemsNet"></span></p>
  </div>
</div>
```


### **Payment**
- Install the Mollie module.
- Guide viewers on registering and adding the API key to `config.php`.

```php
$config->moduleInstall('download', 'debug');
$config->mollieApiKey = 'test_xxx'; //Paste your key here
```

- Add the payment hook.
```php
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
```

- Add the payment button HTML to call the hook.

```html
<form method="post" action="/payment/">
  <button
    type="submit"
    :class="count ? 'uk-button-primary' : 'uk-button-default'"
    :disabled="!count"
    class="uk-button">
      Go to payment
  </button>
</form>
```

### **Thanks Page**
- Create the Thanks template and page.
- Paste html markup.
- Explain the `rc-cart-reset` and how it resets the cart after checkout.

```html
<?php namespace ProcessWire; ?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/uikit@3.21.13/dist/css/uikit.min.css"
    />
    <script
      src="<?= $config->urls
        ->siteModules ?>RockCommerce/dst/RockCommerce.min.js"
      defer
    ></script>
  </head>
  <body>
    <main>
      <div class="uk-container uk-container-small uk-section">
        
        <!-- Title -->
        <h1 id="title">Thanks!</h1>
        
        <div class="uk-grid uk-grid-column-medium">
        
          <!-- Thanks region -->
          <div id="content" class="uk-width-2-3">
            <div class="uk-grid uk-grid-medium uk-child-width-expand">

            <p>Your order will arrive in 2 hours. We are faster than Amazon!</p>

            </div>
          </div>
          
          <!-- Cart region -->
          <div class="uk-width-1-3">
            <div
              id="cart"
              class="uk-card uk-card-default uk-card-body"
              x-data="RcCart"
              rc-reload
            >
            
              <!-- This line resets the cart! -->
              <span rc-cart-reset></span>

              <p>Products added: <span rc-cart-count></span></p>
              <template x-for="item in items">
                <div class="uk-flex uk-text-small">
                  <div class="uk-width-1-4"><img :src="item.pic" /></div>
                  <div class="uk-width-3-4 uk-padding-small uk-padding-remove-top">
                    <span x-text="`${item.title} x ${item.amount}`"></span><br />
                    <span x-text="item.totalNet"></span><br />
                    <a href="#" @click="deleteItem(item.id)">remove</a>
                  </div>
                </div>
              </template>
              <hr class="uk-divider-small" />
              <p>Subtotal <span x-text="itemsNet"></span></p>
            </div>
          </div>
        
        </div>
      </div>
    </main>
  </body>
</html>
```

### **Demo**
- Walk through the complete process: adding products to the cart, checking out, and completing the payment.
