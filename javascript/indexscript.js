// Select the buttons
const loginBtn = document.getElementById('loginBtn');
const signupBtn = document.getElementById('signupBtn');

// Add event listeners for click events
loginBtn.addEventListener('click', () => {
    window.location.href = 'test.html';
});

signupBtn.addEventListener('click', () => {
    window.location.href = 'signup.php';
});
