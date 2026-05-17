const mobileToggle = document.getElementById("mobileToggle");
const mainNav = document.getElementById("mainNav");

mobileToggle.addEventListener("click", function () {
  const isOpen = mainNav.classList.toggle("is-open");
  mobileToggle.setAttribute("aria-expanded", isOpen ? "true" : "false");
});

const navLinks = mainNav.querySelectorAll("a");

navLinks.forEach(function (link) {
  link.addEventListener("click", function () {
    mainNav.classList.remove("is-open");
    mobileToggle.setAttribute("aria-expanded", "false");
  });
});

document.getElementById("year").textContent = new Date().getFullYear();

const quoteForm = document.getElementById("quoteForm");
if (quoteForm) {
  const formSuccess = document.getElementById("formSuccess");
  const formError = document.getElementById("formError");
  const submitBtn = quoteForm.querySelector('button[type="submit"]');

  quoteForm.addEventListener("submit", function (event) {
    event.preventDefault();
    formSuccess.style.display = "none";
    formError.style.display = "none";

    if (!quoteForm.checkValidity()) {
      formError.textContent = "Please complete all required fields before submitting.";
      formError.style.display = "block";
      quoteForm.reportValidity();
      return;
    }

    submitBtn.disabled = true;
    submitBtn.textContent = "Sending…";

    fetch("contact-handler.php", {
      method: "POST",
      body: new FormData(quoteForm),
    })
      .then(function (res) { return res.json(); })
      .then(function (data) {
        if (data.success) {
          formSuccess.style.display = "block";
          quoteForm.reset();
        } else {
          formError.textContent = data.message || "Something went wrong. Please try again.";
          formError.style.display = "block";
        }
      })
      .catch(function () {
        formError.textContent = "Something went wrong. Email us directly at admin@sinergyph.com";
        formError.style.display = "block";
      })
      .finally(function () {
        submitBtn.disabled = false;
        submitBtn.textContent = "Send Inquiry";
      });
  });
}

// Application modal
const applyModal     = document.getElementById("applyModal");
const modalClose     = document.getElementById("modalClose");
const modalRoleLabel = document.getElementById("modalRoleLabel");
const applyRoleInput = document.getElementById("applyRole");
const applyForm      = document.getElementById("applyForm");

if (applyModal) {
  const applySuccess   = document.getElementById("applySuccess");
  const applyError     = document.getElementById("applyError");
  const applySubmitBtn = document.getElementById("applySubmitBtn");

  function openModal(role) {
    const label = role || "a role at Sinergy";
    modalRoleLabel.textContent = label;
    applyRoleInput.value = role;
    applyModal.setAttribute("aria-hidden", "false");
    applyModal.classList.add("is-open");
    document.body.classList.add("modal-active");
    applySuccess.style.display = "none";
    applyError.style.display = "none";
  }

  function closeModal() {
    applyModal.setAttribute("aria-hidden", "true");
    applyModal.classList.remove("is-open");
    document.body.classList.remove("modal-active");
    applyForm.reset();
  }

  document.querySelectorAll(".apply-btn").forEach(function (btn) {
    btn.addEventListener("click", function () {
      openModal(btn.getAttribute("data-role"));
    });
  });

  modalClose.addEventListener("click", closeModal);

  applyModal.addEventListener("click", function (e) {
    if (e.target === applyModal) closeModal();
  });

  document.addEventListener("keydown", function (e) {
    if (e.key === "Escape" && applyModal.classList.contains("is-open")) closeModal();
  });

  applyForm.addEventListener("submit", function (e) {
    e.preventDefault();
    applySuccess.style.display = "none";
    applyError.style.display = "none";

    if (!applyForm.checkValidity()) {
      applyError.textContent = "Please complete all required fields before submitting.";
      applyError.style.display = "block";
      applyForm.reportValidity();
      return;
    }

    applySubmitBtn.disabled = true;
    applySubmitBtn.textContent = "Sending…";

    fetch("application-handler.php", {
      method: "POST",
      body: new FormData(applyForm),
    })
      .then(function (res) { return res.json(); })
      .then(function (data) {
        if (data.success) {
          applySuccess.style.display = "block";
          applyForm.reset();
        } else {
          applyError.textContent = data.message || "Something went wrong. Please try again.";
          applyError.style.display = "block";
        }
      })
      .catch(function () {
        applyError.textContent = "Something went wrong. Email us at careers@sinergyph.com";
        applyError.style.display = "block";
      })
      .finally(function () {
        applySubmitBtn.disabled = false;
        applySubmitBtn.textContent = "Submit Application";
      });
  });
}

