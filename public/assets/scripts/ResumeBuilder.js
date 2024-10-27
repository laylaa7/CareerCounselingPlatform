const sections = ['personal-info', 'education', 'work-history', 'skills' , 'overview'];
let currentSectionIndex = 0;

const prevBtn = document.getElementById('prev-btn');
const nextBtn = document.getElementById('next-btn');

function updateSection(index) {
    document.querySelector('.section.active').classList.remove('active');
    document.getElementById(sections[index]).classList.add('active');

    document.querySelector('.progress-item.active').classList.remove('active');
    document.querySelector(`[data-section="${sections[index]}"]`).classList.add('active');

    prevBtn.disabled = index === 0;
    nextBtn.disabled = index === sections.length - 1;
    nextBtn.textContent = index === sections.length - 1 ? 'Submit' : 'Next';

    currentSectionIndex = index;
}

prevBtn.addEventListener('click', () => {
    if (currentSectionIndex > 0) {
        updateSection(currentSectionIndex - 1);
        // Scroll to the top of the page
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
});

nextBtn.addEventListener('click', () => {
    if (currentSectionIndex < sections.length - 1) {
        updateSection(currentSectionIndex + 1);
        // Scroll to the top of the page
        window.scrollTo({ top: 0, behavior: 'smooth' });
    } else {
        // Handle form submission
        alert('Form submitted!');
    }
});

document.querySelector('.back-button').addEventListener('click', () => {
    // Handle back button click (e.g., return to previous page)
    window.location.href = 'ResumeReview.php';
});