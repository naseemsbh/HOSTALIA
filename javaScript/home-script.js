const wrapper = document.querySelector('.wrapper');
const loginLink = document.querySelector('.login-link');
const registerLink = document.querySelector('.register-link');
const btnPopup = document.querySelector('.btnlogin-popup');
const iconClose = document.querySelector('.icon-close');
registerLink.addEventListener('click', () => {
    wrapper.classList.add('active');
});

loginLink.addEventListener('click', () => {
    wrapper.classList.remove('active');
});

btnPopup.addEventListener('click', () => {
    wrapper.classList.add('active-popup');
});

iconClose.addEventListener('click', () => {
    wrapper.classList.remove('active-popup');
});
        // Function to simulate double click
        function doubleClick(element) {
            element.click(); // First click
            setTimeout(() => {
                element.click(); // Second click after a delay
            }, 100);
        }

        // Get the button element
        const loginButton = document.getElementById('loginButton');

        // Simulate double click when the page loads
        doubleClick(loginButton);

        // Add click event listener for demonstration purposes
        homeButton.addEventListener('click', function() {
            console.log('Home button clicked!');
        });

     