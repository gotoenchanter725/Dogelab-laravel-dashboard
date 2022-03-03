<?php
header("Content-Type:text/css");
$color1 = "#f0f"; // Change your Color Here
$color2 = "#ff8"; // Change your Color Here

function checkhexcolor($color1){
    return preg_match('/^#[a-f0-9]{6}$/i', $color1);
}

if (isset($_GET['color']) AND $_GET['color'] != '') {
    $color1 = "#" . $_GET['color'];
}

if (!$color1 OR !checkhexcolor($color1)) {
    $color1 = "#336699";
}


function checkhexcolor2($color2){
    return preg_match('/^#[a-f0-9]{6}$/i', $color2);
}

if (isset($_GET['secondColor']) AND $_GET['secondColor'] != '') {
    $color2 = "#" . $_GET['secondColor'];
}

if (!$color2 OR !checkhexcolor2($color2)) {
    $color2 = "#336699";
}
?>

.section__cate, .section__cate::before, .select-bar option, .feature__item:hover .feature__icon, .faq__item.open .faq__title, .investor__item:hover::after, *::selection, .bg--overlay::before, .bg--theme--overlay::before, .bg--theme--overlay-2::before, .menu li .submenu li:hover > a, .investor__item:hover::after, .cmn--table thead, .faq__item.open .faq__title, .pagination .page-item a, .pagination .page-item span, .social__icons li a:hover {
    background-color: <?php echo $color1?>
}

.btn--base,.badge--base,.bg--base {
    background-color: <?php echo $color1?>!important
}


.about--list li::before, .chairman--quote::before, .counter__item:hover i, p a, p a:hover, .text--base, .copyright .footer-links li a::after, .contact__item .contact__content ul li a:hover, .cmn--outline--btn, .pagination .page-item.active span,.pagination .page-item.active a, .pagination .page-item:hover span,.pagination .page-item:hover a {
    color:  <?php echo $color1?>
}

.chairman--quote {
    border-color:  <?php echo $color1?>
}


.bg--theme , .nav--tabs .nav-item .nav-link.active, .bg--theme--overlay::before, .cmn--btn, .bg--theme--overlay-2::before, .nav--tabs .nav-item .nav-link.active, .preloader  {
    background: linear-gradient(to right, <?php echo $color2 ?> 2%, <?php echo $color1 ?> 82%);
}

.bg--theme-2, .cmn--btn:hover {
    background: linear-gradient(to left, <?php echo $color2 ?> 2%, <?php echo $color1 ?> 82%);
}





.header-section.active, .header-section.active, .scrollToTop, .video-button, .video-button::before, .video-button::after, .copied::after  {
    background-color: <?php echo $color2?>
}
.text--1 {
    color: <?php echo $color2?>
}

.feature__item .feature__icon {
    background-color: <?php echo $color1?>57
}

.counter__item i {
    color: <?php echo $color1?>4d
}

.investor__item:hover .investor__thumb {
    box-shadow: 0 0 0 4px <?php echo $color2?>33, 0 0 0 8px <?php echo $color2?>33, 0 0 0 12px <?php echo $color2?>33, 0 0 0 16px <?php echo $color2?>33, 0 0 0 20px <?php echo $color2?>33;
}

.cmn--outline--btn {
    border-color: <?php echo $color1?>80
}

.cmn--outline--btn:hover {
    color: #fff;
    border-color:<?php echo $color1?>;
    background: <?php echo $color1?>;
}

.pagination .page-item.disabled span {
    background: <?php echo $color1?>4d
}


