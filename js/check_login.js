document.addEventListener('DOMContentLoaded', function() {
    const username = Cookies.get('username');
    if (username) {
        const usernameElement = document.getElementById('username');
        if (usernameElement) {
            usernameElement.innerText = username;
        } else {
            console.error("Element with ID 'username' not found.");
        }
    } else {
        window.location.href = '../../index.html'; // Redirect to login page if cookie not found
    }
});
