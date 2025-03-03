"use strict";
var __awaiter = (this && this.__awaiter) || function (thisArg, _arguments, P, generator) {
    function adopt(value) { return value instanceof P ? value : new P(function (resolve) { resolve(value); }); }
    return new (P || (P = Promise))(function (resolve, reject) {
        function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
        function rejected(value) { try { step(generator["throw"](value)); } catch (e) { reject(e); } }
        function step(result) { result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected); }
        step((generator = generator.apply(thisArg, _arguments || [])).next());
    });
};
const loginForm = document.getElementById("loginForm");
const emailInput = document.getElementById("email");
const passwordInput = document.getElementById("password");
const errorMessage = document.getElementById("error-message");
if (loginForm) {
    loginForm.addEventListener("submit", (event) => __awaiter(void 0, void 0, void 0, function* () {
        event.preventDefault();
        const email = emailInput.value;
        const password = passwordInput.value;
        if (!email || !password) {
            errorMessage.textContent = "Email and Password are required!";
            return;
        }
        try {
            const response = yield fetch("http://3.107.199.165/auth/login_process", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}`
            });
            const result = yield response.json();
            if (result.status === "success") {
                window.location.href = result.redirect_url;
            }
            else {
                errorMessage.textContent = result.message;
            }
        }
        catch (error) {
            errorMessage.textContent = "Server error. Please try again.";
        }
    }));
}
document.addEventListener("DOMContentLoaded", () => {
    const jobForm = document.getElementById("jobForm");
    const titleInput = document.getElementById("title");
    const descriptionInput = document.getElementById("description");
    const messageDisplay = document.getElementById("message");
    if (jobForm) {
        jobForm.addEventListener("submit", (event) => __awaiter(void 0, void 0, void 0, function* () {
            event.preventDefault();
            const title = titleInput.value.trim();
            const description = descriptionInput.value.trim();
            if (!title || !description) {
                messageDisplay.textContent = "All fields are required!";
                messageDisplay.style.color = "red";
                return;
            }
            try {
                const response = yield fetch("http://3.107.199.165/jobs/post_job", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: new URLSearchParams({ title, description }).toString(),
                });
                const result = yield response.json();
                messageDisplay.textContent = result.message;
                messageDisplay.style.color = result.status === "success" ? "green" : "red";
                // Clear form on success
                if (result.status === "success") {
                    jobForm.reset();
                }
            }
            catch (error) {
                messageDisplay.textContent = "Server error. Please try again.";
                messageDisplay.style.color = "red";
            }
        }));
    }
});
