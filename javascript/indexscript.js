// Select the buttons
const loginBtn = document.getElementById('loginBtn');
const signupBtn = document.getElementById('signupBtn');

// Add event listeners for click events
loginBtn.addEventListener('click', () => {
    window.location.href = 'login.php';
});

signupBtn.addEventListener('click', () => {
    window.location.href = 'signup.php';
});
