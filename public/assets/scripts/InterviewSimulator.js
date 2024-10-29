const questions = [
    {
        question: "Tell me about yourself.",
        overview: "This question provides employers with an early preview of your core skills, personality and ability to respond to an unstructured question."
    },
    {
        question: "What is your greatest strength?",
        overview: "Your answer should highlight qualities that make you an excellent candidate for the position."
    },
    {
        question: "What is your greatest weakness?",
        overview: "Focus on a real weakness, but one that you're working on improving."
    },
    {
        question: "Why should we hire you?",
        overview: "This is your chance to sell yourself and your skills to the hiring manager."
    },
    {
        question: "Why do you want to work here?",
        overview: "Show that you've done your research about the company and are enthusiastic about the role."
    }
];

let currentQuestionIndex = 0;
const questionText = document.getElementById('question-text');
const answerInput = document.getElementById('answer-input');
const nextButton = document.getElementById('next-button');
const progressFill = document.getElementById('progress-fill');
const currentQuestionSpan = document.getElementById('current-question');
const totalQuestionsSpan = document.getElementById('total-questions');

function updateQuestion() {
    const question = questions[currentQuestionIndex];
    questionText.textContent = question.question;

    // Remove existing overview
    const existingOverview = document.querySelector('.overview');
    if (existingOverview) {
        existingOverview.remove();
    }

    // Add new overview
    const overview = document.createElement('div');
    overview.className = 'overview';
    overview.textContent = question.overview;
    document.querySelector('.question-container').appendChild(overview);

    // Calculate and set progress width
    const progress = ((currentQuestionIndex + 1) / questions.length) * 100;
    progressFill.style.width = `${progress}%`;
    console.log(`Progress: ${progress}%`); // Debugging line to confirm progress

    // Update question number display
    currentQuestionSpan.textContent = currentQuestionIndex + 1;
    totalQuestionsSpan.textContent = questions.length;

    // Clear previous answer
    answerInput.value = '';

    // Update button text for last question
    nextButton.textContent = currentQuestionIndex === questions.length - 1 ? 'Finish' : 'Next Question';
}

nextButton.addEventListener('click', () => {
    if (answerInput.value.trim() === '') {
        alert('Please provide an answer before continuing.');
        return;
    }

    if (currentQuestionIndex < questions.length - 1) {
        currentQuestionIndex++;
        updateQuestion();
    } else {
        alert('Interview completed! Thank you for your responses.');
        // Here you could add code to submit the answers or process them further
    }
});

// Initialize first question
updateQuestion();