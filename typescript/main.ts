const loginForm = document.getElementById("loginForm") as HTMLFormElement;
const emailInput = document.getElementById("email") as HTMLInputElement;
const passwordInput = document.getElementById("password") as HTMLInputElement;
const errorMessage = document.getElementById("error-message") as HTMLElement;

if (loginForm) {
    loginForm.addEventListener("submit", async (event) => {
        event.preventDefault();

        const email = emailInput.value;
        const password = passwordInput.value;

        if (!email || !password) {
            errorMessage.textContent = "Email and Password are required!";
            return;
        }

        try {
            const response = await fetch("http://3.107.199.165/auth/login_process", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}`
            });

            const result = await response.json();
            if (result.status === "success") {
                window.location.href = result.redirect_url;
            } else {
                errorMessage.textContent = result.message;
            }
        } catch (error) {
            errorMessage.textContent = "Server error. Please try again.";
        }
    });
}

document.addEventListener("DOMContentLoaded", () => {
    const jobForm = document.getElementById("jobForm") as HTMLFormElement;
    const titleInput = document.getElementById("title") as HTMLInputElement;
    const descriptionInput = document.getElementById("description") as HTMLTextAreaElement;
    const messageDisplay = document.getElementById("message") as HTMLParagraphElement;

    if (jobForm) {
        jobForm.addEventListener("submit", async (event: Event) => {
            event.preventDefault();

            const title = titleInput.value.trim();
            const description = descriptionInput.value.trim();

            if (!title || !description) {
                messageDisplay.textContent = "All fields are required!";
                messageDisplay.style.color = "red";
                return;
            }

            try {
                const response = await fetch("http://3.107.199.165/jobs/post_job", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: new URLSearchParams({ title, description }).toString(),
                });

                const result = await response.json();
                messageDisplay.textContent = result.message;
                messageDisplay.style.color = result.status === "success" ? "green" : "red";

                // Clear form on success
                if (result.status === "success") {
                    jobForm.reset();
                }
            } catch (error) {
                messageDisplay.textContent = "Server error. Please try again.";
                messageDisplay.style.color = "red";
            }
        });
    }
});