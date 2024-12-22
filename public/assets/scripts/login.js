document.addEventListener('DOMContentLoaded', function () {
    const loginBtn = document.getElementById('loginBtn');
    const loginPopup = document.getElementById('loginPopup');
    const signupPopup = document.getElementById('signupPopup');
    const signupLink = document.getElementById('signupLink');
    const loginLink = document.getElementById('loginLink');
    const closeBtns = document.querySelectorAll('.close');
    const loginForm = document.getElementById('loginForm');
    const signupForm = document.getElementById('signupForm');

    function showPopup(popup) {
        popup.classList.add('active');
    }

    function hidePopup(popup) {
        popup.classList.remove('active');
    }

    loginBtn.addEventListener('click', function () {
        showPopup(loginPopup);
    });

    signupLink.addEventListener('click', function (e) {
        e.preventDefault();
        hidePopup(loginPopup);
        showPopup(signupPopup);
    });

    loginLink.addEventListener('click', function (e) {
        e.preventDefault();
        hidePopup(signupPopup);
        showPopup(loginPopup);
    });

    closeBtns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            hidePopup(this.closest('.popup'));
        });
    });

    window.addEventListener('click', function (e) {
        if (e.target.classList.contains('popup')) {
            hidePopup(e.target);
        }
    });

    // Login Form Submission
    document.addEventListener('DOMContentLoaded', function () {
        const loginForm = document.getElementById('loginForm');
    
        if (loginForm) {
            loginForm.addEventListener('submit', function (e) {
                e.preventDefault(); // Prevent default form submission
    
                const formData = new FormData(this); // Collect form data
                formData.append('action', 'login'); // Add action for backend handling
    
                fetch('/career/CareerCounselingPlatform/src/controller/UserController.php', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => {
                        if (response.headers.get('content-type')?.includes('application/json')) {
                            return response.json();
                        } else {
                            return response.text().then(text => {
                                throw new Error(`Unexpected response: ${text}`);
                            });
                        }
                    })
                    .then(data => {
                        if (data.status === 'success') {
                            // Redirect based on role
                            if (data.role == 2) {
                                window.location.href = '/career/AdminDash.php';
                            } else if (data.role == 1) {
                                window.location.href = '/career/CounselorDashboard.php';
                            } else if (data.role == 0) {
                                window.location.href = '/career/UserDashboard.php';
                            }
                        } else {
                            alert(data.message || 'An error occurred.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert(`Error: ${error.message}`);
                    });
            });
        } else {
            console.error('Login form not found in the DOM.');
        }
    });

    // Signup Form Submission
    
    if (signupForm) {
        signupForm.addEventListener('submit', function (e) {
            e.preventDefault(); // Prevent default form submission

            const formData = new FormData(this); // Collect form data
            formData.append('action', 'signup'); // Add action key for backend handling

            fetch('/career/CareerCounselingPlatform/src/controller/UserController.php', {
                method: 'POST',
                body: formData
            })
                .then(response => {
                    if (response.headers.get('content-type')?.includes('application/json')) {
                        return response.json();
                    } else {
                        return response.text().then(text => {
                            throw new Error(`Unexpected response: ${text}`);
                        });
                    }
                })
                .then(data => {
                    if (data.status === 'success') {
                        alert('Signup successful!');
                        window.location.href = '/career/login.php'; // Redirect to login page
                    } else {
                        alert(data.message); // Show error message
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert(`Error: ${error.message}`);
                    // Show raw response if available
                    if (error.responseText) {
                        console.error('Raw Response:', error.responseText);
                    }
                });
        });
    } else {
        console.error('Signup form not found in the DOM.');
    }
});
