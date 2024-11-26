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
