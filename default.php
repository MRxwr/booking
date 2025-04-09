<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservaa - Modern Reservation System</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #2ecc71;
            --secondary: #3498db;
            --accent: #f39c12;
            --dark: #2c3e50;
            --light: #ecf0f1;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--light);
            color: var(--dark);
            overflow-x: hidden;
        }
        
        /* Gradient Backgrounds */
        .bg-gradient-main {
            background: linear-gradient(135deg, var(--secondary), var(--primary));
            color: white;
        }
        
        .bg-gradient-dark {
            background: linear-gradient(135deg, #2c3e50, #34495e);
            color: white;
        }
        
        .bg-glass {
            background-color: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        /* Typography */
        h1, h2, h3, h4, h5, h6 {
            font-weight: 600;
        }
        
        .display-heading {
            font-weight: 700;
            letter-spacing: -0.5px;
        }
        
        .subheading {
            font-weight: 300;
            letter-spacing: 1px;
        }
        
        /* Header */
        .navbar {
            padding: 1rem 2rem;
            transition: all 0.3s ease;
        }
        
        .navbar.scrolled {
            padding: 0.5rem 2rem;
            background-color: rgba(46, 204, 113, 0.95);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.8rem;
        }
        
        .nav-link {
            font-weight: 500;
            margin: 0 0.5rem;
            padding: 0.5rem 1rem !important;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background-color: var(--accent);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        
        .nav-link:hover::after {
            width: 80%;
        }
        
        /* Hero Section */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        
        .hero::before {
            content: '';
            position: absolute;
            top: -10%;
            right: -10%;
            width: 60%;
            height: 70%;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            z-index: 0;
        }
        
        .hero::after {
            content: '';
            position: absolute;
            bottom: -15%;
            left: -15%;
            width: 70%;
            height: 70%;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            z-index: 0;
        }
        
        .hero-content {
            position: relative;
            z-index: 1;
        }
        
        .hero-title {
            font-size: 3.5rem;
            margin-bottom: 1.5rem;
            animation: fadeInUp 1s ease;
        }
        
        .hero-subtitle {
            font-size: 1.5rem;
            margin-bottom: 2rem;
            opacity: 0.9;
            animation: fadeInUp 1s 0.2s ease both;
        }
        
        .hero-btn {
            animation: fadeInUp 1s 0.4s ease both;
        }
        
        /* About Section */
        .about {
            padding: 8rem 0;
            position: relative;
        }
        
        .about-img {
            border-radius: 10px;
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        
        .about-img:hover {
            transform: translateY(-10px);
        }
        
        /* Counters Section */
        .counter-box {
            background-color: white;
            border-radius: 10px;
            padding: 2rem;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }
        
        .counter-box:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }
        
        .counter-icon {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 1rem;
        }
        
        .counter-number {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: var(--dark);
        }
        
        .counter-text {
            color: var(--dark);
            font-weight: 500;
        }
        
        /* Packages Section */
        .packages {
            padding: 8rem 0;
            background: linear-gradient(135deg, #f6f9fc, #edf2f7);
        }
        
        .package-card {
            background-color: white;
            border-radius: 15px;
            overflow: hidden;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            position: relative;
        }
        
        .package-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }
        
        .package-header {
            padding: 2rem;
            text-align: center;
            background: linear-gradient(135deg, var(--secondary), var(--primary));
            color: white;
        }
        
        .package-title {
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .package-price {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0;
        }
        
        .package-price-text {
            font-size: 0.9rem;
            opacity: 0.8;
        }
        
        .package-body {
            padding: 2rem;
        }
        
        .package-features {
            list-style: none;
            padding: 0;
            margin-bottom: 2rem;
        }
        
        .package-features li {
            padding: 0.5rem 0;
            border-bottom: 1px solid #eee;
            display: flex;
            align-items: center;
        }
        
        .package-features li::before {
            content: '\f00c';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            color: var(--primary);
            margin-right: 1rem;
        }
        
        .package-btn {
            display: block;
            width: 100%;
            padding: 0.75rem 0;
            text-align: center;
            border-radius: 50px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        /* Featured package */
        .package-card.featured {
            transform: scale(1.05);
        }
        
        .package-card.featured::before {
            content: 'Popular';
            position: absolute;
            top: 1rem;
            right: 1rem;
            background-color: var(--accent);
            color: white;
            padding: 0.5rem 1rem;
            font-size: 0.8rem;
            border-radius: 20px;
            font-weight: 500;
            z-index: 2;
        }
        
        .package-card.featured:hover {
            transform: scale(1.05) translateY(-10px);
        }
        
        /* Testimonials Section */
        .testimonials {
            padding: 8rem 0;
            background: var(--light);
        }
        
        .testimonial-card {
            background-color: white;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            position: relative;
        }
        
        .testimonial-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }
        
        .testimonial-text {
            font-style: italic;
            margin-bottom: 1.5rem;
            position: relative;
            padding-left: 2rem;
        }
        
        .testimonial-text::before {
            content: '\f10d';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            color: var(--primary);
            font-size: 1.5rem;
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0.3;
        }
        
        .testimonial-author {
            display: flex;
            align-items: center;
        }
        
        .testimonial-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            overflow: hidden;
            margin-right: 1rem;
        }
        
        .testimonial-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .testimonial-name {
            font-weight: 600;
            margin-bottom: 0;
        }
        
        .testimonial-role {
            font-size: 0.9rem;
            color: #6c757d;
        }
        
        /* Contact Section */
        .contact {
            padding: 8rem 0;
            background: linear-gradient(135deg, var(--secondary), var(--primary));
            color: white;
        }
        
        .contact-info {
            margin-bottom: 2rem;
        }
        
        .contact-info-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 1.5rem;
        }
        
        .contact-info-icon {
            font-size: 1.5rem;
            margin-right: 1rem;
            color: var(--accent);
        }
        
        .contact-form {
            background-color: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        .form-control {
            border: none;
            border-bottom: 1px solid #ddd;
            border-radius: 0;
            padding: 0.75rem 0;
            font-size: 0.9rem;
            background-color: transparent;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            box-shadow: none;
            border-bottom-color: var(--primary);
        }
        
        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }
        
        .form-group label {
            position: absolute;
            top: 0.75rem;
            left: 0;
            color: #6c757d;
            transition: all 0.3s ease;
            pointer-events: none;
        }
        
        .form-group .form-control:focus + label,
        .form-group .form-control:not(:placeholder-shown) + label {
            top: -0.5rem;
            left: 0;
            font-size: 0.75rem;
            color: var (--primary);
        }
        
        .pulse-btn {
            animation: pulse 2s infinite;
            transition: all 0.3s ease;
        }
        
        @keyframes pulse {
            0% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(243, 156, 18, 0.7);
            }
            70% {
                transform: scale(1.02);
                box-shadow: 0 0 0 10px rgba(243, 156, 18, 0);
            }
            100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(243, 156, 18, 0);
            }
        }
        
        /* Map */
        .map-wrapper {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        /* Footer */
        .footer {
            padding: 4rem 0 2rem;
            background-color: var(--dark);
            color: white;
        }
        
        .footer-title {
            font-weight: 600;
            margin-bottom: 1.5rem;
        }
        
        .footer-links {
            list-style: none;
            padding: 0;
        }
        
        .footer-links li {
            margin-bottom: 0.75rem;
        }
        
        .footer-links a {
            color: rgba(255,255,255,0.7);
            transition: all 0.3s ease;
        }
        
        .footer-links a:hover {
            color: var(--accent);
            text-decoration: none;
            padding-left: 5px;
        }
        
        .social-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            margin-right: 0.5rem;
            transition: all 0.3s ease;
        }
        
        .social-icon:hover {
            background-color: var(--accent);
            color: white;
            transform: translateY(-3px);
            text-decoration: none;
        }
        
        .footer-bottom {
            padding-top: 2rem;
            margin-top: 2rem;
            border-top: 1px solid rgba(255,255,255,0.1);
            text-align: center;
        }
        
        /* Back to top */
        #backToTop {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: var(--accent);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            z-index: 999;
        }
        
        #backToTop.active {
            opacity: 1;
            visibility: visible;
        }
        
        #backToTop:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.15);
        }
        
        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s ease;
        }
        
        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }
        
        /* Responsive Adjustments */
        @media (max-width: 992px) {
            .hero-title {
                font-size: 2.8rem;
            }
            
            .package-card.featured {
                transform: scale(1);
            }
            
            .package-card.featured:hover {
                transform: translateY(-10px);
            }
        }
        
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-subtitle {
                font-size: 1.2rem;
            }
            
            .section-title {
                font-size: 2rem;
            }
            
            .navbar-collapse {
                background-color: rgba(46, 204, 113, 0.95);
                padding: 1rem;
                border-radius: 10px;
                margin-top: 1rem;
            }
        }
        
        @media (max-width: 576px) {
            .hero-title {
                font-size: 2rem;
            }
            
            .counter-box {
                margin-bottom: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-glass">
        <div class="container">
            <a class="navbar-brand" href="#">Reservaa</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#packages">Packages</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#testimonials">Testimonials</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact Us</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero bg-gradient-main">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 hero-content">
                    <h1 class="hero-title display-heading">Simplify Your Booking Process</h1>
                    <p class="hero-subtitle subheading">The ultimate reservation system for modern businesses</p>
                    <a href="#packages" class="btn btn-light btn-lg hero-btn">Explore Packages</a>
                </div>
                <div class="col-lg-6">
                    <img src="https://via.placeholder.com/600x400" alt="Reservaa Dashboard" class="img-fluid rounded-lg">
                </div>
            </div>
        </div>
    </section>

    <!-- About Us Section -->
    <section id="about" class="about">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <img src="https://via.placeholder.com/600x400" alt="About Reservaa" class="img-fluid about-img">
                </div>
                <div class="col-lg-6">
                    <div class="section-header mb-4">
                        <h2 class="section-title mb-3">About Reservaa</h2>
                        <div class="section-divider"></div>
                    </div>
                    <p class="mb-4">Reservaa is a cutting-edge reservation system designed to streamline your booking process. Whether you're managing a restaurant, hotel, or any other type of service, Reservaa provides the tools you need to efficiently handle reservations and improve customer satisfaction.</p>
                    <p>Our platform combines ease of use with powerful features, allowing you to focus on what matters most - delivering exceptional service to your customers.</p>
                    <div class="mt-4 fade-in">
                        <a href="#contact" class="btn btn-outline-primary mr-3">Get in Touch</a>
                        <a href="#packages" class="btn btn-primary">View Pricing</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Counters Section -->
    <section class="counters bg-gradient-main py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-4 d-flex">
                    <div class="counter-box text-center bg-glass w-100">
                        <i class="fas fa-users counter-icon"></i>
                        <div class="counter-number">1,500+</div>
                        <div class="counter-text">Happy Clients</div>
                    </div>
                </div>
                <div class="col-md-4 d-flex">
                    <div class="counter-box text-center bg-glass w-100">
                        <i class="fas fa-calendar-check counter-icon"></i>
                        <div class="counter-number">3,000+</div>
                        <div class="counter-text">Reservations Booked</div>
                    </div>
                </div>
                <div class="col-md-4 d-flex">
                    <div class="counter-box text-center bg-glass w-100">
                        <i class="fas fa-tools counter-icon"></i>
                        <div class="counter-number">50+</div>
                        <div class="counter-text">Features Available</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Packages Section -->
    <section id="packages" class="packages">
        <div class="container">
            <div class="section-header text-center mb-5">
                <h2 class="section-title mb-3">Pricing Packages</h2>
                <p class="section-subtitle">Choose the perfect plan for your business needs</p>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="package-card">
                        <div class="package-header">
                            <h3 class="package-title">Basic</h3>
                            <div class="package-price">9.900 KD</div>
                            <div class="package-price-text">per month</div>
                        </div>
                        <div class="package-body">
                            <ul class="package-features">
                                <li>Free Booking Only</li>
                                <li>Basic Analytics</li>
                                <li>Email Support</li>
                                <li>Limited Features</li>
                                <li>Basic Customization</li>
                            </ul>
                            <a href="#" class="btn btn-outline-primary package-btn">Choose Basic</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="package-card featured">
                        <div class="package-header">
                            <h3 class="package-title">Payment Methods & Gateways</h3>
                            <div class="package-price">14.900 KD</div>
                            <div class="package-price-text">per month</div>
                        </div>
                        <div class="package-body">
                            <ul class="package-features">
                                <li>All Basic Features</li>
                                <li>Payment Gateway Integration</li>
                                <li>Priority Support</li>
                                <li>Advanced Analytics</li>
                                <li>Custom Branding</li>
                            </ul>
                            <a href="#" class="btn btn-primary package-btn">Choose Payment</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mx-auto">
                    <div class="package-card">
                        <div class="package-header">
                            <h3 class="package-title">Full Option System</h3>
                            <div class="package-price">24.900 KD</div>
                            <div class="package-price-text">per month</div>
                        </div>
                        <div class="package-body">
                            <ul class="package-features">
                                <li>All Payment Features</li>
                                <li>Advanced Analytics</li>
                                <li>24/7 Support</li>
                                <li>API Access</li>
                                <li>White Label Solution</li>
                            </ul>
                            <a href="#" class="btn btn-outline-primary package-btn">Choose Full Option</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="testimonials">
        <div class="container">
            <div class="section-header text-center mb-5">
                <h2 class="section-title mb-3">Testimonials</h2>
                <p class="section-subtitle">What our clients say about Reservaa</p>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="testimonial-card">
                        <div class="testimonial-text">
                            Reservaa has transformed our business. It's easy to use and has greatly improved our reservation management. The team behind it is responsive and helpful whenever we need assistance.
                        </div>
                        <div class="testimonial-author">
                            <div class="testimonial-avatar">
                                <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="John Doe">
                            </div>
                            <div>
                                <h5 class="testimonial-name">John Doe</h5>
                                <div class="testimonial-role">Restaurant Owner</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="testimonial-card">
                        <div class="testimonial-text">
                            We've seen a significant increase in customer satisfaction since implementing Reservaa. Highly recommended! The platform is intuitive and our staff learned to use it within hours.
                        </div>
                        <div class="testimonial-author">
                            <div class="testimonial-avatar">
                                <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Jane Smith">
                            </div>
                            <div>
                                <h5 class="testimonial-name">Jane Smith</h5>
                                <div class="testimonial-role">Hotel Manager</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Us Section -->
    <section id="contact" class="contact">
        <div class="container">
            <div class="section-header text-center mb-5">
                <h2 class="section-title mb-3">Get In Touch</h2> 
                <p class="section-subtitle">Have questions? We're here to help!</p>
            </div>
            <div class="row">
                <div class="col-lg-5 mb-5 mb-lg-0">
                    <div class="contact-info">
                        <div class="contact-info-item">
                            <div class="contact-info-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Our Location</h5>
                                <p>Kuwait City, Kuwait</p>
                            </div>
                        </div>
                        <div class="contact-info-item">
                            <div class="contact-info-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Email Address</h5>
                                <p>info@reservaa.com</p>
                            </div>
                        </div>
                        <div class="contact-info-item">
                            <div class="contact-info-icon">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Phone Number</h5>
                                <p>+1 123-456-7890</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <h5 class="mb-3">Follow Us</h5>
                        <div class="d-flex">
                            <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="contact-form">
                        <form action="https://example.com/send-mail" method="POST">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="name" name="name" placeholder=" " required>
                                        <label for="name">Your Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="email" class="form-control" id="email" name="email" placeholder=" " required>
                                        <label for="email">Your Email</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="subject" name="subject" placeholder=" " required>
                                        <label for="subject">Subject</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea class="form-control" id="message" name="message" rows="5" placeholder=" " required></textarea>
                                        <label for="message">Your Message</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-light btn-lg btn-block pulse-btn">Send Message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="map py-0">
        <div class="map-wrapper">
            <div class="embed-responsive embed-responsive-16by9">
                <iframe class="embed-responsive-item" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3463.4494937495976!2d48.00631872483032!3d29.37585447551199!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3fcf9c2c9c3fffff%3A0x3ca9e5e278a89819!2sKuwait%20City!5e0!3m2!1sen!2skw!4v1699274899494!5m2!1sen!2skw" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
                    <h4 class="footer-title">Reservaa</h4>
                    <p class="mb-4">The ultimate solution for businesses looking to streamline their reservation process and improve customer satisfaction.</p>
                    <div class="d-flex">
                        <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4 mb-md-0">
                    <h4 class="footer-title">Quick Links</h4>
                    <ul class="footer-links">
                        <li><a href="#about">About Us</a></li>
                        <li><a href="#packages">Packages</a></li>
                        <li><a href="#testimonials">Testimonials</a></li>
                        <li><a href="#contact">Contact Us</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 mb-4 mb-md-0">
                    <h4 class="footer-title">Resources</h4>
                    <ul class="footer-links">
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Support</a></li>
                        <li><a href="#">Documentation</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
                    <h4 class="footer-title">Contact Info</h4>
                    <p><i class="fas fa-map-marker-alt mr-2"></i> Kuwait City, Kuwait</p>
                    <p><i class="fas fa-envelope mr-2"></i> info@reservaa.com</p>
                    <p><i class="fas fa-phone-alt mr-2"></i> +1 123-456-7890</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p class="mb-0">&copy; 2023 Reservaa. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Back To Top Button -->
    <div id="backToTop">
        <i class="fas fa-arrow-up"></i>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
            // Navbar scroll effect
            $(window).scroll(function () {
                if ($(this).scrollTop() > 100) {
                    $('.navbar').addClass('scrolled');
                    $('#backToTop').addClass('active');
                } else {
                    $('.navbar').removeClass('scrolled');
                    $('#backToTop').removeClass('active');
                }
            });
            
            // Smooth scrolling for nav links
            $('.nav-link, .footer-links a').on('click', function (e) {
                if (this.hash !== '') {
                    e.preventDefault();
                    const hash = this.hash;
                    $('html, body').animate({
                        scrollTop: $(hash).offset().top - 100
                    }, 800);
                }
            });
            
            // Back to top button
            $('#backToTop').on('click', function () {
                $('html, body').animate({ scrollTop: 0 }, 800);
            });
            
            // Animation on scroll
            $(window).scroll(function() {
                $('.fade-in').each(function() {
                    const elementTop = $(this).offset().top;
                    const elementBottom = elementTop + $(this).outerHeight();
                    const viewportTop = $(window).scrollTop();
                    const viewportBottom = viewportTop + $(window).height();
                    
                    if (elementBottom > viewportTop && elementTop < viewportBottom) {
                        $(this).addClass('visible');
                    }
                });
            });
        });
    </script>
</body>
</html>
