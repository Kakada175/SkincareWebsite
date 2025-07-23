
document.addEventListener('DOMContentLoaded', () => {
    // 1. Hamburger Menu Toggle
    const hamburgerMenu = document.querySelector('.hamburger-menu');
    const mainNav = document.querySelector('.main-nav');
    const navLinks = document.querySelectorAll('.nav-links a');

    hamburgerMenu.addEventListener('click', () => {
        hamburgerMenu.classList.toggle('active');
        mainNav.classList.toggle('active');
    });

    // Close mobile menu when a link is clicked
    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            if (mainNav.classList.contains('active')) {
                hamburgerMenu.classList.remove('active');
                mainNav.classList.remove('active');
            }
        });
    });

    // 2. Product Data (Simulated from the image)
    const productsData = [
        // Top Row (assuming first few are Madagascar Centella Hyalu-Cica range)
        { id: 1, name: "Madagascar Centella Poremizing Clear Toner(210ml)", price: 25.00, oldPrice: 30.00, image: "image/skin1004-madagascar-centella-poremizing-clear-toner-210ml-5_1080x.webp?text=Product+1", badge: "New" },
        { id: 2, name: "Madagascar Centella Toning Toner (210ml)", price: 28.00, image: "image/skin1004-toner-centella-toning-toner-38642837750006_1440x.webp?text=Product+2" },
        { id: 3, name: "Madagascar Centella Tone Brightening Boosting Toner (210ml)", price: 22.00, image: "image/skin1004-madagascar-centella-tone-brightening-boosting-toner-210ml.png?text=Product+3" },
        { id: 4, name: "SKIN1004, Madagascar Centella Probio Cica Essence Toner(210ml)", price: 20.00, image: "image/skin1004-madagascar-centella-probio-cica-essence-toner-210ml.png?text=Product+4", badge: "Bestseller" },
        // Second Row
        { id: 5, name: "Madagascar Centella tea-trica purifying toner (210ml)", price: 35.00, image: "image/skin1004-toner-210ml-tea-trica-purifying-toner.webp?text=Product+5" },
        { id: 6, name: "Madagascar Centella Light Cleansing Oil (200ml)", price: 29.00, image: "image/skin1004-cleanser-centella-light-cleansing-oil.webp?text=Product+6" },
        { id: 7, name: "Madagascar Centella Ampole Foam", price: 24.00, oldPrice: 28.00, image: "image/skin1004-madagascar-centella-ampoule-foam-125ml.png?text=Product+7" },
        { id: 8, name: "Madagascar Centella Poremizing Deep Cleansing Foam", price: 26.00, image: "image/skin1004-madagascar-centella-poremizing-deep-cleansing-foam-125ml.png?text=Product+8" },
        // More products to fill the grid (just dummy names)
        { id: 9, name: "Madagascar Centella Tone Brightening Cleansing Gel Foam(125ml)", price: 32.00, image: "image/skin1004-madagascar-centella-tone-brightening-cleansing-gel-foam-125ml.png?text=Product+9" },
        { id: 10, name: "Madagascar Centella Tea Trica BHA Foam (125ml)", price: 30.00, image: "image/SKIN1004_Madagascar_Centella_Tea-Trica_BHA_Foam_125ml.png?text=Product+10" },
        { id: 11, name: "Madagascar Centella Quick Calming Pad(100ml)", price: 27.00, image: "image/skin1004-madagascar-centella-quick-calming-pad.png?text=Product+11" },
        { id: 12, name: "Madagascar Centella Probio Cica Enrich Cream (50ml)", price: 21.00, image: "image/skin1004-madagascar-centella-probio-cica-enrich-cream-50ml.png?text=Product+12", badge: "Sale" },
        { id: 13, name: "Madagascar Centella Water-Fit Sun Serum (50ml)", price: 20.00, image: "image/Skin1004_Madagascar_Centella_Cream_75ml.png?text=Product+13" },
        { id: 14, name: "Madagascar Centella Cream (75ml)", price: 20.00, image: "image/skin1004-madagascar-centella-tone-brightening-capsule-cream-75ml.png?text=Product+14" },
        { id: 15, name: "Madagascar Centella Soothing Cream (75ml)", price: 24.00, oldPrice: 28.00, image: "image/skin1004-madagascar-centella-soothing-cream-75ml.png?text=Product+15" },
        { id: 16, name: "Madagascar Centella Tea Trica B5 Cream (75ml)", price: 26.00, image: "image/SKIN1004-Madagascar-Centella-Tea-Trica-B5-Cream.png?text=Product+16" },
        // Add more products to match the visual count
        { id: 17, name: "Madagascar Centella Poremizing Light Gel Cream (75ml)", price: 35.00, image: "image/SKIN1004_Madagascar_Centella_Poremizing_Light_Gel-Cream_75ml.png?text=Product+17" },
        { id: 18, name: "Madagascar Centella Probio Cica Glow Sun Ampoule (50ml)", price: 29.00, image: "image/SKIN1004_Madagascar_Centella_Probio-Cica_Glow_Sun_Ampoule_50ml.png?text=Product+18" },
        { id: 19, name: "Madagascar Centella Hyalu-Cica First Ampoule (100ml)", price: 24.00, image: "image/skin1004-madagascar-centella-hyalu-cica-first-ampoule-100ml.png?text=Product+19" },
        { id: 20, name: "Madagascar Centella Tea Trica Relief Ampoule (100ml)", price: 26.00, image: "image/skin1004-madagascar-centella-tea-trica-relief-ampoule-100ml.png?text=Product+20" },
        { id: 21, name: "Madagascar Centella Poremizing Fresh Ampoule (100ml)", price: 26.00, image: "image/skin1004-madagascar-centella-poremizing-fresh-ampoule-100ml.png?text=Product+21" },
        { id: 22, name: "Madagascar Centella Tone Brightening Capsule Ampoule(100ml)", price: 26.00, image: "image/skin1004-madagascar-centella-tone-brightening-capsule-ampoule-100ml.png?text=Product+22" },
        { id: 23, name: "Madagascar Centella Hyalu Cica Blue Serum (50ml)", price: 26.00, image: "image/skin1004-madagascar-centella-hyalu-cica-blue-serum-50ml.png?text=Product+23" },
        { id: 24, name: "Madagascar Centella Hyalu Cica Water Fit Sun Serum (50ml)", price: 26.00, image: "image/SKIN1004_Madagascar_Centella_Hyalu-Cica_Water-Fit_Sun_Serum_50ml.png?text=Product+24" },
        { id: 25, name: "Madagascar Centella Probio Cica Bakuchiol Eye Cream (20ml)", price: 26.00, image: "image/skin1004-madagascar-centella-probio-cica-bakuchiol-eye-cream-20ml.png?text=Product+25" },
        { id: 26, name: "Madagascar Centella Tea Trica Soothing Sun Milk (50ml)", price: 26.00, image: "image/Skin1004_Madagascar_Centella_Tea-Trica_Soothing_Sun_Milk_50ml.png?text=Product+26" },
        { id: 27, name: "Madagascar Centella Air Fit Suncream Plus (50ml)", price: 26.00, image: "image/Skin1004_Madagascar_Centella_Air-Fit_Suncream_Plus_50ml.png?text=Product+27" },
        { id: 28, name: "Madagascar Centella Tone Brightening Tone Up Sunscreen SPF50+ PA++++  (50ml)", price: 26.00, image: "image/SKIN1004_Madagascar_Centella_Tone_Brightening_Tone-Up_Sunscreen_SPF50+_PA++++_50ml-removebg-preview.png?text=Product+28" },
        { id: 29, name: "Madagascar Centella Tone Brightening Tone Up Sunscreen SPF50+ PA++++ (50ml)", price: 26.00, image: "image/SKIN1004_Madagascar_Centella_Tone_Brightening_Tone-Up_Sunscreen_SPF50+_PA++++_50ml.png?text=Product+29" },
        { id: 30, name: "Madagascar Centella Air Fit Suncream Light (50ml)", price: 26.00, image: "image/Skin1004_Madagascar_Centella_Air-Fit_Suncream_Light_50ml.png?text=Product+30" },
        { id: 31, name: "Madagascar Centella Hyalu Cica Water Fit Sun Serum (50ml)", price: 26.00, image: "image/skin1004-madagascar-centella-hyalu-cica-water-fit-sun-serum-50ml.png?text=Product+31" },
        { id: 32, name: "Madagascar Centella Hyalu Cica Silky Fit Sun Stick (20g)", price: 26.00, image: "image/Skin1004_Madagascar_Centella_Hyalu-Cica_Silky-Fit_Sun_Stick_20g.png?text=Product+32"},
        { id: 33, name: "Madagascar Centella Tone Brightening Glow Mask", price: 26.00, image: "image/skin1004-tone-brightening-glow-mask.webp?text=Product+33" },
        { id: 34, name: "Madagascar Centella Hyalu Cica Hydrating Mask", price: 26.00, image: "image/skin1004Hyalu-Cica_Hydrating_Mask.png?text=Product+34" },
        { id: 35, name: "Madagascar Centella Poremizing Clarifying  Mask", price: 26.00, image: "image/skin1004Poremizing Clarifying Mask.webp?text=Product+35" },
        { id: 36, name: "Madagascar Centella Probio Cica Nourishing Mask", price: 26.00, image: "image/skin1004Probio-Cica_Nourishing_Mask.png?text=Product+36" },
        { id: 37, name: "Madagascar Centella Tea-Trica Spot Cover Patch Mask", price: 26.00, image: "image/skin1004Tea-Trica Spot Cover Patch.webp?text=Product+37" },
        { id: 38, name: "Madagascar Centella Watergel Sheet Ampoule Mask", price: 26.00, image: "image/skin_1004_centella_watergel_sheet_ampoule_mask_25_ml.png?text=Product+38" },
        { id: 39, name: "Madagascar Centella Poremizing Quick Clay Stick Mask", price: 26.00, image: "image/SKIN1004_Madagascar_Centella_Poremizing_Quick_Clay_Stick_Mask_27g.png?text=Product+39" },
        { id: 40, name: "Madagascar Centella TEA-TRICA SPOT CREAM", price: 26.00, image: "image/skin1004TEA-TRICA_SPOT_CREAM.png?text=Product+40" },

    ];

    const productsGrid = document.querySelector('.products-grid');

    // Function to render products
    function renderProducts() {
        productsGrid.innerHTML = ''; // Clear existing products
        productsData.forEach(product => {
            const productCard = document.createElement('div');
            productCard.classList.add('product-card');
            productCard.setAttribute('data-id', product.id);

            let priceHTML = `<span class="product-card-price">$${product.price.toFixed(2)}</span>`;
            if (product.oldPrice) {
                priceHTML = `<span class="product-card-price">$${product.price.toFixed(2)} <span class="discount">$${product.oldPrice.toFixed(2)}</span></span>`;
            }

            let badgeHTML = '';
            if (product.badge) {
                badgeHTML = `<div class="badge ${product.badge.toLowerCase()}">${product.badge}</div>`;
            }

            // Check localStorage for wishlist status
            const isWishlisted = localStorage.getItem(`wishlist-${product.id}`) === 'true';
            const heartIconClass = isWishlisted ? 'fas active' : 'far'; // far for empty, fas for solid

            productCard.innerHTML = `
                ${badgeHTML}
                <i class="${heartIconClass} fa-heart wishlist-icon" data-id="${product.id}"></i>
                <div class="product-card-image">
                    <img src="${product.image}" alt="${product.name}">
                </div>
                <div class="product-card-info">
                    <div class="product-card-title">${product.name}</div>
                    ${priceHTML}
                    <button class="btn add-to-cart-btn">ADD TO CART</button>
                </div>
            `;
            productsGrid.appendChild(productCard);
        });

        // Attach wishlist functionality after rendering
        attachWishlistListeners();
    }

    // 3. Wishlist Functionality
    function attachWishlistListeners() {
        document.querySelectorAll('.wishlist-icon').forEach(icon => {
            icon.addEventListener('click', (e) => {
                e.stopPropagation(); // Prevent card click if any
                const productId = e.target.dataset.id;
                e.target.classList.toggle('far'); // Toggle empty heart
                e.target.classList.toggle('fas'); // Toggle solid heart
                e.target.classList.toggle('active'); // Toggle active state for color

                // Update localStorage
                if (e.target.classList.contains('active')) {
                    localStorage.setItem(`wishlist-${productId}`, 'true');
                    console.log(`Product ${productId} added to wishlist.`);
                } else {
                    localStorage.removeItem(`wishlist-${productId}`);
                    console.log(`Product ${productId} removed from wishlist.`);
                }
            });
        });
    }

    // Initial render of products
    renderProducts();

    // 4. Smooth Scrolling Navigation
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();

            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);

            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - (window.innerWidth > 768 ? 80 : 0), // Adjust for sticky header height
                    behavior: 'smooth'
                });
            }
        });
    });

    // 5. Basic Form Validation for Contact Form
    const contactForm = document.getElementById('contactForm');

    if (contactForm) {
        contactForm.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            let isValid = true;
            const name = this.querySelector('input[name="name"]');
            const email = this.querySelector('input[name="email"]');
            const message = this.querySelector('textarea[name="message"]');

            // Simple validation for required fields
            if (!name.value.trim()) {
                alert('Please enter your name.');
                isValid = false;
                name.focus();
            } else if (!email.value.trim() || !/\S+@\S+\.\S+/.test(email.value)) {
                alert('Please enter a valid email address.');
                isValid = false;
                email.focus();
            } else if (!message.value.trim()) {
                alert('Please enter your message.');
                isValid = false;
                message.focus();
            }

            if (isValid) {
                // In a real application, you would send this data to a server
                console.log('Form submitted successfully!');
                console.log('Name:', name.value);
                console.log('Email:', email.value);
                console.log('Phone:', this.querySelector('input[name="phone"]').value);
                console.log('Message:', message.value);
                alert('Thank you for your message! We will get back to you soon.');
                this.reset(); // Clear the form
            }
        });
    }

    // Optional: Add a simple hover effect for product cards (CSS handles most of it, but JS could do more complex things)
    // For now, the CSS hover effects are sufficient.
   
});