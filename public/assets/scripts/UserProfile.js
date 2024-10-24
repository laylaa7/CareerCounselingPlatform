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


document.addEventListener('DOMContentLoaded', function() {
    console.log("JavaScript file is loaded!!!");

    // Handle profile links click
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

    // Handle edit button click
    document.querySelectorAll('.edit-button').forEach(button => {
        button.addEventListener('click', function() {
            const sectionId = this.closest('.profile-section').id; // Get the parent section ID
            toggleEdit(sectionId);
        });
    });
});

// Function to toggle edit mode
function toggleEdit(sectionId) {
    const viewMode = document.getElementById(`${sectionId}-view`);
    const editMode = document.getElementById(`${sectionId}-edit`);

    // Hide view mode, show edit mode
    viewMode.style.display = "none";
    editMode.style.display = "block";
}

// Function to save info (this needs to be linked to the save button click)
function saveInfo(sectionId) {
    const nameInput = document.getElementById('name').value; // Adjusted ID for input fields
    const emailInput = document.getElementById('email').value;
    const phoneInput = document.getElementById('phone').value;

    // Update the view with new data
    document.getElementById('view-name').textContent = nameInput;
    document.getElementById('view-email').textContent = emailInput;
    document.getElementById('view-phone').textContent = phoneInput;

    // Hide edit mode, show view mode
    const viewMode = document.getElementById(`${sectionId}-view`);
    const editMode = document.getElementById(`${sectionId}-edit`);

    editMode.style.display = "none";
    viewMode.style.display = "block";
}
