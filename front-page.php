<?php
/**
 * Front Page Template — Worknoon Landing Page
 *
 * Sections:
 *  1. Hero (with CTA)
 *  2. Services
 *  3. Testimonials
 *  4. Contact Form
 *
 * @package WorknoonTheme
 */

get_header();
?>

<!-- =====================================================
     SECTION 1: HERO
     ===================================================== -->
<section class="hero" id="hero" aria-label="Hero">
  <div class="container">
    <div class="hero__inner">

      <!-- Left: Copy -->
      <div class="hero__content">
        <span class="badge hero__badge">🚀 The Remote Work Platform</span>
        <h1 class="hero__title">
          Hire Top Remote<br>
          <span>Professionals</span><br>
          On Demand
        </h1>
        <p class="hero__subtitle">
          Worknoon connects businesses with vetted, skilled freelancers and remote
          professionals — fast, reliable, and built for scale.
        </p>
        <div class="hero__actions">
          <a href="#contact" class="btn btn--primary">Get Started Free</a>
          <a href="#services" class="btn btn--outline">See How It Works</a>
        </div>
        <div class="hero__stats">
          <div class="hero__stat">
            <span class="hero__stat-number">5,000+</span>
            <span class="hero__stat-label">Vetted Professionals</span>
          </div>
          <div class="hero__stat">
            <span class="hero__stat-number">98%</span>
            <span class="hero__stat-label">Client Satisfaction</span>
          </div>
          <div class="hero__stat">
            <span class="hero__stat-number">24hr</span>
            <span class="hero__stat-label">Average Match Time</span>
          </div>
        </div>
      </div>

      <!-- Right: Visual Card -->
      <div class="hero__visual" aria-hidden="true">
        <div class="hero__card">
          <p class="hero__card-title">✅ Recently Matched Talent</p>
          <div class="hero__avatar-row">
            <div class="hero__avatar">AO</div>
            <div>
              <div class="hero__avatar-name">Amaka Obi</div>
              <div class="hero__avatar-role">WordPress Developer</div>
            </div>
            <span class="hero__avatar-status">Available</span>
          </div>
          <div class="hero__avatar-row">
            <div class="hero__avatar hero__avatar--green">KA</div>
            <div>
              <div class="hero__avatar-name">Kofi Asante</div>
              <div class="hero__avatar-role">SEO Specialist</div>
            </div>
            <span class="hero__avatar-status">Available</span>
          </div>
          <div class="hero__avatar-row">
            <div class="hero__avatar hero__avatar--purple">FN</div>
            <div>
              <div class="hero__avatar-name">Fatima Nwosu</div>
              <div class="hero__avatar-role">UI/UX Designer</div>
            </div>
            <span class="hero__avatar-status">Available</span>
          </div>
        </div>
      </div>

    </div><!-- /.hero__inner -->
  </div><!-- /.container -->
</section>


<!-- =====================================================
     SECTION 2: SERVICES
     ===================================================== -->
<section class="section section--alt" id="services" aria-label="Our Services">
  <div class="container text-center">

    <span class="badge">What We Offer</span>
    <h2>Everything You Need to<br>Build a Remote Team</h2>
    <p style="color:var(--color-gray);max-width:560px;margin:1rem auto 0">
      From individual freelancers to full remote teams — Worknoon has you covered
      across every discipline.
    </p>

    <div class="services__grid">

      <article class="service-card">
        <div class="service-icon">💻</div>
        <h3>WordPress Development</h3>
        <p>Custom themes, plugins, WooCommerce stores, and performance optimization
           from vetted WordPress developers.</p>
      </article>

      <article class="service-card">
        <div class="service-icon">📈</div>
        <h3>SEO & Digital Marketing</h3>
        <p>Technical SEO audits, content strategy, schema markup, and link building
           campaigns that drive measurable results.</p>
      </article>

      <article class="service-card">
        <div class="service-icon">🎨</div>
        <h3>UI/UX Design</h3>
        <p>User research, wireframing, Figma prototypes, and design systems — built
           for conversion and accessibility.</p>
      </article>

      <article class="service-card">
        <div class="service-icon">⚙️</div>
        <h3>Backend Development</h3>
        <p>API integrations, database architecture, automation workflows, and
           scalable backend systems in Node.js, PHP, or Python.</p>
      </article>

      <article class="service-card">
        <div class="service-icon">📊</div>
        <h3>Data & Analytics</h3>
        <p>GA4 setup, dashboard reporting, data pipelines, and actionable insights
           to guide smarter business decisions.</p>
      </article>

      <article class="service-card">
        <div class="service-icon">✍️</div>
        <h3>Content Creation</h3>
        <p>Long-form blog posts, technical documentation, video scripts, and brand
           copy written by specialists in your niche.</p>
      </article>

    </div><!-- /.services__grid -->

  </div>
</section>


<!-- =====================================================
     SECTION 3: TESTIMONIALS
     ===================================================== -->
