document.querySelectorAll('.profile-links a').forEach(link => {
    link.addEventListener('click', function(event) {
        event.preventDefault(); // Prevent default link behavior

        // Get the target section
        const target = this.getAttribute('data-target');

        // Hide all sections
        document.querySelectorAll('.profile-section').forEach(section => {
            section.style.display = 'none'; // Hide every section
        });

        // Show the selected section
        document.getElementById(target).style.display = 'block';
    });
});
console.log("JavaScript file is loaded!");

// Sample user data (replace with actual user data)
const userData = {
    'personal-info': {
        name: 'Layla ',
        email: 'layla@gmail.com',
        phone: '+201128300501',
        birthdate: '1990-05-15',
        location: 'Cairo, NY'
    },
    'academic-background': {
        degree: 'Bachelor of Science',
        major: 'Computer Science',
        university: 'Tech University',
        graduationYear: '2012'

    },
    'resume': {
        
        
    }
};

function initForms() {
    document.querySelectorAll('.profile-section').forEach(section => {
        const sectionId = section.id;
        const editButton = section.querySelector('.edit-button');
        const infoContent = section.querySelector('.info-content:not(.edit-mode)');
        const editContent = section.querySelector('.info-content.edit-mode');
        const saveButton = editContent.querySelector('button');

        displayUserData(sectionId, infoContent);
        
        editButton.addEventListener('click', () => toggleEditMode(infoContent, editContent));
        saveButton.addEventListener('click', () => saveUserData(sectionId, infoContent, editContent));
        
        editContent.style.display = 'none';
    });
}

function displayUserData(sectionId, infoContent) {
    const gridContainer = infoContent.querySelector('.grid-container');
    let html = '';
    for (const [key, value] of Object.entries(userData[sectionId])) {
        html += `
            <div class="coolinput">
                <label for="${key}" class="text">${key.charAt(0).toUpperCase() + key.slice(1)}:</label>
                <p>${value}</p>
            </div>
        `;
    }
    gridContainer.innerHTML = html;
}

function populateEditForm(sectionId, editContent) {
    const inputs = editContent.querySelectorAll('input');
    inputs.forEach(input => {
        input.value = userData[sectionId][input.name] || '';
    });
}

function toggleEditMode(infoContent, editContent) {
    if (editContent.style.display === 'none') {
        infoContent.style.display = 'none';
        editContent.style.display = 'block';
        populateEditForm(infoContent.closest('.profile-section').id, editContent);
    } else {
        infoContent.style.display = 'block';
        editContent.style.display = 'none';
    }
}

function saveUserData(sectionId, infoContent, editContent) {
    const inputs = editContent.querySelectorAll('input');
    let valid = true; // Initialize a variable to track validation status

    // Clear previous error styles
    inputs.forEach(input => {
        input.parentElement.classList.remove('error');
    });

    // Iterate through each input field to validate
    inputs.forEach(input => {
        const value = input.value.trim();
        const name = input.name;

        // Check for empty values
        if (!value) {
            valid = false;
            input.parentElement.classList.add('error');
        }

        // Email validation
        if (name === 'email') {
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(value)) {
                valid = false;
                input.parentElement.classList.add('error');
            }
        }

        // Phone validation
        if (name === 'phone') {
            const phonePattern = /^\+201[0-9]{9}$/; // Must start with +20 and followed by 10 digits
            if (!phonePattern.test(value)) {
                valid = false;
                input.parentElement.classList.add('error');
            }
        }

        // Birthdate validation
        if (name === 'birthdate') {
            const birthdatePattern = /^\d{4}-\d{2}-\d{2}$/;

            if (!birthdatePattern.test(value)) {
                valid = false; 
                input.parentElement.classList.add('error'); // Highlight if the format is incorrect
            } else {
                const date = new Date(value);
                const today = new Date();

                // Ensure the date is valid and not in the future
                if (isNaN(date.getTime()) || date > today) {
                    valid = false; // Highlight if the date is invalid or in the future
                    input.parentElement.classList.add('error'); 
                }
            }
        }
    });

    // If valid, save the data and toggle to info mode
    if (valid) {
        inputs.forEach(input => {
            userData[sectionId][input.name] = input.value;
        });
        displayUserData(sectionId, infoContent);
        toggleEditMode(infoContent, editContent);
    } else {
        showValidationAlert(); // Call function to show alert
    }
}

let alertShown = false; // Track if alert has been shown

function showValidationAlert() {
    if (!alertShown) {
        alert("Validation failed. Please check your inputs.");
        alertShown = true; // Set flag to true to avoid repeating
    }
}

document.addEventListener('DOMContentLoaded', initForms);

// Form validation on submit
document.addEventListener("DOMContentLoaded", function () {
    function validateForm(event) {
        event.preventDefault(); // Prevent form submission
        let alertShown = false; // Initialize alertShown for this call
    
        const form = event.target; // Use the target of the event to get the form
        if (!form) {
            console.error('Form not found');
            return; // Exit if form not found
        }
    
        const inputs = form.querySelectorAll('.coolinput input');
        let valid = true;
    
        // Clear previous error styles
        inputs.forEach(input => {
            input.parentElement.classList.remove('error');
        });
    
        // Iterate through each input field
        inputs.forEach(input => {
            const value = input.value.trim();
            const name = input.name;
    
            // Check for empty values
            if (!value) {
                valid = false;
                input.parentElement.classList.add('error');
            }
    
            // Email validation
            if (name === 'email') {
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(value)) {
                    valid = false;
                    input.parentElement.classList.add('error');
                }
            }
    
            // Phone validation
            if (name === 'phone') {
                const phonePattern = /^\+201[0-9]{9}$/; // Must start with +20 and followed by 10 digits
                if (!phonePattern.test(value)) {
                    valid = false;
                    input.parentElement.classList.add('error');
                }
            }
    
            // Birthdate validation
            if (name === 'birthdate') {
                const birthdatePattern = /^\d{4}-\d{2}-\d{2}$/;

                if (!birthdatePattern.test(value)) {
                    valid = false; 
                    input.parentElement.classList.add('error'); // Highlight if the format is incorrect
                } else {
                    const date = new Date(value);
                    const today = new Date();

                    // Ensure the date is valid and not in the future
                    if (isNaN(date.getTime()) || date > today) {
                        valid = false; // Highlight if the date is invalid or in the future
                        input.parentElement.classList.add('error'); 
                    }
                }
            }
        });
    
        // If all fields are valid, submit the form
        if (valid) {
            console.log("Form submitted!");
            // Uncomment the line below to enable actual form submission
            // form.submit();
    
            // Toggle to non-edit mode only if valid
            const infoContent = form.closest('.info-content:not(.edit-mode)');
            const editContent = form.closest('.info-content.edit-mode');
            toggleEditMode(infoContent, editContent); // Call this only if valid
        } else {
            console.log("Validation failed. Please check your inputs.");
            showValidationAlert(); // Call function to show alert
        }
    }

    // Attach the validation function to the form's submit event
    const personalForm = document.getElementById('personalDetailsForm');
    const academicForm = document.getElementById('AcademicDetailsForm');
    const ResumeForm = document.getElementById('ResumeForm');

    if (personalForm) {
        personalForm.addEventListener('submit', validateForm);
    } else {
        console.error('Personal Details Form not found');
    }

    if (academicForm) {
        academicForm.addEventListener('submit', validateForm);
    } else {
        console.error('Academic Details Form not found');
    }
    if (ResumeForm) {
        ResumeForm.addEventListener('submit', validateForm);
    } else {
        console.error('Resume Form not found');
    }
});
