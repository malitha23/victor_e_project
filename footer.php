<!-- Style CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<style>
  a {
    -webkit-transition: .3s all ease;
    -o-transition: .3s all ease;
    transition: .3s all ease;
  }

  a,
  a:hover {
    text-decoration: none !important;
  }

  .content {
    height: 70vh;
  }

  .footer-32892 {
    background-color: rgb(0, 0, 0);
    padding: 7rem 0;
    color: #fff;
    font-size: 16px;
  }

  .footer-32892 h3 {
    font-size: 20px;
    color: #fff;
    margin-bottom: 30px;
  }

  .footer-32892 .row.gallery {
    margin-right: -5px;
    margin-left: -5px;
  }

  .footer-32892 .row.gallery>[class^="col-"],
  .footer-32892 .row.gallery>[class*=" col-"] {
    padding-right: 5px;
    padding-left: 5px;
  }

  .footer-32892 .gallery a {
    display: block;
    margin-bottom: 10px;
    -webkit-transition: .3s all ease;
    -o-transition: .3s all ease;
    transition: .3s all ease;
  }

  .footer-32892 .gallery a:hover {
    opacity: .5;
  }

  .footer-32892 .quick-info li {
    color: #fff;
    font-size: 16px;
    margin-bottom: 10px;
  }

  .footer-32892 .quick-info li a {
    color: #fff;
  }

  .footer-32892 .quick-info li .icon {
    font-size: 20px;
    color: #f88020;
  }

  .footer-32892 .subscribe {
    position: relative;
  }

  .footer-32892 .subscribe .form-control {
    background-color: #292b31;
    -webkit-box-shadow: none;
    box-shadow: none;
    border-radius: 30px;
    height: 55px;
    padding-left: 30px;
    padding-right: 130px;
    border: none;
    color: #fff;
  }

  .footer-32892 .subscribe .form-control::-webkit-input-placeholder {
    color: #ccc;
    font-size: 14px;
  }

  .footer-32892 .subscribe .form-control::-moz-placeholder {
    color: #ccc;
    font-size: 14px;
  }

  .footer-32892 .subscribe .form-control:-ms-input-placeholder {
    color: #ccc;
    font-size: 14px;
  }

  .footer-32892 .subscribe .form-control:-moz-placeholder {
    color: #ccc;
    font-size: 14px;
  }

  .footer-32892 .subscribe .btn-submit {
    background: #f88020;
    height: 47px;
    border-radius: 30px;
    padding-left: 30px;
    padding-right: 30px;
    color: #fff;
    font-weight: bold;
    position: absolute;
    top: 4px;
    right: 4px;
    -webkit-box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.2);
    box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.2);
  }

  .footer-32892 .tweets li {
    margin-bottom: 20px;
    font-size: 15px;
    font-style: italic;
    font-family: "Source Serif Pro", serif;
  }

  .footer-32892 .tweets li span {
    color: #fff;
  }

  .footer-32892 .footer-menu-wrap {
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    padding-top: 2rem !important;
    margin-top: 7rem;
  }

  .footer-32892 .footer-menu {
    margin-bottom: 0;
  }

  .footer-32892 .footer-menu li {
    display: inline-block;
  }

  @media (max-width: 767.98px) {
    .footer-32892 .footer-menu li {
      display: block;
    }
  }

  .footer-32892 .footer-menu li a {
    padding: 10px;
    display: inline-block;
    color: #fff;
  }

  @media (max-width: 767.98px) {
    .footer-32892 .footer-menu li a {
      display: block;
      padding-left: 0px;
    }
  }

  .footer-32892 .footer-menu li:first-child a {
    padding-left: 0;
  }

  .footer-32892 .site-logo {
    color: #fff;
    font-size: 20px;
  }
</style>


