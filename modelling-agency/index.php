<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modelling Portfolio</title>

    <link rel="stylesheet" href="custom.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="css/swiper-bundle.min.css">


</head>

<body>
    <header class="header" id="header">
        <nav class="nav container">
            <a href="#" class="nav__logo">Chiamaka</a>
            <div class="nav__menu" id="nav-menu">
                <ul class="nav__list grid">
                    <li>
                        <a href="#home" class="nav__link active-link">
                            <i class="uil uil-estate nav__icon"></i> Home
                        </a>
                    </li>
                    <li>
                        <a href="#slide" class="nav__link">
                            <i class="uil uil-file-alt nav__icon"></i> Portfolio
                        </a>
                    </li>
                    <li>
                        <a href="#services" class="nav__link"><i class="uil uil-briefcase nav__icon"></i> Services </a>
                    </li>
                    <li>
                        <a href="#portfolio" class="nav__link"><i class="uil uil-scenery nav__icon"></i>  Details </a>
                    </li>
                    <li>
                        <a href="#contact" class="nav__link"><i class="uil uil-scenery nav__icon"></i> Contact Me</a>
                    </li>


                </ul>
                <i class="uil uil-times nav__close" id="nav-close"></i>
            </div>

            <div class="nav__btns">
                <!--Theme change buttons -->
                <i class="uil uil-moon change-theme" id="theme-button"></i>
                <div class="nav__toggle" id="nav-toggle">
                    <i class="uil uil-apps"></i>
                </div>

            </div>



        </nav>
    </header>
    <main class="main">
        <!-- Home-->
        <section class="home section" id="home">
            <div class="home__container container grid">
                <div class="home__content grid">
                    <div class="home__social">
                        <a href="https://instagram.com/chiamakabrowneyes?utm_medium=copy_link" target="_blank" class="home__social-icon">
                            <i class="uil uil-instagram"></i>

                        </a>

                        <a href="https://twitter.com/welovemaky" target="_blank" class="home__social-icon">
                            <i class="uil uil-twitter"></i>

                        </a>
                    </div>
                    <div class="home__img">
                        <svg class="home__blob" viewBox="0 0 200 187" xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink">
                            <mask id="mask0" mask-type="alpha">
                                <path d="M190.312 36.4879C206.582 62.1187 201.309 102.826 182.328 134.186C163.346 165.547 
                                130.807 187.559 100.226 186.353C69.6454 185.297 41.0228 161.023 21.7403 129.362C2.45775 
                                97.8511 -7.48481 59.1033 6.67581 34.5279C20.9871 10.1032 59.7028 -0.149132 97.9666 
                                0.00163737C136.23 0.303176 174.193 10.857 190.312 36.4879Z" />
                            </mask>
                            <g mask="url(#mask0)">
                                <path d="M190.312 36.4879C206.582 62.1187 201.309 102.826 182.328 134.186C163.346 
                                165.547 130.807 187.559 100.226 186.353C69.6454 185.297 41.0228 161.023 21.7403 
                                129.362C2.45775 97.8511 -7.48481 59.1033 6.67581 34.5279C20.9871 10.1032 59.7028 
                                -0.149132 97.9666 0.00163737C136.23 0.303176 174.193 10.857 190.312 36.4879Z" />
                                <image class="home__blob-img" x="12" y="17"
                                    xlink:href="img\Yellow1_adobespark (1).png " />
                            </g>
                        </svg>
                    </div>
                    <div class="home__data">
                        <h1 class="home__title">Hi, I'm Chiamaka
                        </h1>
                        <h3 class="home__subtitle">
                            Lifestyle Model
                        </h3>
                        <p class="home_description">I'm a 19 years old Nigerian lifestyle model and software engineering student at Minerva University, San Francisco. </p>
                        <p>I'm interested in art, fashion, programming and security</p>
                        <a href="#contact" class="button button--flex">Contact Me<i
                                class="uil uil-message button__icon"></i></a>
                    </div>
                </div>
            </div>
        </section>
        <div>

        </div>
        <section class = "slide__container container">
            <h2 class="section__title">Portfolio</h2>
            <span class = "section__subtitle">Recent modelling jobs</span>

            <div class="intro__container">
                <h4 class="slide_intro">Skincare brand Campaign</h4>
                <span class="section__subtitle">Sponsor: Organiyu</span>
            </div>
            <div class="portfolio__container container swiper">
                <div class="swiper-wrapper">
                    <div>
                        <h2 class="slide__header">Skin-care Brand Campaign</h2>
                    </div>
                    <div class="portfolio__content grid swiper-slide">
                        <img src="img\Organiyu5.JPG" alt="" class="portfolio__img">
                        <img src="img\Organiyu4.jpg" alt="" class="portfolio__img">
                    </div>
                    <div class="portfolio__content grid swiper-slide">
                        <img src="img\Organiyu3.jpg" alt="" class="portfolio__img">
                        <img src="img\Organiyu2.jpg" alt="" class="portfolio__img">
                    </div>
                    <div class="portfolio__content grid swiper-slide">
                        <img src="img\Organiyu1.jpg" alt="" class="portfolio__img">
                        <img src="img\Organiyu6.jpg" alt="" class="portfolio__img">
                    </div>
                    <!-- Portfolio 1-->
                </div>
                <!-- Add Arrows-->
                <div class="swiper-button-next">
                    <i class="uil uil-angle-right-b swiper-portfolio-icon"></i>
                </div>
                <div class="swiper-button-prev">
                    <i class="uil uil-angle-left-b swiper-portfolio-icon"></i>
                </div>
            
                <!-- Add Pagination-->
                <div class="swiper-pagination"></div>
            </div>

            <div class="intro__container">
                <h4 class="slide_intro">Real Estate Promotion</h4>
                <span class="section__subtitle">Sponsor: Shell Coop East Garden</span>
            </div>
            <div class="portfolio__container container swiper" id="slide">
                <div class="swiper-wrapper">
                    <div class="portfolio__content grid swiper-slide">
                        <img src="img\real-est1.jpg" alt="" class="portfolio__img">
                        <img src="img\resl-est2.jpg" alt="" class="portfolio__img">
                    </div>
                    <div class="portfolio__content grid swiper-slide">
                        <img src="img\real-est3.JPG" alt="" class="portfolio__img">
                        <img src="img\resl-est4.JPG" alt="" class="portfolio__img">
                    </div>
                    <!-- Portfolio 1-->
                </div>
                <!-- Add Arrows-->
                <div class="swiper-button-next">
                    <i class="uil uil-angle-right-b swiper-portfolio-icon"></i>
                </div>
                <div class="swiper-button-prev">
                    <i class="uil uil-angle-left-b swiper-portfolio-icon"></i>
                </div>
            
                <!-- Add Pagination-->
                <div class="swiper-pagination"></div>
            </div>

            <div class="intro__container">
                <h4 class="slide_intro">Photography Theme</h4>
                <span class="section__subtitle">Sponsor: Ajayi Philip Studio</span>
            </div>
            <div class="portfolio__container container swiper">
                <div class="swiper-wrapper">
                    <div>
                        <h2 class="slide__header">Skin-care Brand Campaign</h2>
                    </div>
                    <div class="portfolio__content grid swiper-slide">
                        <img src="img\yellow1 (2).JPG" alt="" class="portfolio__img">
                        <img src="img\yellow2 (2).JPG" alt="" class="portfolio__img">
                    </div>
                    <div class="portfolio__content grid swiper-slide">
                        <img src="img\yellow3.JPG" alt="" class="portfolio__img">
                        <img src="img\yellow4.JPG" alt="" class="portfolio__img">
                    </div>
                    <div class="portfolio__content grid swiper-slide">
                        <img src="img\yellow5.JPG" alt="" class="portfolio__img">
                        <img src="img\yellow6.JPG" alt="" class="portfolio__img">
                    </div>
                    <!-- Portfolio 1-->
                </div>
                <!-- Add Arrows-->
                <div class="swiper-button-next">
                    <i class="uil uil-angle-right-b swiper-portfolio-icon"></i>
                </div>
                <div class="swiper-button-prev">
                    <i class="uil uil-angle-left-b swiper-portfolio-icon"></i>
                </div>
            
                <!-- Add Pagination-->
                <div class="swiper-pagination"></div>
            </div>

            <div class="intro__container">
                <h4 class="slide_intro">Cloth Brand Catalogue</h4>
                <span class="section__subtitle">Sponsor: Kaimaara</span>
            </div>
            <div class="portfolio__container container swiper">

                <div class="swiper-wrapper">
                    <div>
                        <h2 class="slide__header">Skin-care Brand Campaign</h2>
                    </div>
                    <div class="portfolio__content grid swiper-slide">
                        <img src="img\k1.JPG" alt="" class="portfolio__img">
                        <img src="img\k2.JPG" alt="" class="portfolio__img">
                    </div>
                    <div class="portfolio__content grid swiper-slide">
                        <img src="img\k3.JPG" alt="" class="portfolio__img">
                        <img src="img\k4.JPG" alt="" class="portfolio__img">
                    </div>
                    <div class="portfolio__content grid swiper-slide">
                        <img src="img\k5.JPG" alt="" class="portfolio__img">
                        <img src="img\k6.JPG" alt="" class="portfolio__img">
                    </div>
                    <!-- Portfolio 1-->
                </div>
                <!-- Add Arrows-->
                <div class="swiper-button-next">
                    <i class="uil uil-angle-right-b swiper-portfolio-icon"></i>
                </div>
                <div class="swiper-button-prev">
                    <i class="uil uil-angle-left-b swiper-portfolio-icon"></i>
                </div>
            
                <!-- Add Pagination-->
                <div class="swiper-pagination"></div>
            </div>
        </section>

        <!-- Services-->
        <section class="services section" id="services">
            <h2 class="section__title">Services</h2>
            <span class="section__subtitle">What I offer</span>

            <div class="services__container container grid">
                <!-- Services1-->
                <div class="services__content">
                    <div>
                        <i class="uil uil-web-grid services__icon"></i>
                        <h3 class="services__title">Catalogue <br> Modelling</h3>
                    </div>
                    <span class="button button--flex button--small button--link services__button">View More<i class="uil uil-arrow-right button__icon"></i></span>

                    <div class="services__modal">
                        <div class="services__modal-content">
                            <h4 class="services__modal-title">Catalogue modelling qualities</h4>
                            <i class="uil uil-times-circle services__modal-close"></i>

                            <ul class="services__modal-services grid">
                                <li class="services__modal-service">
                                    <i class="uil uil-check-circle services__modal-service"></i>
                                    <p>Absorbent Personality</p>
                                </li>

                                <li class="services__modal-service">
                                    <i class="uil uil-check-circle services__modal-service"></i>
                                    <p>Natural Elegance</p>
                                </li>

                                <li class="services__modal-service">
                                    <i class="uil uil-check-circle services__modal-service"></i>
                                    <p>Confidence</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Services2-->
                <div class="services__content">
                    <div>
                        <i class="uil uil-arrow services__icon"></i>
                        <h3 class="services__title">Promotional <br> Modelling</h3>
                    </div>
                    <span class="button button--flex button--small button--link services__button">View More<i class="uil uil-arrow-right button__icon"></i></span>
                
                    <div class="services__modal">
                        <div class="services__modal-content">
                            <h4 class="services__modal-title">Promotional Modelling Qualities</h4>
                            <i class="uil uil-times-circle services__modal-close"></i>
                
                            <ul class="services__modal-services grid">
                                <li class="services__modal-service">
                                    <i class="uil uil-check-circle services__modal-service"></i>
                                    <p>Healthy communication skills</p>
                                </li>
                
                                <li class="services__modal-service">
                                    <i class="uil uil-check-circle services__modal-service"></i>
                                    <p>Admirable moral identity</p>
                                </li>
                
                                <li class="services__modal-service">
                                    <i class="uil uil-check-circle services__modal-service"></i>
                                    <p>Cheerful demeanor</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Services3-->
                <div class="services__content">
                    <div>
                        <i class="uil uil-pen services__icon"></i>
                        <h3 class="services__title">Fashion <br> Editorial</h3>
                    </div>
                    <span class="button button--flex button--small button--link services__button">View More<i class="uil uil-arrow-right button__icon"></i></i></span>

                    <div class="services__modal">
                        <div class="services__modal-content">
                            <h4 class="services__modal-title">Fashion Editorial Qualities</h4>
                            <i class="uil uil-times-circle services__modal-close"></i>

                            <ul class="services__modal-services grid">
                                <li class="services__modal-service">
                                    <i class="uil uil-check-circle services__modal-service"></i>
                                    <p>Alluring Poise</p>
                                </li>

                                <li class="services__modal-service">
                                    <i class="uil uil-check-circle services__modal-service"></i>
                                    <p>Creative delivery</p>
                                </li>

                                <li class="services__modal-service">
                                    <i class="uil uil-check-circle services__modal-service"></i>
                                    <p>Confidence</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        

        <!-- Portfolio-->
        <section class="portfolio section" id="portfolio">
            <h2 class="section__title">Details</h2>
            <span class="section__subtitle">Hair || Eye || Skin || Body</span>

            <div class="portfolio__container container swiper">
                <div class="swiper-wrapper">
                    <!-- Portfolio 1-->
                    <div class="portfolio__content grid swiper-slide">
                        <img src="img\Organiyu5.jpg" alt="" class= "portfolio__img">

                        <div class="portfolio__data">
                            <h3 class="portfolio__title">Hair</h3>
                            <ul>
                                <li>
                                    <p>Color: </p>
                                    <p class = "portfolio__description">     Black</p>
                                </li>
                                <li>
                                    <p>Type: </p>
                                    <p class = "portfolio__description">4C Afro-Kinky</p>
                                </li>
                                <li>
                                    <p>Length: </p>
                                    <p class = "portfolio__description">12 inches</p>
                                </li>
                            </ul>
                            <h3 class="portfolio__title">Eyes</h3>
                            <ul>
                                <li>
                                    <p>Pupil Color: </p>
                                    <p class="portfolio__description">Dark Brown</p>
                                </li>
                                <li>
                                    <p>Shape: </p>
                                    <p class="portfolio__description">Oval</p>
                                </li>
                                <li>
                                    <p>Distance Apart: </p>
                                    <p class="portfolio__description">3.7cm</p>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Portfolio 2-->
                    <div class="portfolio__content grid swiper-slide">
                        <img src="img\IMG_8882 (2).jpg" alt="" class="portfolio__img">
                    
                        <div class="portfolio__data">
                            <h3 class="portfolio__title">Skin</h3>
                            <ul>
                                <li>
                                    <p>Shade: </p>
                                    <p class="portfolio__description"> Almond</p>
                                </li>
                                <li>
                                    <p>Skin Conditions and Tattoos: </p>
                                    <p class="portfolio__description">None</p>
                                </li>
                            </ul>
                            <h3 class="portfolio__title">Body</h3>
                            <ul>
                                <li>
                                    <p>Height: </p>
                                    <p class="portfolio__description">174cm</p>
                                </li>
                                <li>
                                    <p>Chest circumference: </p>
                                    <p class="portfolio__description">32cm</p>
                                </li>
                                <li>
                                    <p>Waist circumference: </p>
                                    <p class="portfolio__description">26cm</p>
                                </li>
                                <li>
                                    <p>Hip Circumference: </p>
                                    <p class="portfolio__description">37cm</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Add Arrows-->
                <div class="swiper-button-next">
                    <i class="uil uil-angle-right-b swiper-portfolio-icon"></i>
                </div>
                <div class="swiper-button-prev">
                    <i class="uil uil-angle-left-b swiper-portfolio-icon"></i>
                </div>

                <!-- Add Pagination-->
                <div class="swiper-pagination"></div>
            </div>
        </section>

        
        <section class="testimonial section">
            <h2 class="section__title">Testimonial</h2>
            <span class="section__subtitle">My client saying</span>
        
            <div class="testimonial__container container swiper">
                <div class="swiper-wrapper swiper-slide">
                    <!-- Testimonial1-->
                    <div class="testimonial__content swiper-slide">
                        <div class="testimonial__data">
                            <div class="testimonial__header">
                                <img src="img\IMG_5441.jpg" alt="" class="testimonial__img">
        
                                <div>
                                    <h3 class="testimonial__name">Kene Matylda</h3>
                                    <span class="testimonial__client">Creative Director of Kaimaara Brand</span>
                                </div>
                            </div>
                            <div>
                                <i class="uil uil-star testimonial__icon-star"></i>
                                <i class="uil uil-star testimonial__icon-star"></i>
                                <i class="uil uil-star testimonial__icon-star"></i>
                                <i class="uil uil-star testimonial__icon-star"></i>
                                <i class="uil uil-star testimonial__icon-star"></i>
                            </div>
                        </div>
                        <p class="testimonial_description">She's stunning, yet professional and humble. I'd choose her to represent my brand anytime</p>
                    </div>
                    <!-- Testimonial2-->
                    <div class="testimonial__content swiper-slide">
                        <div class="testimonial__data">
                            <div class="testimonial__header">
                                <img src="img\IMG_5443.jpg" alt="" class="testimonial__img">
        
                                <div>
                                    <h3 class="testimonial__name">Emma Tam</h3>
                                    <span class="testimonial__client">Australian travelling photographer</span>
                                </div>
                            </div>
                            <div>
                                <i class="uil uil-star testimonial__icon-star"></i>
                                <i class="uil uil-star testimonial__icon-star"></i>
                                <i class="uil uil-star testimonial__icon-star"></i>
                                <i class="uil uil-star testimonial__icon-star"></i>
                                <i class="uil uil-star testimonial__icon-star"></i>
                            </div>
                        </div>
                        <p class="testimonial_description">Incredible model! Working with her made me remember why I loved my job</p>
                    </div>
                    
                </div>
        
                <!-- Add Pagination -->
                <div class="swiper-pagination swiper-pagination-testimonial"></div>
            </div>
        </section>

        <!-- Contact Me-->
        <section class="contact section" id="contact">
            <h2 class="section__title">Contact Me</h2>
            <span class="section__subtitle">Get in Touch</span>

            <div class="contact__container container grid">
                <div>
                    <div class="contact__information">
                        <i class="uil uil-phone contact__icon"></i>

                        <div>
                            <h3 class="contact__title">Call me</h3>
                            <span class="contact__subtitle">+1-415-570-3748</span>
                        </div>
                    </div>

                    <div class="contact__information">
                        <i class="uil uil-envelope contact__icon"></i>
                    
                        <div>
                            <h3 class="contact__title">Email</h3>
                            <span class="contact__subtitle">chiamakabrowneyes@gmail.com</span>
                        </div>
                    </div>

                    <div class="contact__information">
                        <i class="uil uil-location-point contact__icon"></i>
                    
                        <div>
                            <h3 class="contact__title">Location</h3>
                            <span class="contact__subtitle">San-Francisco, California</span>
                        </div>
                    </div>
                </div>

                <form action="" class="contact__form grid">
                    <div class="contact__inputs grid">
                        <div class="contact__content">
                            <label for="" class="contact__label">Name</label>
                            <input type="text" class="contact__input">
                        </div>
                        <div class="contact__content">
                            <label for="" class="contact__label">Email</label>
                            <input type="email" class="contact__input">
                        </div>
                        <div class="contact__content">
                            <label for="" class="contact__label">Project</label>
                            <input type="text" class="contact__input">
                        </div>
                        <div class="contact__content">
                            <label for="" class="contact__label">Message</label>
                            <textarea name="" id="" cols="0" rows="7" class="contact__input"></textarea>
                        </div>

                        <div>
                            <a href="#" class="button button--flex">
                                Send Message
                                <i class="uil uil-message button__icon"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div>
            <div class="footer__bg">
                <div class="footer__container container grid">
                    <h1 class="footer__title">Chiamaka</h1>
                    <span class="footer__subtitle">Frontend Developer</span>
                </div>
            
                <ul class="footer__links">
                    <li>
                        <a href="#services" class="footer__link">Services</a>
                    </li>
                    <li>
                        <a href="#portfolio" class="footer__link">Portfolio</a>
                    </li>
                    <li>
                        <a href="#contact" class="footer__link">Contactme</a>
                    </li>
                </ul>
            
                <div class="footer__socials">
                    <a href="https://www.facebook.com/" target="_blank" class="footer__social">
                        <i class="uil uil-facebook-f"></i>
                    </a>
            
                    <a href="https://www.instagram.com/" target="_blank" class="footer__social">
                        <i class="uil uil-instagram"></i>
                    </a>
            
                    <a href="https://twitter.com/" target="_blank" class="footer__social">
                        <i class="uil uil-twitter-alt"></i>
                    </a>
                </div>
            </div>
            <p class="footer__copy">&#169; Chiamaka. All rights reserved</p>
        </div>
    </footer>

    <a href="#" class="scrollup" id="scroll-up">
        <i class="uil uil-arrow-up scrollup__icon"></i>
    </a>


    <script src="../js/swiper-bundle.min.js"></script>
    <script src="../js/main.js"> </script>
    </script>
</body>

</html>