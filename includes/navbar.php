<?php
/**
 * Shared navbar for app pages. Uses Bootstrap navbar + warm theme.
 * Variables: $activePage ('home', 'menu', 'about', 'cart')
 */
$activePage = $activePage ?? '';
?>
<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="home.php">
            <i class="fas fa-pizza-slice"></i> Pizza Paradizo
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link <?php echo $activePage === 'home' ? 'active' : ''; ?>" href="home.php#home">
                        <i class="fas fa-home"></i> Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $activePage === 'menu' ? 'active' : ''; ?>" href="home.php#menu">
                        <i class="fas fa-utensils"></i> Menu
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $activePage === 'about' ? 'active' : ''; ?>" href="home.php#about">
                        <i class="fas fa-info-circle"></i> About
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $activePage === 'cart' ? 'active' : ''; ?>" href="cart.php">
                        <i class="fas fa-shopping-cart"></i> Cart
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
