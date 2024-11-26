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
        
        <!-- Store Title -->
        <h1 id="title">T-Shirts</h1>
        
        <div class="uk-grid uk-grid-column-medium">
        
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
              <form method="post" action="/payment/">
                <button
                  type="submit"
                  :class="count ? 'uk-button-primary' : 'uk-button-default'"
                  :disabled="!count"
                  class="uk-button">
                    Go to payment
                </button>
              </form>
            </div>
          </div>
        
        </div>
      </div>
    </main>
  </body>
</html>
