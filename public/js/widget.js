const API_URL = window.TICKET_WIDGET.apiUrl;

const form = document.getElementById("ticketWidgetForm");
const button = document.getElementById("btnSend");
const btnText = document.getElementById("btnText");
const btnSpinner = document.getElementById("btnSpinner");
const alertSuccess = document.getElementById("alertSuccess");
const alertError = document.getElementById("alertError");
const alertValidation = document.getElementById("alertValidation");
const validationList = document.getElementById("validationList");

button.addEventListener("click", async function (e) {
    e.preventDefault();

    document
        .querySelectorAll("[data-error-for]")
        .forEach((el) => el.classList.add("hidden"));
    alertSuccess.classList.add("hidden");
    alertError.classList.add("hidden");
    alertValidation.classList.add("hidden");
    validationList.innerHTML = "";

    button.disabled = true;
    btnText.classList.add("hidden");
    btnSpinner.classList.remove("hidden");

    try {
        const formData = new FormData(form);
        const response = await fetch(API_URL, {
            method: "POST",
            body: formData,
            headers: {
                Accept: "application/json",
            },
        });

        const contentType = response.headers.get("content-type") || "";
        let data = null;

        if (contentType.includes("application/json")) {
            data = await response.json();
        } else {
            const text = await response.text();
            throw new Error(
                `Expected JSON, got: ${contentType}. Body: ${text.slice(0, 200)}`,
            );
        }

        if (response.ok) {
            alertSuccess.classList.remove("hidden");
            form.reset();
        } else if (response.status === 422) {
            alertValidation.classList.remove("hidden");

            Object.entries(data.errors).forEach(([field, messages]) => {
                const errorEl = document.querySelector(
                    `[data-error-for="${field}"]`,
                );
                if (errorEl) {
                    errorEl.textContent = messages[0];
                    errorEl.classList.remove("hidden");
                }

                messages.forEach((message) => {
                    const li = document.createElement("li");
                    li.textContent = message;
                    validationList.appendChild(li);
                });
            });
        } else {
            alertError.classList.remove("hidden");
        }
    } catch (error) {
        alertError.classList.remove("hidden");
    } finally {
        button.disabled = false;
        btnText.classList.remove("hidden");
        btnSpinner.classList.add("hidden");
    }
});