<footer class="footer-32892 pb-0" style="margin-top:50px;">
  <div class="site-section">
    <div class="container">


      <div class="row">

        <div class="col-md pr-md-5 mb-4 mb-md-0">
          <h3>Vicstore</h3>
          <div style="margin-bottom: 15px;"><img src="assets/images/logo/logo-two-black.png" alt="" class="mb-4"></div>
          <div style="margin-bottom: 15px; padding-right:20px;">
            <p class="mb-4">At Vicstore, we ensure the best quality items, offering reliability, excellence, and customer satisfaction.</p>
          </div>
          <div>
          <ul class="list-unstyled quick-info mb-4 mt-5">
              <?php
              $contact_d = Database::Search("SELECT * FROM `contact`");
              $con = $contact_d->fetch_assoc();
              ?>
              <li><a href="tel:<?php echo $con['mobile']; ?>" class="d-flex align-items-center"><i class="bi bi-telephone-fill"></i>&nbsp;&nbsp;<?php echo $con['mobile']; ?></a></li>
              <li><a href="mailto:<?php echo $con['email']; ?>" class="d-flex align-items-center"><i class="bi bi-envelope-at-fill"></i>&nbsp;&nbsp; <?php echo $con['email']; ?></a></li>
            </ul>
          </div>
        </div>


        <style>
          .footer-link a {
            color: white;
            text-decoration: none;
            transition: color 0.3s ease;
          }

          .footer-link a:hover {
            color: #FA6400;
          }

          .developer-name {
            color: #FA6400 !important;
            font-weight: 600;
          }
        </style>

        <div class="col-md-3 mb-4 mb-md-0">
          <h3 class="">Links</h3>
          <ul class="list-unstyled  footer-link" style="padding-right:20px;">
            <li class="d-flex justify-content-start fst-normal" style="margin-bottom: 20px;"><a href="index.php">Home</a></li>
            <li class="d-flex justify-content-start fst-normal" style="margin-bottom: 20px;"><a href="shop.php">Shop</a></li>
            <li class="d-flex justify-content-start fst-normal" style="margin-bottom: 20px;"><a href="account.php">Profile</a></li>
            <li class="d-flex justify-content-start fst-normal" style="margin-bottom: 20px;"><a href="contact.php">Contact</a></li>
          </ul>
        </div>

        <div class="col-md mb-4 mb-md-0">
          <h3>Why Choose Us</h3>
          <ul class="list-unstyled " style="padding-right:20px;">
            <li class="d-flex" style="margin-bottom: 20px;">

              <div class="mr-4"><i class="bi bi-cursor-fill"></i>&nbsp;&nbsp;</div>
              <div class="fst-normal">&nbsp;&nbsp;Choose Vicstore for top-quality products, unbeatable service, secure payments, and customer satisfaction.</div>
            </li>
            <li class="d-flex" style="margin-bottom: 20px;">

              <div class="mr-4"><i class="bi bi-cursor-fill"></i>&nbsp;&nbsp;</div>
              <div class="fst-normal">&nbsp;&nbsp;Vicstore offers reliable, high-quality items, fast delivery, and exceptional customer service every time.</div>
            </li>
            <li class="d-flex" style="margin-bottom: 20px;">
              <div class="mr-4"><i class="bi bi-cursor-fill"></i>&nbsp;&nbsp;</div>
              <div class="fst-normal">&nbsp;&nbsp;Experience seamless shopping at Vicstore with secure payments, 24/7 support, and exclusive offers.</div>
            </li>
          </ul>
        </div>

        <div class="col-12" style="margin-bottom: 15px;">
          <div class="py-5 footer-menu-wrap d-md-flex align-items-center">
            <p class="mb-0 text-center text-md-start">
              2025 Designed & Developed by
              <a href="https://codyzea.co.nz/" class="developer-name">CODY ZEA SOFTWARE SOLUTIONS</a>, &nbsp;&nbsp;All rights reserved.
            </p>
          </div>
        </div>


      </div>
    </div>
  </div>
</footer>