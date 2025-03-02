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
document.addEventListener("DOMContentLoaded", () => {
    const jobForm = document.getElementById("jobForm");
    const emailInput = document.getElementById("email");
    const titleInput = document.getElementById("title");
    const descriptionInput = document.getElementById("description");
    const messageDisplay = document.getElementById("message");
    if (jobForm) {
        jobForm.addEventListener("submit", (event) => __awaiter(void 0, void 0, void 0, function* () {
            event.preventDefault();
            const email = emailInput.value.trim();
            const title = titleInput.value.trim();
            const description = descriptionInput.value.trim();
            if (!email || !title || !description) {
                messageDisplay.textContent = "All fields are required!";
                messageDisplay.style.color = "red";
                return;
            }
            try {
                const response = yield fetch("http://localhost/newapp/index.php/jobs/post_job", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: new URLSearchParams({ email, title, description }).toString(),
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
