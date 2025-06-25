document.addEventListener('DOMContentLoaded', function() {
    // Add to cart functionality
    const addToCartButtons = document.querySelectorAll('.add-to-cart');

    addToCartButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-product-id');

            fetch('/cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `product_id=${productId}&quantity=1`
            })
            .then(response => response.text())
            .then(data => {
                // Update cart count in navbar
                const cartCount = document.querySelector('.cart-count');
                if (cartCount) {
                    const currentCount = parseInt(cartCount.textContent) || 0;
                    cartCount.textContent = currentCount + 1;
                } else {
                    // Create cart count if it doesn't exist
                    const cartIcon = document.querySelector('.cart-icon');
                    if (cartIcon) {
                        const countSpan = document.createElement('span');
                        countSpan.className = 'cart-count';
                        countSpan.textContent = '1';
                        cartIcon.appendChild(countSpan);
                    }
                }

                // Show success message
                alert('Product added to cart!');
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to add product to cart');
            });
        });
    });

    // Search functionality
    const searchForm = document.querySelector('.search-bar form');
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            const searchInput = this.querySelector('input[name="search"]');
            if (searchInput.value.trim() === '') {
                e.preventDefault();
            }
        });
    }

    // Mobile menu toggle (for responsive design)
    const mobileMenuToggle = document.createElement('button');
    mobileMenuToggle.className = 'mobile-menu-toggle';
    mobileMenuToggle.innerHTML = '<i class="fas fa-bars"></i>';

    const header = document.querySelector('.header .container');
    if (header) {
        header.insertBefore(mobileMenuToggle, header.firstChild);

        mobileMenuToggle.addEventListener('click', function() {
            const nav = document.querySelector('.nav');
            if (nav) {
                nav.classList.toggle('active');
            }
        });
    }
});
