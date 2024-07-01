/**
 * Template Name: Presento - v3.7.0
 * Template URL: https://bootstrapmade.com/presento-bootstrap-corporate-template/
 * Author: BootstrapMade.com
 * License: https://bootstrapmade.com/license/
 */
(function () {
    "use strict";

    /**
     * Easy selector helper function
     */
    const select = (el, all = false) => {
        el = el.trim();
        if (all) {
            return [...document.querySelectorAll(el)];
        } else {
            return document.querySelector(el);
        }
    };

    /**
     * Easy event listener function
     */
    const on = (type, el, listener, all = false) => {
        let selectEl = select(el, all);
        if (selectEl) {
            if (all) {
                selectEl.forEach((e) => e.addEventListener(type, listener));
            } else {
                selectEl.addEventListener(type, listener);
            }
        }
    };

    /**
     * Easy on scroll event listener
     */
    const onscroll = (el, listener) => {
        el.addEventListener("scroll", listener);
    };

    /**
     * Navbar links active state on scroll
     */
    let navbarlinks = select("#navbar .scrollto", true);
    const navbarlinksActive = () => {
        let position = window.scrollY + 200;
        navbarlinks.forEach((navbarlink) => {
            if (!navbarlink.hash) return;
            let section = select(navbarlink.hash);
            if (!section) return;
            if (
                position >= section.offsetTop &&
                position <= section.offsetTop + section.offsetHeight
            ) {
                navbarlink.classList.add("active");
            } else {
                navbarlink.classList.remove("active");
            }
        });
    };
    window.addEventListener("load", navbarlinksActive);
    onscroll(document, navbarlinksActive);

    /**
     * Scrolls to an element with header offset
     */
    const scrollto = (el) => {
        let header = select("#header");
        let offset = header.offsetHeight;

        if (!header.classList.contains("header-scrolled")) {
            offset -= 16;
        }

        let elementPos = select(el).offsetTop;
        window.scrollTo({
            top: elementPos - offset,
            behavior: "smooth",
        });
    };

    /**
     * Toggle .header-scrolled class to #header when page is scrolled
     */
    let selectHeader = select("#header");
    if (selectHeader) {
        const headerScrolled = () => {
            if (window.scrollY > 100) {
                selectHeader.classList.add("header-scrolled");
            } else {
                selectHeader.classList.remove("header-scrolled");
            }
        };
        window.addEventListener("load", headerScrolled);
        onscroll(document, headerScrolled);
    }

    /**
     * Back to top button
     */
    let backtotop = select(".back-to-top");
    if (backtotop) {
        const toggleBacktotop = () => {
            if (window.scrollY > 100) {
                backtotop.classList.add("active");
            } else {
                backtotop.classList.remove("active");
            }
        };
        window.addEventListener("load", toggleBacktotop);
        onscroll(document, toggleBacktotop);
    }

    /**
     * Mobile nav toggle
     */
    on("click", ".mobile-nav-toggle", function (e) {
        select("#navbar").classList.toggle("navbar-mobile");
        this.classList.toggle("bi-list");
        this.classList.toggle("bi-x");
    });

    // Function to hide the mobile navigation
    function hideMobileNav() {
        var navbar = document.querySelector("#navbar");
        var mobileNavToggle = document.querySelector(".mobile-nav-toggle");
        if (navbar && navbar.classList.contains("navbar-mobile")) {
            navbar.classList.remove("navbar-mobile");
            if (mobileNavToggle) {
                mobileNavToggle.classList.remove("bi-x");
                mobileNavToggle.classList.add("bi-list");
            }
        }
    }

    // Setup event listeners using jQuery
    $(document).ready(function () {
        // Toggle mobile navigation
        $(".mobile-nav-toggle").on("click", function () {
            $("#navbar").toggleClass("navbar-mobile");
            $(this).toggleClass("bi-list bi-x");
        });

        // Hide mobile nav when login or register is clicked
        $(".login a, .register a").on("click", function () {
            // hideMobileNav();
            alert("test");
        });

        // Additional existing scripts
        // Add other initializations and event bindings
    });
    /**
     * Mobile nav dropdowns activate
     */
    on(
        "click",
        ".navbar .dropdown > a",
        function (e) {
            if (select("#navbar").classList.contains("navbar-mobile")) {
                e.preventDefault();
                this.nextElementSibling.classList.toggle("dropdown-active");
            }
        },
        true
    );

    /**
     * Scrool with ofset on links with a class name .scrollto
     */
    on(
        "click",
        ".scrollto",
        function (e) {
            if (select(this.hash)) {
                e.preventDefault();

                let navbar = select("#navbar");
                if (navbar.classList.contains("navbar-mobile")) {
                    navbar.classList.remove("navbar-mobile");
                    let navbarToggle = select(".mobile-nav-toggle");
                    navbarToggle.classList.toggle("bi-list");
                    navbarToggle.classList.toggle("bi-x");
                }
                scrollto(this.hash);
            }
        },
        true
    );

    /**
     * Scroll with ofset on page load with hash links in the url
     */
    window.addEventListener("load", () => {
        if (window.location.hash) {
            if (select(window.location.hash)) {
                scrollto(window.location.hash);
            }
        }
    });

    /**
     * Animation on scroll
     */
    window.addEventListener("load", () => {
        AOS.init({
            duration: 1000,
            easing: "ease-in-out",
            once: true,
            mirror: false,
        });
    });
})();

/*-----------------------------------------------------------------------------------*/
/*  NOTIFY
/*-----------------------------------------------------------------------------------*/
function notifyAppError(error) {
    notifyAppError(error, "body");
}

function notifyAppError(error, el) {
    $.alert({
        title: "<i class='fa fa-exclamation-circle'></i> Error ",
        content: error,
        type: "red",
        typeAnimated: true,
    });
}

function notifySystemError(error) {
    notifySystemError(error, "body");
}

function notifySystemError(error, el) {
    $.alert({
        title: "<i class='fa fa-exclamation-circle'></i> Error ",
        content: error,
        type: "red",
        typeAnimated: true,
    });
}

function notifyError(error) {
    notifyError(error, "body");
}

function notifyError(error, el) {
    $.alert({
        title: "<i class='fa fa-exclamation-circle'></i> Error ",
        content: error,
        type: "red",
        typeAnimated: true,
    });
}

function notifySuccess(msg) {
    notifySuccess(msg, "body");
}

function notifySuccess(msg, el) {
    $.alert({
        title: "<i class='fa fa-exclamation-circle'></i> Success ",
        content: msg,
        type: "green",
        typeAnimated: true,
    });
}

/*-----------------------------------------------------------------------------------*/
/*  BUTTON SPINNER
/*-----------------------------------------------------------------------------------*/
function startSpin(el) {
    el.data("ori", el.html());
    el.html('<i class="fa fa-spinner"></i>');
    el.addClass("disabled");
}

function stopSpin(el) {
    el.html(el.data("ori"));
    el.removeClass("disabled");
}

// Function to hide the mobile navigation
function hideMobileNav() {
    var navbar = document.querySelector("#navbar");
    if (navbar.classList.contains("navbar-mobile")) {
        navbar.classList.remove("navbar-mobile");
        mobileNavToggle.classList.remove("bi-x");
        mobileNavToggle.classList.add("bi-list");
    }
}

// Add event listeners for modal triggers
$(".login a, .register a").forEach(function (link) {
    link.addEventListener("click", function (e) {
        hideMobileNav();
    });
});
