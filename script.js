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

const updatedDateEl = document.getElementById("updatedDate");
if (updatedDateEl) {
  updatedDateEl.textContent = new Date().toLocaleDateString("en-US", {
    year: "numeric",
    month: "long",
    day: "numeric"
  });
}
