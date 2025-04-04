document.addEventListener("DOMContentLoaded", function() {
    const birthdateInput = document.getElementById("birthdate");
    const today = new Date();
    const minAgeDate = new Date();
    minAgeDate.setFullYear(today.getFullYear() - 16);
    birthdateInput.setAttribute("max", minAgeDate.toISOString().split("T")[0]);
});

document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector("form");
    form.addEventListener("submit", function(event) {
        // Validate form fields
        let isValid = true;
        const requiredFields = document.querySelectorAll("input[required], select[required]");
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
                field.style.border = "2px solid red";
            } else {
                field.style.border = "";
            }
        });
        
        if (!isValid) {
            alert("Please fill in all required fields.");
            event.preventDefault();
        }
    });

    // Reset red borders on input focus
    document.querySelectorAll("input, select").forEach(field => {
        field.addEventListener("focus", function() {
            this.style.border = "";
        });
    });
});



function checkDuplicate(type, value, messageElementId) {
    if (value.trim() === "") return;

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "check_duplicate.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    
    xhr.onload = function() {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            const messageElement = document.getElementById(messageElementId);

            if (response.status === "exists") {
                messageElement.textContent = `${type.charAt(0).toUpperCase() + type.slice(1)} already exists.`;
                messageElement.style.color = "red";
            } else {
                messageElement.textContent = `${type.charAt(0).toUpperCase() + type.slice(1)} is available.`;
                messageElement.style.color = "green";
            }
        }
    };

    xhr.send("type=" + type + "&value=" + encodeURIComponent(value));
}

// Attach event listeners after DOM is ready
document.addEventListener("DOMContentLoaded", function() {
    const emailInput = document.querySelector("input[name='email']");
    const contactInput = document.querySelector("input[name='contactNumber']");

    emailInput.addEventListener("blur", function() {
        checkDuplicate("email", this.value, "email-msg");
    });

    contactInput.addEventListener("blur", function() {
        checkDuplicate("contact", this.value, "contact-msg");
    });
});



function allowOnlyLetters(input) {
    input.value = input.value.replace(/[^A-Za-z\s]/g, '');
}

document.querySelector("input[name='fName']").addEventListener("input", function () {
    allowOnlyLetters(this);
});

document.querySelector("input[name='mName']").addEventListener("input", function () {
    allowOnlyLetters(this);
});

document.querySelector("input[name='lName']").addEventListener("input", function () {
    allowOnlyLetters(this);
});



document.querySelector("input[name='email']").addEventListener("input", function () {
    const pattern = /^[a-zA-Z0-9._%+-]+@gmail\.com$/;
    if (!pattern.test(this.value)) {
        this.setCustomValidity("Only Gmail addresses are allowed.");
    } else {
        this.setCustomValidity("");
    }
});

document.querySelector("input[name='contactNumber']").addEventListener("input", function () {
    const pattern = /^(09\d{9}|\+639\d{9})$/;
    if (!pattern.test(this.value)) {
        this.setCustomValidity("Please enter a valid Philippine number (09123456789 or +639123456789).");
    } else {
        this.setCustomValidity("");
    }
});