// AI Chat Widget
const chatToggle   = document.getElementById("chatToggle");
const chatWidget   = document.getElementById("chatWidget");
const chatClose    = document.getElementById("chatClose");
const chatMessages = document.getElementById("chatMessages");
const chatInput    = document.getElementById("chatInput");
const chatSend     = document.getElementById("chatSend");
const chatBadge    = document.getElementById("chatBadge");

if (chatToggle && chatWidget) {
  var chatHistory = [];
  var chatOpen    = false;

  function openChat() {
    chatOpen = true;
    chatWidget.classList.add("is-open");
    chatWidget.setAttribute("aria-hidden", "false");
    chatToggle.classList.add("is-open");
    chatBadge.style.display = "none";
    chatInput.focus();
  }

  function closeChat() {
    chatOpen = false;
    chatWidget.classList.remove("is-open");
    chatWidget.setAttribute("aria-hidden", "true");
    chatToggle.classList.remove("is-open");
  }

  chatToggle.addEventListener("click", function () {
    chatOpen ? closeChat() : openChat();
  });

  chatClose.addEventListener("click", closeChat);

  document.addEventListener("keydown", function (e) {
    if (e.key === "Escape" && chatOpen) closeChat();
  });

  function appendMessage(role, text) {
    var div = document.createElement("div");
    div.className = "chat-msg " + role;
    div.textContent = text;
    chatMessages.appendChild(div);
    chatMessages.scrollTop = chatMessages.scrollHeight;
    return div;
  }

  function showTyping() {
    var div = document.createElement("div");
    div.className = "chat-msg assistant chat-typing";
    div.innerHTML = "<span></span><span></span><span></span>";
    chatMessages.appendChild(div);
    chatMessages.scrollTop = chatMessages.scrollHeight;
    return div;
  }

  function sendMessage() {
    var text = chatInput.value.trim();
    if (!text) return;

    chatInput.value = "";
    chatSend.disabled = true;
    chatInput.disabled = true;

    appendMessage("user", text);
    chatHistory.push({ role: "user", content: text });

    var typing = showTyping();

    fetch("chat-handler.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ messages: chatHistory }),
    })
      .then(function (res) { return res.json(); })
      .then(function (data) {
        typing.remove();
        if (data.error) {
          appendMessage("assistant", data.error);
        } else {
          appendMessage("assistant", data.message);
          chatHistory.push({ role: "assistant", content: data.message });
          if (data.booking_submitted) {
            appendMessage("assistant", "A confirmation has been sent to your email. We will be in touch shortly to confirm your call.");
          }
        }
      })
      .catch(function () {
        typing.remove();
        appendMessage("assistant", "Something went wrong. Please email us at hello@sinergy.com");
      })
      .finally(function () {
        chatSend.disabled = false;
        chatInput.disabled = false;
        chatInput.focus();
      });
  }

  chatSend.addEventListener("click", sendMessage);

  chatInput.addEventListener("keydown", function (e) {
    if (e.key === "Enter" && !e.shiftKey) {
      e.preventDefault();
      sendMessage();
    }
  });
}

const updatedDateEl = document.getElementById("updatedDate");
if (updatedDateEl) {
  updatedDateEl.textContent = new Date().toLocaleDateString("en-US", {
    year: "numeric",
    month: "long",
    day: "numeric"
  });
}
