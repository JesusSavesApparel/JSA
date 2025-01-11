let cart = JSON.parse(localStorage.getItem('cart')) || [];

function saveCart() {
    localStorage.setItem('cart', JSON.stringify(cart));
}

function renderCart() {
    const cartContainer = document.getElementById('cart-items');
    if (!cartContainer) return;

    cartContainer.innerHTML = '';

    // Render cart items
    cart.forEach((item, index) => {
        const cartItem = document.createElement('li');
        cartItem.classList.add('cart-item');
        cartItem.innerHTML = `
            <img src="${item.image}" alt="${item.name}" class="cart-item-image">
            <div class="cart-item-details">
                <h4>${item.name}</h4>
                <p>Price: $${item.price.toFixed(2)}</p>
                <p>Quantity: <input type="number" value="${item.quantity}" data-index="${index}" min="1" class="quantity-input"></p>
            </div>
            <div class="cart-item-price">$${(item.price * item.quantity).toFixed(2)}</div>
            <button class="remove" data-index="${index}">Remove</button>
        `;
        cartContainer.appendChild(cartItem);
    });

    // Calculate and display total price
    const totalPrice = cart.reduce((total, item) => total + item.price * item.quantity, 0);
    document.querySelector('.cart-total .cart-item-price').textContent = `$${totalPrice.toFixed(2)}`;

    // Add event listeners for quantity change and remove buttons
    cartContainer.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', (e) => {
            const index = e.target.dataset.index;
            const newQuantity = Math.max(1, parseInt(e.target.value)); // Prevent quantity below 1
            cart[index].quantity = newQuantity;
            saveCart();
            renderCart();
            updateCartCount();
        });
    });

    cartContainer.querySelectorAll('.remove').forEach(button => {
        button.addEventListener('click', (e) => {
            const index = e.target.dataset.index;
            cart.splice(index, 1); // Remove item from cart
            saveCart();
            renderCart();
            updateCartCount();
        });
    });
}

function updateCartCount() {
    const cartCount = cart.reduce((total, item) => total + item.quantity, 0);
    document.getElementById('cart-count').textContent = cartCount;
}

// Add product to cart
function addToCart(product) {
    const existingProductIndex = cart.findIndex(item => item.id === product.id);
    if (existingProductIndex !== -1) {
        // If product already in cart, increase quantity
        cart[existingProductIndex].quantity += 1;
    } else {
        // Otherwise, add new product to cart
        cart.push(product);
    }
    saveCart();
    alert(`${product.name} added to cart!`); // Notify user
    renderCart();
    updateCartCount();
}

// Initialization
document.addEventListener('DOMContentLoaded', () => {
    // Add event listener for "Add to Cart" buttons
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', () => {
            const productElement = button.closest('.product-section');
            const product = {
                id: button.getAttribute('data-id'),
                name: button.getAttribute('data-name'),
                price: parseFloat(button.getAttribute('data-price')),
                quantity: 1,
                image: productElement.querySelector('img').src
            };
            addToCart(product);
        });
    });

    // Render cart on "View Cart" page
    if (document.getElementById('cart-items')) {
        renderCart();
    }

    // Update cart count on page load
    updateCartCount();
});
