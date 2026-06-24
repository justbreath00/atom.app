<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Atomic-Bits — Tiny habits. Massive progress.</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&family=Inter:wght@400;500;600;700;800&family=Caveat:wght@600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="styles.css">
</head>
<body>

<!-- decorative gradient blobs, fixed to viewport -->
<div class="bg-blob blob-a" aria-hidden="true"></div>
<div class="bg-blob blob-b" aria-hidden="true"></div>

<!-- ============ HEADER ============ -->
<header class="site-header" id="siteHeader">
  <div class="header-inner">
    <a href="#top" class="logo">Atomic-Bits</a>

    <nav class="main-nav" id="mainNav">
      <a href="#about">About</a>
      <a href="#features">Features</a>
      <a href="#testimonials">Testimonials</a>
      <a href="#faq">FAQ</a>
    </nav>

    <a href="#get-started" class="btn btn-primary btn-cta header-cta">Get Started</a>

    <button class="hamburger" id="hamburger" aria-label="Open menu" aria-expanded="false">
      <span></span><span></span><span></span>
    </button>
  </div>

  <nav class="mobile-nav" id="mobileNav">
    <a href="#about">About</a>
    <a href="#features">Features</a>
    <a href="#testimonials">Testimonials</a>
    <a href="#faq">FAQ</a>
    <a href="#get-started" class="btn btn-primary btn-cta">Get Started</a>
  </nav>
</header>

