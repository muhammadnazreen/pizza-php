<?php
require_once 'config/session.php';
require_once 'includes/security.php';

setSecurityHeaders();

if (!isset($_SESSION['id']) || !isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}

$pageTitle = 'Home';
$pageCss = ['assets/css/home.css'];
$activePage = 'home';

require_once 'includes/header.php';
require_once 'includes/navbar.php';
?>

<!-- Hero Section -->
<section id="home" class="hero">
    <div class="hero-content">
        <span class="hero-badge"><i class="fas fa-clock"></i> Open from 10am to 12pm</span>
        <h1 class="hero-title">Thin Crust<br>Pizza</h1>
        <p class="hero-desc">Handcrafted with the freshest ingredients, delivered to your doorstep. Taste the tradition of Pizza Paradizo.</p>
        <a href="#menu" class="btn-hero">
            <i class="fas fa-utensils"></i> View Menu
        </a>
    </div>
</section>

<!-- Menu Section -->
<section id="menu" class="menu-section">
    <div class="container">
        <div class="section-header">
            <h2>The Menu</h2>
            <p>Choose from our handcrafted selection of delicious pizzas</p>
        </div>

        <div class="menu-list">
            <!-- Deluxe Cheese -->
            <div class="menu-item-card">
                <div class="menu-item-top">
                    <h3 class="menu-item-name">Deluxe Cheese</h3>
                    <span class="menu-item-price">RM12.50</span>
                </div>
                <p class="menu-item-desc">Fresh tomatoes, fresh mozzarella, fresh basil</p>
                <div class="qty-controls">
                    <button type="button" class="qty-btn minus-btn">−</button>
                    <span class="qty-value quantity1">0</span>
                    <button type="button" class="qty-btn plus-btn">+</button>
                </div>
            </div>

            <!-- Four of a Kind Cheese -->
            <div class="menu-item-card">
                <div class="menu-item-top">
                    <h3 class="menu-item-name">Four of a Kind Cheese</h3>
                    <span class="menu-item-price">RM15.50</span>
                </div>
                <p class="menu-item-desc">Four cheeses (mozzarella, parmesan, pecorino, jarlsberg)</p>
                <div class="qty-controls">
                    <button type="button" class="qty-btn minus-btn">−</button>
                    <span class="qty-value quantity2">0</span>
                    <button type="button" class="qty-btn plus-btn">+</button>
                </div>
            </div>

            <!-- Chicken Pepperoni -->
            <div class="menu-item-card">
                <div class="menu-item-top">
                    <h3 class="menu-item-name">
                        Chicken Pepperoni
                        <span class="badge-hot"><i class="fas fa-fire"></i> Hot</span>
                    </h3>
                    <span class="menu-item-price">RM20.00</span>
                </div>
                <p class="menu-item-desc">Fresh tomatoes, mozzarella, hot pepperoni, hot sausage, beef, chicken</p>
                <div class="qty-controls">
                    <button type="button" class="qty-btn minus-btn">−</button>
                    <span class="qty-value quantity3">0</span>
                    <button type="button" class="qty-btn plus-btn">+</button>
                </div>
            </div>

            <!-- Total & Add to Cart -->
            <div class="menu-total-row">
                <h3 class="menu-total-price total-price"></h3>
                <a href="cart.php?quantity1=0&quantity2=0&quantity3=0" class="btn-add-cart cart-button">
                    <i class="fas fa-cart-plus"></i> Add to Cart
                </a>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section id="about" class="about-section">
    <div class="container">
        <div class="section-header">
            <h2>About Us</h2>
            <p>The story behind Pizza Paradizo</p>
        </div>

        <div class="row align-items-center g-5">
            <div class="col-lg-6 about-content">
                <p>The Pizza Paradizo Restaurant, founded in 2023 by Mr. Me, is a haven for pizza lovers seeking a slice of perfection. 🍕 We are dedicated to crafting exceptional pizzas that will tantalize your taste buds.</p>
                <p>At Pizza Paradizo, we take pride in using only the finest, freshest ingredients. 🌱 Our skilled chefs combine traditional techniques with innovative flavors, resulting in a symphony of deliciousness with every bite.</p>
                <p>Step inside our cozy and inviting restaurant, where the aroma of freshly baked pizzas fills the air. Our friendly staff are ready to guide you through our menu. 👨‍🍳</p>
                <p><strong>The Chef?</strong> Mr. Me himself 🎉</p>

                <div class="hours-section">
                    <h4><i class="fas fa-clock"></i> Opening Hours</h4>
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="hours-card">
                                <p><strong>Mon & Tue</strong> — Closed</p>
                                <p>Wednesday 10:00 – 24:00</p>
                                <p>Thursday 10:00 – 24:00</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="hours-card">
                                <p>Friday 10:00 – 12:00</p>
                                <p>Saturday 10:00 – 23:00</p>
                                <p><strong>Sunday</strong> — Closed</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="about-image">
                    <img src="assets/images/pizza-restaurant.jpg" alt="Pizza Paradizo Restaurant Interior">
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>