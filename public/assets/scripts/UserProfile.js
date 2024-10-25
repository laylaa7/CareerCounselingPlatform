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
        name: 'Layla Johnson',
        email: 'layla.johnson@example.com',
        phone: '(555) 123-4567',
        birthdate: '1990-05-15',
        location: 'New York, NY'
    },
    'academic-background': {
        degree: 'Bachelor of Science',
        major: 'Computer Science',
        university: 'Tech University',
        graduationYear: '2012'
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
    inputs.forEach(input => {
        userData[sectionId][input.name] = input.value;
    });
    displayUserData(sectionId, infoContent);
    toggleEditMode(infoContent, editContent);
}

document.addEventListener('DOMContentLoaded', initForms);