<main id="top">

  <!-- ============ HERO ============ -->
  <section class="hero">
    <div class="hero-inner">
      <div class="hero-copy" data-reveal="fade-right">
        <p class="eyebrow">a tiny app for big habits</p>
        <h1>Tiny habits.<br><span class="grad-text">Massive progress.</span></h1>
        <p class="hero-sub">
          Atomic-Bits turns university chaos into one calm board. Drag your tasks where they belong,
          drop your classmates into the same workspace, and watch a tiny streak counter
          quietly do what motivation can't.
        </p>
        <div class="hero-actions">
          <a href="#get-started" class="btn btn-primary btn-lg btn-cta">Get Started</a>
          <a href="#features" class="btn btn-ghost btn-lg">See Features</a>
        </div>
      </div>

      <div class="hero-scene" data-reveal="fade-left">
        <!-- floating task cards behind mascot -->
        <div class="float-card card-1">📌 Finish thesis outline</div>
        <div class="float-card card-2">✅ Group project — Ch. 4</div>
        <div class="float-card card-3">🔥 7-day streak</div>

        <div class="mascot-stage" data-parallax="0.04">
          <div class="desk-glow"></div>
          <div class="pixel-ghost" data-mood="default" data-size="9" aria-hidden="true"></div>
          <span class="desk-prop prop-mug" aria-hidden="true">☕</span>
          <span class="desk-prop prop-notes" aria-hidden="true">🗒️</span>
          <span class="desk-prop prop-window prop-window-1" aria-hidden="true"></span>
          <span class="desk-prop prop-window prop-window-2" aria-hidden="true"></span>
          <span class="desk-cursor" aria-hidden="true"></span>
          <div class="desk-laptop" aria-hidden="true"></div>
        </div>
      </div>
    </div>
    <div class="scroll-cue" aria-hidden="true">scroll</div>
  </section>

  <!-- ============ ABOUT ============ -->
  <section class="about" id="about">
    <div class="notebook-bg" aria-hidden="true"></div>
    <div class="section-inner about-grid">

      <div class="about-scene" data-reveal="fade-right">
        <span class="zzz z1" aria-hidden="true">z</span>
        <span class="zzz z2" aria-hidden="true">Z</span>
        <span class="zzz z3" aria-hidden="true">z</span>
        <span class="desk-prop prop-lamp" aria-hidden="true">🛋️</span>
        <div class="pixel-ghost" data-mood="sleep" data-size="9" aria-hidden="true"></div>
        <span class="desk-prop prop-book-stack" aria-hidden="true">📚</span>
      </div>

      <div class="about-copy">
        <p class="eyebrow">the origin story</p>
        <h2>Built on a dorm-room desk, not a boardroom table.</h2>

        <div class="timeline">
          <div class="timeline-item" data-reveal="fade-up">
            <span class="timeline-dot"></span>
            <div>
              <h3>The problem</h3>
              <p>Rain, a student at the University of Eastern Pangasinan, was drowning in scattered group chats, sticky notes, and deadlines that never lived in the same place.</p>
            </div>
          </div>
          <div class="timeline-item" data-reveal="fade-up">
            <span class="timeline-dot"></span>
            <div>
              <h3>The idea</h3>
              <p>Inspired by <em>Atomic Habits</em>, Rain started sketching a board where tiny, repeatable actions — not heroic effort — moved classwork forward.</p>
            </div>
          </div>
          <div class="timeline-item" data-reveal="fade-up">
            <span class="timeline-dot"></span>
            <div>
              <h3>Atomic-Bits</h3>
              <p>What started as a personal task board grew into a shared space where whole classes organize, collaborate, and build streaks together.</p>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>

  <!-- ============ FEATURES ============ -->
  <section class="features" id="features">
    <div class="section-inner">
      <p class="eyebrow center">what it actually does</p>
      <h2 class="center">Everything your group chat was trying to be.</h2>

      <div class="features-layout">
        <div class="features-scene" data-reveal="scale-in">
          <span class="note note-1" aria-hidden="true">♪</span>
          <span class="note note-2" aria-hidden="true">♫</span>
          <span class="note note-3" aria-hidden="true">♪</span>
          <div class="pixel-ghost" data-mood="chill" data-size="9" aria-hidden="true"></div>
          <span class="desk-prop prop-mug prop-mug-chill" aria-hidden="true">☕</span>
        </div>

        <div class="features-grid">
          <article class="feature-card" data-reveal="fade-up" data-tilt>
            <span class="feature-icon">🖱️</span>
            <h3>Drag-and-drop tasks</h3>
            <p>Move tasks between today, this week, and someday without typing a single status update.</p>
          </article>
          <article class="feature-card" data-reveal="fade-up" data-tilt>
            <span class="feature-icon">🧑‍🤝‍🧑</span>
            <h3>Class collaboration</h3>
            <p>Join a class with one code and see what the whole section is working on, instantly.</p>
          </article>
          <article class="feature-card" data-reveal="fade-up" data-tilt>
            <span class="feature-icon">🗂️</span>
            <h3>Multi-user workspace</h3>
            <p>Group projects live in one shared board instead of five different chat threads.</p>
          </article>
          <article class="feature-card" data-reveal="fade-up" data-tilt>
            <span class="feature-icon">🔥</span>
            <h3>Productivity streaks</h3>
            <p>Small, visible streaks that reward showing up — not just finishing everything at once.</p>
          </article>
          <article class="feature-card" data-reveal="fade-up" data-tilt>
            <span class="feature-icon">📱</span>
            <h3>Responsive design</h3>
            <p>Your board, your laptop, the library computer, your phone between classes — same board, everywhere.</p>
          </article>
          <article class="feature-card" data-reveal="fade-up" data-tilt>
            <span class="feature-icon">🧩</span>
            <h3>Easy organization</h3>
            <p>Color tags, due dates, and class folders that stay tidy without any extra setup.</p>
          </article>
        </div>
      </div>
    </div>
  </section>

  <!-- ============ TESTIMONIALS ============ -->
  <section class="testimonials" id="testimonials">
    <div class="section-inner">
      <p class="eyebrow center">from people who actually use it</p>
      <h2 class="center">Small wins, said out loud.</h2>

      <div class="bubble-field">
        <div class="polaroid p-1" data-reveal="fade-up" data-parallax="0.03">
          <div class="polaroid-photo">🎓</div>
          <p class="polaroid-caption">"My group project finally lives in one place."</p>
          <span class="polaroid-name">— Maia, BS CpE</span>
        </div>

        <div class="speech-bubble b-1" data-reveal="fade-up" data-parallax="0.05">
          <p>"The streak thing is unfairly motivating."</p>
          <span class="bubble-name">Jhun · 3rd year</span>
        </div>

        <div class="polaroid p-2" data-reveal="fade-up" data-parallax="0.04">
          <div class="polaroid-photo">📚</div>
          <p class="polaroid-caption">"Joined my class board in ten seconds."</p>
          <span class="polaroid-name">— Dani, BSIT</span>
        </div>

        <div class="speech-bubble b-2" data-reveal="fade-up" data-parallax="0.02">
          <p>"It's the first planner app I didn't quit after a week."</p>
          <span class="bubble-name">Cy · 2nd year</span>
        </div>

        <div class="polaroid p-3" data-reveal="fade-up" data-parallax="0.03">
          <div class="polaroid-photo">⚡</div>
          <p class="polaroid-caption">"Drag, drop, done. That's the whole review."</p>
          <span class="polaroid-name">— Theo, BSCS</span>
        </div>
      </div>
    </div>
  </section>

  <!-- ============ FAQ ============ -->
  <section class="faq" id="faq">
    <span class="faq-particle fp-1" aria-hidden="true">✦</span>
    <span class="faq-particle fp-2" aria-hidden="true">✧</span>
    <span class="faq-particle fp-3" aria-hidden="true">✦</span>
    <div class="section-inner section-narrow">
      <p class="eyebrow center">good to know</p>
      <h2 class="center">Questions, answered atomically.</h2>

      <div class="accordion" id="accordion">
        <div class="accordion-item" data-reveal="fade-up">
          <button class="accordion-trigger">
            <span>Is Atomic-Bits free for students?</span>
            <span class="accordion-icon">+</span>
          </button>
          <div class="accordion-panel">
            <p>Yes. The core board, class joining, and collaboration tools are free for every student account.</p>
          </div>
        </div>
        <div class="accordion-item" data-reveal="fade-up">
          <button class="accordion-trigger">
            <span>How do I join my classmates' board?</span>
            <span class="accordion-icon">+</span>
          </button>
          <div class="accordion-panel">
            <p>Whoever creates the class shares a short join code. Enter it once and you're both looking at the same board.</p>
          </div>
        </div>
        <div class="accordion-item" data-reveal="fade-up">
          <button class="accordion-trigger">
            <span>Does it work on my phone?</span>
            <span class="accordion-icon">+</span>
          </button>
          <div class="accordion-panel">
            <p>Atomic-Bits is fully responsive, so your board looks and works the same on mobile, tablet, and desktop.</p>
          </div>
        </div>
        <div class="accordion-item" data-reveal="fade-up">
          <button class="accordion-trigger">
            <span>Who built this?</span>
            <span class="accordion-icon">+</span>
          </button>
          <div class="accordion-panel">
            <p>Atomic-Bits was built by Rain, a student at the University of Eastern Pangasinan, to make university productivity feel a little less heavy.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ============ FINAL CTA / GET STARTED ============ -->
  <section class="get-started" id="get-started">
    <div class="section-inner cta-inner">
      <p class="eyebrow center">ready when you are</p>
      <h2 class="center">Start with one tiny task.</h2>
      <p class="cta-sub center">No credit card, no setup call — just a board waiting for your first class.</p>

      <form class="cta-form" id="ctaForm" novalidate>
        <input type="email" id="ctaEmail" placeholder="you@university.edu" required aria-label="Email address">
        <button type="submit" class="btn btn-primary btn-lg btn-cta">Get Started</button>
      </form>
      <p class="cta-status" id="ctaStatus" role="status" aria-live="polite"></p>
    </div>
  </section>

</main>

<!-- ============ FOOTER ============ -->
<footer class="site-footer">
  <div class="footer-particles" aria-hidden="true">
    <span>✦</span><span>✧</span><span>✦</span><span>✧</span><span>✦</span>
  </div>

  <div class="footer-peek" aria-hidden="true">
    <div class="pixel-ghost" data-mood="peek" data-size="9" id="peekGhost"></div>
  </div>

  <div class="section-inner footer-inner">
    <div class="footer-brand">
      <span class="logo footer-logo">Atomic-Bits</span>
      <p>Tiny habits. Massive progress.</p>
    </div>

    <nav class="footer-links">
      <a href="#">GitHub</a>
      <a href="#">Documentation</a>
      <a href="#">Contact</a>
    </nav>
  </div>

  <p class="footer-copy">Built with coffee and curiosity by Rain.</p>
</footer>

<script src="script.js"></script>
</body>
</html>