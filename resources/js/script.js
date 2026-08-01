// ===============================
// LANDING PAGE
// ===============================

// ===============================
// HEADER GLASS EFFECT
// ===============================
const header = document.getElementById("siteHeader");

window.addEventListener("scroll", () => {
    if (window.scrollY > 20) {
        header.classList.add("scrolled");
    } else {
        header.classList.remove("scrolled");
    }
});


// ===============================
// MOBILE MENU
// ===============================
const hamburger = document.getElementById("hamburger");
const mobileNav = document.getElementById("mobileNav");

hamburger.addEventListener("click", () => {

    hamburger.classList.toggle("active");
    mobileNav.classList.toggle("active");

});


// ===============================
// SMOOTH SCROLL
// ===============================
document.querySelectorAll('a[href^="#"]').forEach(link => {

    link.addEventListener("click", e => {

        e.preventDefault();

        const target = document.querySelector(link.getAttribute("href"));

        if (target) {

            target.scrollIntoView({
                behavior: "smooth"
            });

            mobileNav.classList.remove("active");
            hamburger.classList.remove("active");

        }

    });

});



// ===============================
// INTERSECTION OBSERVER
// ===============================
const observer = new IntersectionObserver(entries => {

    entries.forEach(entry => {

        if (entry.isIntersecting) {

            entry.target.classList.add("show");

        }

    });

}, {
    threshold: .15
});


document.querySelectorAll("[data-reveal]").forEach(el => {

    observer.observe(el);

});




// ===============================
// STAGGER FEATURE CARDS
// ===============================
document.querySelectorAll(".feature-card").forEach((card, index) => {

    card.style.transitionDelay = `${index * 120}ms`;

});



// ===============================
// ACCORDION
// ===============================
document.querySelectorAll(".accordion-trigger").forEach(button => {

    button.addEventListener("click", () => {

        const item = button.parentElement;

        item.classList.toggle("open");

    });

});



// ===============================
// CARD TILT
// ===============================
document.querySelectorAll("[data-tilt]").forEach(card => {

    card.addEventListener("mousemove", e => {

        const rect = card.getBoundingClientRect();

        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;

        const rotateX = -(y - rect.height / 2) / 12;
        const rotateY = (x - rect.width / 2) / 12;

        card.style.transform =
            `perspective(1000px)
            rotateX(${rotateX}deg)
            rotateY(${rotateY}deg)
            translateY(-8px)`;

    });


    card.addEventListener("mouseleave", () => {

        card.style.transform = "";

    });

});



// ===============================
// PARALLAX
// ===============================
const parallaxItems = document.querySelectorAll("[data-parallax]");

window.addEventListener("mousemove", e => {

    const x = (e.clientX / window.innerWidth - .5);
    const y = (e.clientY / window.innerHeight - .5);

    parallaxItems.forEach(item => {

        const speed = item.dataset.parallax;

        item.style.transform =
            `translate(
            ${x * speed * 100}px,
            ${y * speed * 100}px
            )`;

    });

});




// ===============================
// FLOATING PARTICLES
// ===============================
document.querySelectorAll(".faq-particle").forEach((particle, i) => {

    particle.animate([

        {
            transform: "translateY(0px)"
        },

        {
            transform: "translateY(-18px)"
        },

        {
            transform: "translateY(0px)"
        }

    ], {

        duration: 3000 + i * 700,
        iterations: Infinity

    });

});




// ===============================
// CTA FORM
// ===============================
const form = document.getElementById("ctaForm");
const status = document.getElementById("ctaStatus");

form.addEventListener("submit", e => {

    e.preventDefault();

    status.innerText =
        "✨ Welcome to Atomic-Bits.";

});