<section class="section" id="testimonials" aria-label="Client Testimonials">
  <div class="container text-center">

    <span class="badge">What Clients Say</span>
    <h2>Trusted by Businesses<br>Across Africa & Beyond</h2>

    <div class="testimonials__grid">

      <article class="testimonial-card" itemscope itemtype="https://schema.org/Review">
        <div class="testimonial-stars" aria-label="5 stars">★★★★★</div>
        <p class="testimonial-text" itemprop="reviewBody">
          "Worknoon matched us with an exceptional WordPress developer within 24 hours.
          The quality of work was outstanding — I couldn't believe how seamless the
          entire process was."
        </p>
        <div class="testimonial-author">
          <div class="testimonial-avatar">CU</div>
          <div>
            <div class="testimonial-name" itemprop="author">Chidi Uzoma</div>
            <div class="testimonial-role">CEO, BrandLift Nigeria</div>
          </div>
        </div>
      </article>

      <article class="testimonial-card" itemscope itemtype="https://schema.org/Review">
        <div class="testimonial-stars" aria-label="5 stars">★★★★★</div>
        <p class="testimonial-text" itemprop="reviewBody">
          "We hired an SEO specialist through Worknoon and saw a 340% increase in
          organic traffic within 3 months. The platform's vetting process is top-notch."
        </p>
        <div class="testimonial-author">
          <div class="testimonial-avatar testimonial-avatar--amber">SM</div>
          <div>
            <div class="testimonial-name" itemprop="author">Sarah Mensah</div>
            <div class="testimonial-role">Marketing Director, AfriTech Hub</div>
          </div>
        </div>
      </article>

      <article class="testimonial-card" itemscope itemtype="https://schema.org/Review">
        <div class="testimonial-stars" aria-label="5 stars">★★★★★</div>
        <p class="testimonial-text" itemprop="reviewBody">
          "As a startup, we needed reliable remote talent fast. Worknoon delivered
          a full-stack developer who integrated perfectly with our team from day one."
        </p>
        <div class="testimonial-author">
          <div class="testimonial-avatar testimonial-avatar--teal">AB</div>
          <div>
            <div class="testimonial-name" itemprop="author">Ade Bankole</div>
            <div class="testimonial-role">CTO, PaySwift Africa</div>
          </div>
        </div>
      </article>

    </div><!-- /.testimonials__grid -->

  </div>
</section>


<!-- =====================================================
     SECTION 4: CONTACT FORM
     ===================================================== -->
<section class="section section--alt" id="contact" aria-label="Contact Us">
  <div class="container">
    <div class="contact__inner">

      <!-- Left: Info -->
      <div class="contact__info">
        <span class="badge">Get In Touch</span>
        <h2>Ready to Hire Top<br>Remote Talent?</h2>
        <p>
          Tell us about your project and we'll match you with the right professionals
          within 24 hours. No obligation, no hidden fees.
        </p>

        <div class="contact__detail">
          <div class="contact__detail-icon">📧</div>
          <div>
            <div class="contact__detail-label">Email Us</div>
            <div class="contact__detail-value">careers@worknoon.com</div>
          </div>
        </div>

        <div class="contact__detail">
          <div class="contact__detail-icon">🌍</div>
          <div>
            <div class="contact__detail-label">Operating</div>
            <div class="contact__detail-value">Remote-First · Africa & Global</div>
          </div>
        </div>

        <div class="contact__detail">
          <div class="contact__detail-icon">⏱️</div>
          <div>
            <div class="contact__detail-label">Response Time</div>
            <div class="contact__detail-value">Within 24 business hours</div>
          </div>
        </div>
      </div>

      <!-- Right: Form -->
      <div class="contact__form" role="form" aria-label="Contact form">
        <div id="worknoon-form-status" role="alert" aria-live="polite" style="display:none;"></div>

        <div class="form__row">
          <div class="form__group">
            <label class="form__label" for="wn-name">Full Name *</label>
            <input class="form__input" type="text" id="wn-name" name="name"
                   placeholder="Chidi Uzoma" required autocomplete="name">
          </div>
          <div class="form__group">
            <label class="form__label" for="wn-email">Email Address *</label>
            <input class="form__input" type="email" id="wn-email" name="email"
                   placeholder="chidi@company.com" required autocomplete="email">
          </div>
        </div>

        <div class="form__group">
          <label class="form__label" for="wn-subject">What do you need?</label>
          <select class="form__select" id="wn-subject" name="subject">
            <option value="">Select a service...</option>
            <option>WordPress Development</option>
            <option>SEO &amp; Digital Marketing</option>
            <option>UI/UX Design</option>
            <option>Backend Development</option>
            <option>Data &amp; Analytics</option>
            <option>Content Creation</option>
            <option>Other</option>
          </select>
        </div>

        <div class="form__group">
          <label class="form__label" for="wn-message">Tell Us About Your Project *</label>
          <textarea class="form__textarea" id="wn-message" name="message"
                    placeholder="Briefly describe your project, timeline, and budget..." required></textarea>
        </div>

        <button type="button" id="worknoon-submit" class="btn btn--primary form__submit">
          Send Message →
        </button>
      </div><!-- /.contact__form -->

    </div>
  </div>
</section>

<?php get_footer(); ?>
