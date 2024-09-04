<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plan Management System</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('style/style.css') }}">
</head>

<body>
    <nav class="navbar">
        <div class="logo">
            <a href="#">PlanManager</a>
        </div>
        <ul class="nav-links">
            <li><a href="#">Home</a></li>
            <li><a href="#">Features</a></li>
            <li><a href="#">Pricing</a></li>
            <li><a href="#">Contact</a></li>
            <li><a href="{{ route('login') }}" class="btn login-btn">Login</a></li>
            <li><a href="{{ route('register') }}" class="btn signup-btn">Sign Up</a></li>
        </ul>
        <div class="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </nav>

    <header class="hero-section">
        <div class="hero-content">
            <h1>Implement a Plan Management System with Stripe Integration</h1>
            <p>Manage your subscription plans with ease and integrate Stripe for seamless payment processing.</p>
            <a href="#" class="btn cta-btn">Get Started</a>
        </div>
    </header>

    <section class="features-section">
        <h2>Our Features</h2>
        <div class="features-grid">
            <div class="feature-item">
                <h3>Easy Plan Management</h3>
                <p>Create, update, and manage your subscription plans effortlessly.</p>
            </div>
            <div class="feature-item">
                <h3>Stripe Integration</h3>
                <p>Seamlessly integrate with Stripe to handle all your payment needs.</p>
            </div>
            <div class="feature-item">
                <h3>Secure Transactions</h3>
                <p>Ensure all transactions are safe and secure with our robust security features.</p>
            </div>
            <div class="feature-item">
                <h3>Customizable Plans</h3>
                <p>Offer flexible pricing options with fully customizable plans.</p>
            </div>
        </div>
    </section>

    {{-- <section class="pricing-section">
        <h2>Pricing Plans</h2>
        <div class="pricing-grid">
            <div class="pricing-item">
                <h3>Basic</h3>
                <p>$9.99 / month</p>
                <ul>
                    <li>Basic Plan Management</li>
                    <li>Stripe Integration</li>
                    <li>Email Support</li>
                </ul>
                <a href="#" class="btn pricing-btn">Choose Plan</a>
            </div>
            <div class="pricing-item">
                <h3>Pro</h3>
                <p>$29.99 / month</p>
                <ul>
                    <li>Advanced Plan Management</li>
                    <li>Priority Stripe Integration</li>
                    <li>24/7 Support</li>
                </ul>
                <a href="#" class="btn pricing-btn">Choose Plan</a>
            </div>
            <div class="pricing-item">
                <h3>Enterprise</h3>
                <p>Contact Us</p>
                <ul>
                    <li>Custom Plan Management</li>
                    <li>Dedicated Stripe Support</li>
                    <li>Dedicated Account Manager</li>
                </ul>
                <a href="#" class="btn pricing-btn">Choose Plan</a>
            </div>
        </div>
    </section> --}}

    <footer class="footer">
        <p>&copy; 2024 PlanManager. All Rights Reserved.</p>
    </footer>

    <script src="script.js"></script>
</body>

</html>
