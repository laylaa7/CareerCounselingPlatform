// Array of section IDs
const sections = ['personal-info', 'education', 'work-history', 'skills', 'overview'];
let currentSectionIndex = 0;

// Button elements
const prevBtn = document.getElementById('prev-btn');
const nextBtn = document.getElementById('next-btn');

// Function to update section display and progress
function updateSection(index) {
    document.querySelector('.section.active').classList.remove('active');
    document.getElementById(sections[index]).classList.add('active');

    document.querySelector('.progress-item.active').classList.remove('active');
    document.querySelector(`[data-section="${sections[index]}"]`).classList.add('active');

    prevBtn.disabled = index === 0;
    nextBtn.textContent = index === sections.length - 1 ? 'Submit' : 'Next';

    currentSectionIndex = index;
}

// Previous button event
prevBtn.addEventListener('click', () => {
    if (currentSectionIndex > 0) {
        updateSection(currentSectionIndex - 1);
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
});

// Next button with validation and smooth scroll to top or invalid field
nextBtn.addEventListener('click', () => {
    if (validateCurrentSection()) {
        if (currentSectionIndex < sections.length - 1) {
            updateSection(currentSectionIndex + 1);
            window.scrollTo({ top: 0, behavior: 'smooth' });
        } else {
            alert('Form submitted!');
        }
    } else {
        const firstInvalidField = document.querySelector('.section.active .invalid');
        if (firstInvalidField) {
            firstInvalidField.scrollIntoView({ behavior: 'smooth' });
        }
    }
});

// Back button navigation
document.querySelector('.back-button').addEventListener('click', () => {
    window.location.href = 'ResumeReview.php';
});

// Validate required fields in the current section
function validateCurrentSection() {
    const currentSection = document.querySelector('.section.active');
    const formFields = currentSection.querySelectorAll('input[required]');
    let isValid = true;
    let alertShown = false;


    formFields.forEach((field) => {
        if (!field.value.trim()) {
            isValid = false;
            field.classList.add('invalid');
            if (!alertShown) {
                alert('Please fill all of the required fields!');
                alertShown = true;
            }
        } else {
            field.classList.remove('invalid');
        }
    });

    return isValid;
}
// Get DOM elements
const skillInput = document.getElementById('skill-input');
const addSkillBtn = document.getElementById('add-skill-btn');
const selectedSkillsList = document.getElementById('selected-skills-list');
const predefinedSkillsList = document.getElementById('predefined-skills-list');

// Store selected skills
let selectedSkills = new Set();

// Add custom skill
function addSkill(skillName) {
    if (skillName.trim() === '') return;
    
    if (!selectedSkills.has(skillName)) {
        selectedSkills.add(skillName);
        const skillElement = createSkillElement(skillName);
        selectedSkillsList.appendChild(skillElement);
    }
    
    skillInput.value = '';
}

// Create skill element
function createSkillElement(skillName) {
    const skillItem = document.createElement('div');
    skillItem.className = 'skill-item';
    skillItem.innerHTML = `
        ${skillName}
        <span class="remove-skill" onclick="removeSkill('${skillName}')">&times;</span>
    `;
    return skillItem;
}

// Remove skill
function removeSkill(skillName) {
    selectedSkills.delete(skillName);
    updateSelectedSkillsDisplay();
}

// Update skills display
function updateSelectedSkillsDisplay() {
    selectedSkillsList.innerHTML = '';
    selectedSkills.forEach(skill => {
        selectedSkillsList.appendChild(createSkillElement(skill));
    });
}

// Event listeners
addSkillBtn.addEventListener('click', () => {
    addSkill(skillInput.value);
});

skillInput.addEventListener('keypress', (e) => {
    if (e.key === 'Enter') {
        addSkill(skillInput.value);
    }
});

// Load predefined skills from database
function loadPredefinedSkills() {
    // First, clear the existing skills
    predefinedSkillsList.innerHTML = '';
    
    // Make AJAX request to get skills from database
    fetch('skills.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            // Check if data.skills exists and is an array
            if (data.skills && Array.isArray(data.skills)) {
                data.skills.forEach(skill => {
                    const skillElement = document.createElement('div');
                    skillElement.className = 'skill-suggestion';
                    skillElement.textContent = skill;
                    skillElement.onclick = () => addSkill(skill);
                    predefinedSkillsList.appendChild(skillElement);
                });
            } else {
                console.error('Invalid data format received:', data);
            }
        })
        .catch(error => {
            console.error('Error loading skills:', error);
            // Display error message to user
            predefinedSkillsList.innerHTML = '<p class="error">Failed to load predefined skills. You can still add custom skills.</p>';
        });
}

// Initialize
loadPredefinedSkills();

// Get all skills for form submission
function getSelectedSkills() {
    return Array.from(selectedSkills);
}

// For debugging
function debugSkills(data) {
    console.log('Received data:', data);
    console.log('Data type:', typeof data);
    if (Array.isArray(data)) {
        console.log('Is array of length:', data.length);
    }
}