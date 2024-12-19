document.addEventListener('DOMContentLoaded', function() {
    // Dynamic Education Addition
    document.getElementById('addEducation').addEventListener('click', function() {
        const container = document.getElementById('educationContainer');
        const newEntry = container.querySelector('.education-entry').cloneNode(true);
        
        // Clear input values
        newEntry.querySelectorAll('input').forEach(input => input.value = '');
        
        container.appendChild(newEntry);
    });

    // Dynamic Work Experience Addition
    document.getElementById('addWork').addEventListener('click', function() {
        const container = document.getElementById('workContainer');
        const newEntry = container.querySelector('.work-entry').cloneNode(true);
        
        // Clear input values
        newEntry.querySelectorAll('input, textarea').forEach(input => input.value = '');
        
        container.appendChild(newEntry);
    });

    // Dynamic Skills Addition
    document.getElementById('addSkill').addEventListener('click', function() {
        const container = document.getElementById('skillsContainer');
        const newEntry = container.querySelector('.skills-entry').cloneNode(true);
        
        // Clear input values
        newEntry.querySelectorAll('input, select').forEach(input => input.value = '');
        
        container.appendChild(newEntry);
    });

    // Preview Modal
    const previewBtn = document.getElementById('previewBtn');
    const modal = document.getElementById('previewModal');
    const closeBtn = document.querySelector('.close');
    const previewContent = document.getElementById('previewContent');

    previewBtn.addEventListener('click', function() {
        // Collect form data
        const formData = new FormData(document.getElementById('resumeForm'));
        
        // Generate preview HTML
        let previewHTML = `
            <div class="preview-section">
                <h2>Personal Information</h2>
                <p><strong>Name:</strong> ${formData.get('fullName')}</p>
                <p><strong>Email:</strong> ${formData.get('email')}</p>
                <p><strong>Phone:</strong> ${formData.get('phone')}</p>
                <p><strong>Address:</strong> ${formData.get('address')}</p>
            </div>
        `;

        // Education Preview
        previewHTML += `
            <div class="preview-section">
                <h2>Education</h2>
        `;
        const degrees = formData.getAll('degree[]');
        const institutions = formData.getAll('institution[]');
        const gradYears = formData.getAll('gradYear[]');

        for (let i = 0; i < degrees.length; i++) {
            if (degrees[i]) {
                previewHTML += `
                    <p>
                        <strong>${degrees[i]}</strong> - ${institutions[i] || 'N/A'}
                        ${gradYears[i] ? `(${gradYears[i]})` : ''}
                    </p>
                `;
            }
        }
        previewHTML += `</div>`;

        // Work Experience Preview
        previewHTML += `
            <div class="preview-section">
                <h2>Work Experience</h2>
        `;
        const jobTitles = formData.getAll('jobTitle[]');
        const companies = formData.getAll('company[]');
        const startDates = formData.getAll('startDate[]');
        const endDates = formData.getAll('endDate[]');
        const jobDescriptions = formData.getAll('jobDescription[]');

        for (let i = 0; i < jobTitles.length; i++) {
            if (jobTitles[i]) {
                previewHTML += `
                    <div>
                        <p><strong>${jobTitles[i]}</strong> at ${companies[i] || 'N/A'}</p>
                        <p>
                            ${startDates[i] ? `From: ${startDates[i]}` : ''} 
                            ${endDates[i] ? `To: ${endDates[i]}` : 'Present'}
                        </p>
                        <p>${jobDescriptions[i] || ''}</p>
                    </div>
                `;
            }
        }
        previewHTML += `</div>`;

        // Skills Preview
        previewHTML += `
            <div class="preview-section">
                <h2>Skills</h2>
        `;
        const skills = formData.getAll('skill[]');
        const skillLevels = formData.getAll('skillLevel[]');

        for (let i = 0; i < skills.length; i++) {
            if (skills[i]) {
                previewHTML += `
                    <p><strong>${skills[i]}</strong> - ${skillLevels[i] || 'Not specified'}</p>
                `;
            }
        }
        previewHTML += `</div>`;

        // Update preview content
        previewContent.innerHTML = previewHTML;
        
        // Show modal
        modal.style.display = 'block';
    });

    // Close modal when clicking (x)
    closeBtn.addEventListener('click', function() {
        modal.style.display = 'none';
    });

    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    });

    // Form Submission (to be replaced with PHP processing)
   
});