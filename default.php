<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservaa - Modern Reservation System</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
    <script src="js/script.js"></script>
</body>
</html>
