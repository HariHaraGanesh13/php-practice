// Product data
const products = {
    1: {
        name: 'Nike Air Force',
        image: 'https://images.unsplash.com/photo-1606107557195-0e29a4b5b4aa?w=100'
    },
    2: {
        name: 'New Balance 574 Classic',
        image: 'https://images.unsplash.com/photo-1539185441755-769473a23570?w=100'
    },
    3: {
        name: 'Puma RS-X Reinvention',
        image: 'https://images.unsplash.com/photo-1608231387042-66d1773070a5?w=100'
    }
};

// State
let cart = [];
let wishlist = [];
let pendingAction = null;

// ========== CART FUNCTIONS ==========

// Add to Cart
function addToCart(productId) {
    if (cart.includes(productId)) {
        return;
    }
    cart.push(productId);
    updateCartUI();
    updateProductButton(productId);
}

// Remove from Cart with confirmation
function removeFromCart(productId) {
    const productName = products[productId].name;
    pendingAction = { type: 'cart', productId };
    showModal(
        '🛒',
        'Remove from Cart?',
        `Are you sure you want to remove "${productName}" from your cart?`,
        function () {
            cart = cart.filter(function (id) {
                return id !== productId;
            });
            updateCartUI();
            updateProductButton(productId);
        }
    );
}

// Update Cart UI
function updateCartUI() {
    const cartContainer = document.getElementById('cart-items');
    const cartCount = document.getElementById('cart-count');

    cartCount.textContent = cart.length;

    if (cart.length === 0) {
        cartContainer.innerHTML = '<p class="empty-message">Your cart is empty</p>';
        return;
    }

    cartContainer.innerHTML = cart.map(function (id) {
        const product = products[id];
        return `
            <div class="item">
                <img src="${product.image}" alt="${product.name}" class="item-image">
                <div class="item-info">
                    <p class="item-name">${product.name}</p>
                </div>
                <button class="item-remove" onclick="removeFromCart(${id})">Remove</button>
            </div>
        `;
    }).join('');
}

// Update Product Button State
function updateProductButton(productId) {
    const card = document.querySelector(`.product-card[data-id="${productId}"]`);
    const addToCartBtn = card.querySelector('.btn-cart');

    if (cart.includes(productId)) {
        addToCartBtn.disabled = true;
        addToCartBtn.textContent = 'Added to Cart ✓';
    } else {
        addToCartBtn.disabled = false;
        addToCartBtn.textContent = 'Add to Cart';
    }
}

// ========== WISHLIST FUNCTIONS ==========

// Toggle Wishlist with confirmation for removal
function toggleWishlist(productId) {
    const productName = products[productId].name;
    const index = wishlist.indexOf(productId);

    if (index > -1) {
        pendingAction = { type: 'wishlist', productId };
        showModal(
            '❤️',
            'Remove from Wishlist?',
            `Are you sure you want to remove "${productName}" from your wishlist?`,
            function () {
                wishlist.splice(index, 1);
                updateWishlistUI();
                updateWishlistButton(productId);
            }
        );
    } else {
        wishlist.push(productId);
        updateWishlistUI();
        updateWishlistButton(productId);
    }
}

// Remove from Wishlist with confirmation
function removeFromWishlist(productId) {
    const productName = products[productId].name;
    pendingAction = { type: 'wishlist', productId };
    showModal(
        '❤️',
        'Remove from Wishlist?',
        `Are you sure you want to remove "${productName}" from your wishlist?`,
        function () {
            wishlist = wishlist.filter(function (id) {
                return id !== productId;
            });
            updateWishlistUI();
            updateWishlistButton(productId);
        }
    );
}

// Update Wishlist UI
function updateWishlistUI() {
    const wishlistContainer = document.getElementById('wishlist-items');
    const wishlistCount = document.getElementById('wishlist-count');

    wishlistCount.textContent = wishlist.length;

    if (wishlist.length === 0) {
        wishlistContainer.innerHTML = '<p class="empty-message">Your wishlist is empty</p>';
        return;
    }

    wishlistContainer.innerHTML = wishlist.map(function (id) {
        const product = products[id];
        return `
            <div class="item">
                <img src="${product.image}" alt="${product.name}" class="item-image">
                <div class="item-info">
                    <p class="item-name">${product.name}</p>
                </div>
                <button class="item-remove" onclick="removeFromWishlist(${id})">Remove</button>
            </div>
        `;
    }).join('');
}

// Update Wishlist Button State
function updateWishlistButton(productId) {
    const heart = document.getElementById(`heart-${productId}`);
    const btn = document.getElementById(`wishlist-btn-${productId}`);

    if (wishlist.includes(productId)) {
        heart.textContent = '❤️';
        btn.classList.add('active');
    } else {
        heart.textContent = '🤍';
        btn.classList.remove('active');
    }
}

// ========== MODAL FUNCTIONS ==========

// Show Modal
function showModal(icon, title, message, onConfirm) {
    document.getElementById('modal-icon').textContent = icon;
    document.getElementById('modal-title').textContent = title;
    document.getElementById('modal-message').textContent = message;
    document.getElementById('modal-overlay').classList.add('active');
    pendingAction = { onConfirm: onConfirm };
}

// Close Modal
function closeModal() {
    document.getElementById('modal-overlay').classList.remove('active');
    pendingAction = null;
}

// Confirm Modal Action
function confirmModal() {
    if (pendingAction && pendingAction.onConfirm) {
        pendingAction.onConfirm();
    }
    closeModal();
}

// Close modal on overlay click
document.getElementById('modal-overlay').addEventListener('click', function (e) {
    if (e.target === this) {
        closeModal();
    }
});

// ========== INITIALIZE ==========
updateCartUI();
updateWishlistUI();