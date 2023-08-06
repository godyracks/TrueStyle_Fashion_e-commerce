<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="custom.css">
    <title>Caribbean Model Agency</title>
</head>
<body>
<section class="hero">
    <div class="owl-carousel hero-carousel">
    <div class="hero-content" style="background-image: url('../images/baner.jpg');">
            <h1>Welcome to Caribbean Model Agency</h1>
            <p>Discover the beauty of Caribbean models.</p>
            <a href="#" class="btn-primary">Explore Models</a>
        </div>
        <div class="hero-content">
            <h1>Unveiling Elegance and Style</h1>
            <p>Showcasing the finest Caribbean models.</p>
            <a href="#" class="btn-primary">Meet Our Models</a>
        </div>
        <!-- Add more carousel items as needed -->
    </div>
</section>

    <section class="about">
        <div class="about-content">
            <h2>About Us</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit...</p>
        </div>
    </section>

    <section class="models">
        <div class="models-content">
            <h2>Our Models</h2>
            <!-- Display model profiles using PHP and SQL -->
        </div>
    </section>

    <section class="contact">
        <div class="contact-content">
            <h2>Contact Us</h2>
            <p>Get in touch with us to discuss your needs.</p>
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <!-- Initialize the Owl Carousel -->
<script>
    $(document).ready(function() {
        $('.hero-carousel').owlCarousel({
            items: 1,
            loop: true,
            autoplay: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: true
        });
    });
</script>
</body>
</html>
