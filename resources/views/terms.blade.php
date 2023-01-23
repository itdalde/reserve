<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>{{ config('app.name') }}</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <link href="{{ asset('assets/landing/img/favicon.ico') }}" rel="icon">
    <link href="{{ asset('assets/landing/img/favicon.ico') }}" rel="apple-touch-icon">

    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <link href="{{ asset('assets/landing/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/landing/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/landing/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/landing/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/landing/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/landing/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/landing/css/style.css') }}" rel="stylesheet">
</head>
<body>
<!-- ======= Header ======= -->
<header id="header" class="fixed-top d-flex align-items-center">
    <div class="container d-flex align-items-center">

        <div class="logo me-auto">
            <a href="/"><img src="{{ asset('assets/landing/img/Logo.png') }}" alt="" class="img-fluid"></a>
        </div>

        <nav id="navbar" class="navbar order-last order-lg-0">

            <ul style=" {{__('home.home')  == 'Home' ? 'direction: ltr;' : 'direction: rtl;'}}">
                <li><a class="nav-link scrollto " href="/">{{__('home.home')}}</a></li>
                <li><a class="nav-link scrollto" href="/?#services">{{__('home.what_we_offer')}}</a></li>
                <li><a class="nav-link scrollto " href="/?#portfolio">{{__('home.for_vendors')}}</a></li>
            </ul>
            <ul>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-bs-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        <span
                            class="fi fis fi-{{Config::get('languages')[App::getLocale()]['flag-icon']}}"></span> {{ Config::get('languages')[App::getLocale()]['display'] }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        @foreach (Config::get('languages') as $lang => $language)
                            @if ($lang != App::getLocale())
                                <a class="dropdown-item text-dark w-75" href="{{ route('lang.switch', $lang) }}"><span
                                        class="fi fis fi-{{$language['flag-icon']}}"></span> {{$language['display']}}
                                </a>
                            @endif
                        @endforeach
                    </div>
                </li>

            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->
    </div>
</header><!-- End Header -->

<main id="main">
    <p class="p-2" style="margin-top: 3em;">
    </p>

    <div class=" sub-section-bg">
        <h3 style="margin-left: 122px" class="pt-3 text-white" data-aos="fade-up">Terms and Conditions</h3>
    </div>
    <!-- ======= Terms and Conditions Section ======= -->
    <section id="faq" class="faq" data-aos="zoom-in">
        <div class="container" style="margin-top: -112px;">
            <div class="col-md-12">
                <div class="d-flex flex-column mt-5">
                    <div class="p-2">
                        <h3 class="mt-3">Description of the Services</h3>
                        <div>
                            Reserve is a platform that is created and operated by Savant Computer Solutions company. Our
                            services are linking the customer to vendors to complete tasks in different occasions or
                            gatherings.
                            We work together into providing a high-quality service. However, we are not responsible of
                            the
                            quality of the services provided by the vendor. It is very important to understand that we
                            will take
                            all steps possible to fix the problem unless it is not under our control. Our main goal is
                            to
                            simplify the user experience when it comes to communicating and following up in hospitality
                            matters.
                        </div>
                        <h3>Order Cancellation</h3>
                        <div>
                            When placing an order, it passes in multiple phases. As we do not provide same day service,
                            to
                            cancel you must contact customer support. A customer has the right to cancel while the order
                            is
                            still in pending status. Once the order is accepted by the vendor it is not possible to
                            cancel
                            anymore without reaching out to customer support. Placing an order means you as a customer
                            have
                            accepted to place the order and you are just waiting for the acceptant from the vendor side.
                        </div>
                        <h3> No Show</h3>
                        <div>
                            When placing an order sometimes you need to provide an address where the service will be
                            delivered.
                            If the customer does not respond at the time of the agreed service time. The vendor will try
                            to
                            contact you and wait for 30 minutes at the mentioned address. Once the 30 minutes pass full
                            payment
                            will be charged and this will be count as a no-show fee as well.
                        </div>
                        <h3> Support Contact and Online Butler</h3>
                        <div>
                            You may contact us anytime during our business hours, we will do our best to ensure service
                            quality
                            from our end. Our team as well might contact you to and assign a butler to you. A butler
                            responsibility is to personalize the customer services experience. If a butler has been
                            assigned to
                            you, they will be available to contact if any issue or concern arise. Please note that a
                            butler
                            service is complimentary with no additional cost yet not all orders will be assigned a
                            butler
                            service. Only the orders that we believe that require a butler will be assigned one. We
                            reserve the
                            right to terminate this service at any point without notice.
                        </div>
                    </div>
                    <div class="p-2">
                        <h3>Return</h3>

                        <div>
                            Any order that is returnable is subject to the return policy by the vendor. If a product has
                            a sever
                            issue that is affecting health or quality standards then a complain case should be issued by
                            contacting us through the app. We hold no responsibility in the products that are delivered
                            by the
                            vendors.
                        </div>
                        <h3>Payment Methods</h3>
                        <div>
                            We currently offer ApplePay, GooglePay, Credit Card and Local Debit Cards. We have the right
                            to
                            discontinue providing any payment mothed at any time without a prior notice. Customer can
                            pick any
                            payment method to place an order at the time of check out. However, no order shall be placed
                            without
                            having a credit card stored for future due payments. A customer chooses to place an order
                            and a
                            customer chooses to store his card. When placing an order 50% of order total will be charged
                            once
                            the status of the order is accepted. The remaining balance is due and will be charged on the
                            day of
                            delivery. A customer has the right to delete any stored card at any time if there is no
                            order in
                            progress.
                        </div>
                        <h3> Delivery</h3>
                        <div>
                            A customer is required to accept the delivery on the date and time ordered. All deliveries
                            are made
                            by our partners. If there were any issues regarding a delivery customer must report it
                            within 24
                            hours of arrival to our customer service. However, you must have supporting documents of any
                            issue
                            you would like us to resolve. We always recommend taking pictures of all items that were
                            delivered.
                        </div>
                        <h3>Refund Policy</h3>
                        <div>
                            Any order that is placed will not be charged until it is accepted by the service provider.
                            If you
                            decided to cancel your order, we might issue a full or partial refund depending on how much
                            work has
                            been done on to complete your order. Refunds that are being credited to your wallet will not
                            have a
                            fee and must be used in 12 months. Refunds to the payment method might take up to 14
                            business days
                            and might have a service fee depending on how much we are charged by your bank.
                        </div>
                        <h3>Promo codes</h3>
                        <div>
                            Any promo code is one time use. You agree to not abuse the system when using promo codes. We
                            have
                            the right to cancel any promo codes at anytime without a prior notice. If an order is placed
                            using a
                            promo code that abuse the system we have the right to recalculate the total.
                        </div>
                    </div>
                    <div class="p-2">
                        <h3>Pricing </h3>
                        <div>
                            All prices that are shown in our platform are controlled by the service providers. If you
                            choose to
                            place an order and pay by card keep in mind that the price might be different than what
                            shown to you
                            if there were any special requests made. Thus, we will contact you in such cases. If you
                            choose to
                            not accept the fare difference then the order will be canceled.
                        </div>
                        <h3>Custom Orders</h3>
                        <div>
                            When placing a custom order, it goes into multiple steps. During those steps the service
                            provided
                            might contact you through the app multiple time and adjusting the order details and pricing.
                            When
                            the service provided is not able to reach you, we will step in and try to contact you. Any
                            custom
                            order must have a respond within 24 hours from the time a service provided sends an offer.
                            It is
                            your responsibility to clarify any misunderstanding that might arise if not clearly
                            mentioned in the
                            order details. Reserve holds no responsibility in any misunderstanding. If a custom order
                            option is
                            not available when looking into the service this means it is not offered.
                        </div>
                        <h3>Quality Control</h3>
                        <div>
                            Reserve is here to save you time and help in smoothing your experience. Thus, we guarantee
                            you that
                            any detail that is mentioned in the order details description will be fulfilled. If you are
                            not
                            satisfied with an order, please contact us immediately and we will make our best to resolve
                            any
                            issues. We take customer satisfaction very seriously and we will try to enforce it on our
                            partners.
                        </div>
                        <h3> Authority of Reserve</h3>
                        <div>
                            We have full authority of any interaction through our app or website. We might suspend the
                            service
                            or interrupt it with or without a notice. We hold no responsibility to anyone if such case
                            where to
                            happen. We might delete or block or limit any account with or without a reason. Any issue
                            that
                            arises that can not be solved between the vendor and the user it must be escalated to
                            Reserve
                            Customer support team and an investigation case will be created to resolve the issue.
                        </div>
                    </div>
                    <div class="p-2">
                        <h3> Prohibited Activities </h3>
                        <div>
                            Using our services is under the control of Qatari and GCC laws. You are not allowed to
                            transfer or
                            allow anyone else rather than you to use your account. No one under the age of 18 years old
                            is
                            allowed to create an account or placing an order.
                        </div>
                        <h3>Reviews Guidelines</h3>
                        <div>
                            A review must be written based on a true order that was placed. Writing fake review will not
                            be
                            tolerated. All reviews that are written on our platform are the property of Savant Company
                            we may
                            reuse or modify any reviews. We may delete any review with or without a reason at any time.
                        </div>
                        <h3> Intellectual Property Rights</h3>
                        <div>
                            Reserve is property of Savant Company. You are not allowed to use or copy any of the logo,
                            content,
                            buttons, icons, and the timeline of the service. You are not allowed to copy or download
                            anything
                            from our website or app without a written approval.
                        </div>
                        <h3> Commercial Use </h3>
                        <div>
                            Everything that is on our app or our website is not allowed to be used for commercial use.
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </section><!-- End Terms and Conditions Section -->

</main><!-- End #main -->

<!-- ======= Footer ======= -->
@include('layouts.includes.footer')
<!-- End Footer -->

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
        class="bi bi-arrow-up-short"></i></a>
<!-- Vendor JS Files -->
<script src="{{ asset('assets/landing/vendor/aos/aos.js') }}"></script>
<script src="{{ asset('assets/landing/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/landing/vendor/glightbox/js/glightbox.min.js') }}"></script>
<script src="{{ asset('assets/landing/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('assets/landing/vendor/swiper/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('assets/landing/vendor/php-email-form/validate.js') }}"></script>

<!-- Template Main JS File -->
<script src="{{ asset('assets/landing/js/main.js') }}"></script>
</body>
</html>

