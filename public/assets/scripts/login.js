document.addEventListener('DOMContentLoaded', function() {
  const loginBtn = document.getElementById('loginBtn');
  const loginPopup = document.getElementById('loginPopup');
  const signupPopup = document.getElementById('signupPopup');
  const signupLink = document.getElementById('signupLink');
  const loginLink = document.getElementById('loginLink');
  const closeBtns = document.querySelectorAll('.close');

  function showPopup(popup) {
      popup.classList.add('active');
  }

  function hidePopup(popup) {
      popup.classList.remove('active');
  }

  loginBtn.addEventListener('click', function() {
      showPopup(loginPopup);
  });

  signupLink.addEventListener('click', function(e) {
      e.preventDefault();
      hidePopup(loginPopup);
      showPopup(signupPopup);
  });

  loginLink.addEventListener('click', function(e) {
      e.preventDefault();
      hidePopup(signupPopup);
      showPopup(loginPopup);
  });

  closeBtns.forEach(function(btn) {
      btn.addEventListener('click', function() {
          hidePopup(this.closest('.popup'));
      });
  });

  window.addEventListener('click', function(e) {
      if (e.target.classList.contains('popup')) {
          hidePopup(e.target);
      }
  });

  // Prevent form submission (for demonstration purposes)
  document.getElementById('loginForm').addEventListener('submit', function(e) {
      
      console.log('Login form submitted');
      // Implement your login logic here
  });

  $('#signupForm').on('submit', function (e) {
    e.preventDefault();

    const formData = $(this).serialize();
    $.post('signup.php', formData, function (response) {
        console.log(response); // Debug response
        if (response.trim() === 'OTP_SENT') {
            $('#signupPopup').removeClass('active'); // Hide Signup Popup
            $('#otpPopup').addClass('active'); // Show OTP Popup
        } else {
            alert(response); // Handle any signup error
        }
    });
});
})
