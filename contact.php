<?php $page_title = 'Contact Sinergy'; include 'header.php'; ?>

  <main>
    <!-- Hero -->
    <section class="page-hero">
      <div class="container hero-grid">
        <div>
          <div class="eyebrow">Contact Sinergy</div>

          <h1>
            Let's Build the Right <span>Outsourcing Support Team</span> for Your Business
          </h1>

          <p class="hero-copy">
            Tell us what work you need handled, what tools you use, and what outcome you want.
            Sinergy will help identify the right support structure for customer support, technical support,
            sales, data entry, verification, or data annotation.
          </p>

          <div class="hero-actions">
            <a href="#contact-form" class="btn btn-primary">Request a Quote</a>
            <a href="services.php" class="btn btn-secondary">Explore Services</a>
          </div>

          <div class="trust-row">
            <span class="trust-pill"><span class="check">✓</span> Philippines-Based Teams</span>
            <span class="trust-pill"><span class="check">✓</span> Scalable Support</span>
            <span class="trust-pill"><span class="check">✓</span> Workflow-First Setup</span>
          </div>
        </div>

        <div class="hero-panel">
          <h3>Contact Details</h3>
          <p>
            Use the form or contact Sinergy directly.
          </p>

          <div class="contact-cards">
            <div class="contact-card">
              <div class="contact-icon">✉️</div>
              <div>
                <strong>General Inquiries</strong>
                <a href="mailto:hello@sinergy.com">hello@sinergy.com</a>
              </div>
            </div>

            <div class="contact-card">
              <div class="contact-icon">💼</div>
              <div>
                <strong>Careers</strong>
                <a href="mailto:careers@sinergy.com">careers@sinergy.com</a>
              </div>
            </div>

            <div class="contact-card">
              <div class="contact-icon">🌍</div>
              <div>
                <strong>Service Area</strong>
                <span>Philippines-based outsourcing support for global businesses.</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Contact Form -->
    <section class="section" id="contact-form">
      <div class="container contact-layout">
        <aside class="contact-info-panel">
          <div class="eyebrow">Before You Reach Out</div>
          <h2>Be specific. Vague requests lead to weak outsourcing plans.</h2>
          <p>
            The more clearly you describe your workload, the easier it is to recommend the right role,
            team size, training plan, and launch process.
          </p>

          <div class="info-list">
            <div class="info-item">
              <strong>Describe the work</strong>
              <span>Example: customer emails, appointment setting, data cleanup, helpdesk tickets, annotation tasks.</span>
            </div>

            <div class="info-item">
              <strong>Share your current tools</strong>
              <span>Example: Zendesk, HubSpot, Shopify, Google Workspace, Slack, CRM, ticketing platform, annotation tool.</span>
            </div>

            <div class="info-item">
              <strong>Estimate the workload</strong>
              <span>Example: number of tickets, calls, leads, records, projects, or hours needed per week.</span>
            </div>
          </div>
        </aside>

        <div class="form-card">
          <h2>Request an outsourcing quote.</h2>
          <p>Fill in your details and we will get back to you with the right support plan.</p>

          <form id="quoteForm">
            <div class="form-grid">
              <div class="form-group">
                <label for="firstName">First Name *</label>
                <input type="text" id="firstName" name="firstName" placeholder="Your first name" required />
              </div>

              <div class="form-group">
                <label for="lastName">Last Name *</label>
                <input type="text" id="lastName" name="lastName" placeholder="Your last name" required />
              </div>

              <div class="form-group">
                <label for="email">Work Email *</label>
                <input type="email" id="email" name="email" placeholder="name@company.com" required />
              </div>

              <div class="form-group">
                <label for="phone">Phone / WhatsApp</label>
                <input type="tel" id="phone" name="phone" placeholder="+1 000 000 0000" />
              </div>

              <div class="form-group">
                <label for="company">Company Name *</label>
                <input type="text" id="company" name="company" placeholder="Company name" required />
              </div>

              <div class="form-group">
                <label for="website">Company Website</label>
                <input type="url" id="website" name="website" placeholder="https://yourcompany.com" />
              </div>

              <div class="form-group">
                <label for="service">Service Needed *</label>
                <select id="service" name="service" required>
                  <option value="">Select a service</option>
                  <option value="Customer Support">Customer Support</option>
                  <option value="Technical Support">Technical Support</option>
                  <option value="Sales Services">Sales Services</option>
                  <option value="Data Entry & Verification">Data Entry &amp; Verification</option>
                  <option value="Data Annotation">Data Annotation</option>
                  <option value="Multiple Services">Multiple Services</option>
                  <option value="Not Sure Yet">Not Sure Yet</option>
                </select>
              </div>

              <div class="form-group">
                <label for="teamSize">Estimated Team Size</label>
                <select id="teamSize" name="teamSize">
                  <option value="">Select team size</option>
                  <option value="1 team member">1 team member</option>
                  <option value="2–5 team members">2–5 team members</option>
                  <option value="6–10 team members">6–10 team members</option>
                  <option value="10+ team members">10+ team members</option>
                  <option value="Not sure yet">Not sure yet</option>
                </select>
              </div>

              <div class="form-group">
                <label for="timeline">Ideal Start Timeline</label>
                <select id="timeline" name="timeline">
                  <option value="">Select timeline</option>
                  <option value="As soon as possible">As soon as possible</option>
                  <option value="Within 30 days">Within 30 days</option>
                  <option value="1–3 months">1–3 months</option>
                  <option value="Still exploring">Still exploring</option>
                </select>
              </div>

              <div class="form-group">
                <label for="budget">Estimated Monthly Budget</label>
                <select id="budget" name="budget">
                  <option value="">Select budget range</option>
                  <option value="Under $1,000/month">Under $1,000/month</option>
                  <option value="$1,000–$3,000/month">$1,000–$3,000/month</option>
                  <option value="$3,000–$7,500/month">$3,000–$7,500/month</option>
                  <option value="$7,500+/month">$7,500+/month</option>
                  <option value="Need recommendation">Need recommendation</option>
                </select>
              </div>

              <div class="form-group full">
                <label for="message">What do you need help with? *</label>
                <textarea
                  id="message"
                  name="message"
                  placeholder="Tell us about your workload, current process, tools, customer volume, support gaps, or data project requirements."
                  required
                ></textarea>
              </div>
            </div>

            <button type="submit" class="btn btn-primary">Send Inquiry</button>

            <div class="form-success" id="formSuccess">
              Inquiry sent. Check your email for a confirmation from admin@sinergyph.com. We will get back to you within 1&ndash;2 business days.
            </div>

            <div class="form-error" id="formError">
              Please complete the required fields before sending your inquiry.
            </div>
          </form>
        </div>
      </div>
    </section>

    <!-- What Happens Next -->
    <section class="section section-light">
      <div class="container">
        <div class="section-header center">
          <div class="eyebrow">What Happens Next</div>
          <h2>From inquiry to outsourcing plan.</h2>
          <p>
            A strong outsourcing setup should not start with random hiring. It should start with understanding
            your workload and building the right process.
          </p>
        </div>

        <div class="steps-grid">
          <article class="step-card">
            <div class="step-number">1</div>
            <h3>Review Your Inquiry</h3>
            <p>Sinergy reviews your service need, workload, tools, team size, timeline, and project requirements.</p>
          </article>

          <article class="step-card">
            <div class="step-number">2</div>
            <h3>Clarify the Workflow</h3>
            <p>We identify the tasks, responsibilities, escalation paths, reporting needs, and quality expectations.</p>
          </article>

          <article class="step-card">
            <div class="step-number">3</div>
            <h3>Recommend a Setup</h3>
            <p>You receive a practical recommendation for the role type, team structure, and launch approach.</p>
          </article>

          <article class="step-card">
            <div class="step-number">4</div>
            <h3>Prepare for Launch</h3>
            <p>Once aligned, the next step is training, tools access, documentation, onboarding, and team launch.</p>
          </article>
        </div>
      </div>
    </section>

    <!-- Service Fit -->
    <section class="section">
      <div class="container">
        <div class="section-header center">
          <div class="eyebrow">Not Sure What You Need?</div>
          <h2>Start by identifying the work type.</h2>
          <p>
            The right service depends on the problem you are trying to remove from your team.
          </p>
        </div>

        <div class="fit-grid">
          <article class="fit-card">
            <div class="fit-icon">🎧</div>
            <h3>Too many customer messages?</h3>
            <p>Start with customer support for email, chat, phone, order updates, complaints, and follow-ups.</p>
          </article>

          <article class="fit-card">
            <div class="fit-icon">🛠️</div>
            <h3>Too many product or user issues?</h3>
            <p>Start with technical support for troubleshooting, helpdesk tickets, issue triage, and escalation.</p>
          </article>

          <article class="fit-card">
            <div class="fit-icon">📞</div>
            <h3>Need more sales activity?</h3>
            <p>Start with sales services for lead generation, outbound calling, appointment setting, and CRM updates.</p>
          </article>

          <article class="fit-card">
            <div class="fit-icon">⌨️</div>
            <h3>Drowning in repetitive data work?</h3>
            <p>Start with data entry and verification for records, spreadsheets, CRM cleanup, and quality checks.</p>
          </article>

          <article class="fit-card">
            <div class="fit-icon">🏷️</div>
            <h3>Need labeled datasets?</h3>
            <p>Start with data annotation for image, text, audio, classification, tagging, and dataset review.</p>
          </article>

          <article class="fit-card">
            <div class="fit-icon">🧭</div>
            <h3>Need multiple functions?</h3>
            <p>Start with a workflow review so the team structure does not become messy or expensive.</p>
          </article>
        </div>
      </div>
    </section>

    <!-- FAQ -->
    <section class="section section-light">
      <div class="container">
        <div class="section-header center">
          <div class="eyebrow">Contact FAQs</div>
          <h2>Common questions before starting.</h2>
        </div>

        <div class="faq-list">
          <article class="faq-item">
            <h3>Can Sinergy support businesses outside the Philippines?</h3>
            <p>
              Yes. Sinergy is positioned to provide Philippines-based outsourcing support for businesses outside the Philippines.
            </p>
          </article>

          <article class="faq-item">
            <h3>Can I start with just one team member?</h3>
            <p>
              Yes. Many outsourcing setups should start small, prove the workflow, then scale once the process is working.
            </p>
          </article>

          <article class="faq-item">
            <h3>What should I prepare before the first call?</h3>
            <p>
              Prepare your workload estimate, tools, task examples, customer volume, current pain points, and the outcome you want.
            </p>
          </article>

          <article class="faq-item">
            <h3>Can Sinergy help if I am not sure which service I need?</h3>
            <p>
              Yes. The best starting point is a workflow review. The service should match the actual work, not a generic label.
            </p>
          </article>
        </div>
      </div>
    </section>

    <!-- Final CTA -->
    <section class="section">
      <div class="container">
        <div class="cta">
          <div>
            <h2>Ready to discuss your outsourcing setup?</h2>
            <p>
              Send your inquiry with as much detail as possible. The clearer the workload, the stronger the recommendation.
            </p>
          </div>

          <a href="#contact-form" class="btn btn-primary">Request a Quote</a>
        </div>
      </div>
    </section>
  </main>

<?php include 'footer.php'; ?>
