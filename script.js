const DEBUG = true;

const RED = "#ff8a8a";
const GREEN = "#8aff8a";
const MESSAGES = {
  NAME_TOO_SHORT: "The name must be at least 2 characters long!",
  NAME_TOO_LONG: "The name cannot exceed 100 characters!",
  NAME_INVALID_CHARS: "The name contains invalid characters!",
  EMAIL_INVALID_FORMAT: "Invalid email format!",
  EMAIL_TOO_LONG: "The email is too long!",
  SUBMIT_ERROR: "An error occurred!",
};

function debugLog(...args) {
  if (DEBUG) console.log(...args);
}

function validateForm(name, email) {
  const nameRegex = /^[a-zA-ZÀ-ÿ\s\-']+$/;
  const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

  if (name.length < 2) return MESSAGES.NAME_TOO_SHORT;
  if (name.length > 100) return MESSAGES.NAME_TOO_LONG;
  if (!nameRegex.test(name)) return MESSAGES.NAME_INVALID_CHARS;
  if (!emailRegex.test(email)) return MESSAGES.EMAIL_INVALID_FORMAT;
  if (email.length > 255) return MESSAGES.EMAIL_TOO_LONG;

  return null;
}

function showMessage(text, isError = false) {
  const resultDiv = document.getElementById("result");

  resultDiv.textContent = text;
  resultDiv.style.color = isError ? RED : GREEN;
}

async function submitForm(name, email) {
  const data = new FormData();
  data.append("name", name);
  data.append("email", email);

  const response = await fetch("add_user.php", {
    method: "POST",
    body: data,
  });

  return response.json();
}

document
  .getElementById("userForm")
  .addEventListener("submit", async function handleSubmit(e) {
    e.preventDefault();

    const form = e.target;
    const name = form.name.value.trim();
    const email = form.email.value.trim();

    let error = validateForm(name, email);

    if (!error) {
      try {
        const result = await submitForm(name, email);
        if (result.success) {
          debugLog(result.message);

          showMessage(result.message);

          form.reset();
          return;
        } else {
          debugLog(result.message);

          error = MESSAGES.SUBMIT_ERROR;
        }
      } catch (err) {
        debugLog(err.message);

        error = MESSAGES.SUBMIT_ERROR;
      }
    }

    showMessage(error, true);
  });
