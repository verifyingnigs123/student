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
