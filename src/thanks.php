<?php namespace ProcessWire; ?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- UIkit CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.21.16/dist/css/uikit.min.css" />
    <!-- UIkit JS -->
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.21.16/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.21.16/dist/js/uikit-icons.min.js"></script>
    <!-- RockCommerce JS -->
    <script
      src="<?= $config->urls
        ->siteModules ?>RockCommerce/dst/RockCommerce.min.js"
      defer
    ></script>
  </head>
  <body>
    <header class="uk-navbar-container uk-padding-small">
      <nav class="uk-container uk-container-small uk-flex ">
        <div class="uk-navbar-left uk-text-bolder">🚀👕 RockTees</div>
        <div class="uk-navbar-right">
          <a href="#" class="uk-text-primary"> 
            <span uk-icon="icon: bag"></span> Cart items: <span rc-cart-count></span>
          </a>
        </div>
      </nav>
    </header>
    <main>
      <div class="uk-container uk-container-small uk-section">
        <h1>Thanks a ton!</h1>
        <p>Your order will arrive in 2 hours. 🚀 We are FasTees than Amazon! 🛍️</p>
        <!-- This line resets the cart! -->
        <span rc-cart-reset></span>
      </div>
    </main>
  </body>
</html>
