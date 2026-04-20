/**
 * Pizza Paradizo — Main JavaScript
 */

document.addEventListener('DOMContentLoaded', function () {
    // ---- Quantity Controls ----
    const prices = [12.50, 15.50, 20.00];
    const menuItems = document.querySelectorAll('.menu-item-card');
    const quantities = [0, 0, 0];

    menuItems.forEach(function (item, index) {
        const plusBtn  = item.querySelector('.plus-btn');
        const minusBtn = item.querySelector('.minus-btn');
        const qtyValue = item.querySelector('.qty-value');

        if (!plusBtn || !minusBtn || !qtyValue) return;

        plusBtn.addEventListener('click', function () {
            quantities[index]++;
            qtyValue.textContent = quantities[index];
            updateTotal();
        });

        minusBtn.addEventListener('click', function () {
            if (quantities[index] > 0) {
                quantities[index]--;
                qtyValue.textContent = quantities[index];
                updateTotal();
            }
        });
    });

    function updateTotal() {
        let total = 0;
        quantities.forEach(function (qty, i) {
            total += qty * prices[i];
        });

        const totalEl = document.querySelector('.total-price');
        if (totalEl) {
            totalEl.textContent = total > 0 ? 'Total: RM' + total.toFixed(2) : '';
        }
    }

    // ---- Add to Cart Button ----
    const cartButton = document.querySelector('.cart-button');
    if (cartButton) {
        cartButton.addEventListener('click', function (e) {
            e.preventDefault();
            const q1 = document.querySelector('.quantity1');
            const q2 = document.querySelector('.quantity2');
            const q3 = document.querySelector('.quantity3');
            window.location.href = `cart.php?quantity1=${q1 ? q1.textContent : 0}&quantity2=${q2 ? q2.textContent : 0}&quantity3=${q3 ? q3.textContent : 0}`;
        });
    }

    // ---- Smooth scroll ----
    document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
        anchor.addEventListener('click', function (e) {
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            const target = document.querySelector(targetId);
            if (target) {
                e.preventDefault();
                const offset = document.querySelector('.navbar')?.offsetHeight || 64;
                window.scrollTo({ top: target.offsetTop - offset, behavior: 'smooth' });
            }
        });
    });
});
