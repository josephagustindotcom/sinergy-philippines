  <footer class="footer">
    <div class="container">
      <div class="footer-grid">
        <div class="footer-brand">
          <a href="/" class="logo">
            <img src="img/sinergy-logo-white.png" alt="Sinergy logo" class="site-logo-img" />
          </a>

          <p>
            Philippines-based outsourcing teams built on collaboration, accountability,
            and performance-driven support for growing global businesses.
          </p>
        </div>

        <div>
          <h4>Services</h4>
          <div class="footer-links">
            <a href="customer-support">Customer Support</a>
            <a href="technical-support">Technical Support</a>
            <a href="sales-services">Sales Services</a>
            <a href="data-entry-verification">Data Entry &amp; Verification</a>
            <a href="data-annotation">Data Annotation</a>
          </div>
        </div>

        <div>
          <h4>Company</h4>
          <div class="footer-links">
            <a href="about">About</a>
            <a href="why-sinergy">Why Sinergy</a>
            <a href="how-it-works">How It Works</a>
            <a href="industries">Industries</a>
            <a href="careers">Careers</a>
          </div>
        </div>

        <div>
          <h4>Contact</h4>
          <div class="footer-links">
            <a href="mailto:admin@sinergyph.com">admin@sinergyph.com</a>
            <a href="contact">Request a Quote</a>
            <a href="#">LinkedIn</a>
            <a href="https://www.facebook.com/profile.php?id=61564763394102">Facebook</a>
          </div>
        </div>
      </div>

      <div class="footer-bottom">
        <p>&copy; <span id="year"></span> Sinergy. All rights reserved.</p>

        <div>
          <a href="privacy-policy">Privacy Policy</a>
          &nbsp;&bull;&nbsp;
          <a href="terms-of-service">Terms of Service</a>
        </div>
      </div>
    </div>
  </footer>

  <!-- AI Chat Widget -->
  <button class="chat-toggle" id="chatToggle" aria-label="Chat with Sinergy Assistant">
    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
    </svg>
    <span class="chat-badge" id="chatBadge" aria-hidden="true">1</span>
  </button>

  <div class="chat-widget" id="chatWidget" aria-hidden="true" role="dialog" aria-label="Sinergy Assistant">
    <div class="chat-header">
      <div class="chat-avatar">S</div>
      <div class="chat-header-info">
        <strong>Sinergy Assistant</strong>
        <span>Ask about services or book a call</span>
      </div>
      <button class="chat-close" id="chatClose" aria-label="Close chat">&times;</button>
    </div>

    <div class="chat-messages" id="chatMessages">
      <div class="chat-msg assistant">
        Hi! I'm Sinergy's assistant. I can answer questions about our outsourcing services or help you schedule a discovery call. What can I help you with?
      </div>
    </div>

    <div class="chat-input-area">
      <input type="text" id="chatInput" placeholder="Type a message…" autocomplete="off" />
      <button id="chatSend" aria-label="Send message">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <line x1="22" y1="2" x2="11" y2="13"></line>
          <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
        </svg>
      </button>
    </div>
  </div>

  <script src="script.js"></script>
</body>
</html>
