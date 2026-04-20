# 🍕 Pizza Paradizo — Page Preview

A futuristic dark-themed pizza ordering web app with glassmorphism UI, modern animations, and secure checkout.

---

## Login Page

> Glassmorphism card with animated gradient orbs, glowing input focus, and gradient CTA button.

![Login Page Preview](preview_login_1776351471687.png)

**Features:**
- Frosted glass card on animated dark background
- Cyan-to-purple gradient "Sign In" button with glow hover
- Links to "Forgot Password" and "Create Account"
- CSRF protection, rate-limited login (5 attempts / 15 min)

---

## Home Page

> Hero section with gradient overlay, card-based menu with quantity controls, and about section.

![Home Page Preview](preview_home_1776351558233.png)

**Features:**
- Full-viewport hero with gradient text and CTA
- Glassmorphism menu item cards with +/- quantity controls
- "Hot!" badge with glow pulse animation
- About section with hours grid and restaurant image
- Smooth scroll navigation with sticky glassmorphism navbar
- Scroll-triggered fade-in animations

---

## Cart & Checkout Page

> Modern cart table with delivery and payment form sections.

![Cart Page Preview](preview_cart_1776351575247.png)

**Features:**
- Glassmorphism table with alternating row highlights
- Delivery details with grid form layout
- Payment info — all data sent via POST (never in URL)
- AES-256-CBC encrypted card storage
- HMAC integrity verification on checkout

---

## Additional Pages

### Register Page
Same glassmorphism treatment as login with additional fields: Name, Username, Password, Confirm Password, Secret Question/Answer. Password validation enforced (8+ chars, uppercase, lowercase, digit, special char).

### MFA Page
Two-factor verification via secret question/answer. Same visual style with shield icon.

### Recover Password Page
Password recovery form with username + secret question verification. Passwords hashed with bcrypt.

### Order Status Page
Displays success/error status with animated icon (checkmark or exclamation), styled action buttons to return home or order more.
