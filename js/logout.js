function logout() {
    console.log('Logout function called');
    // Clear the cookies
    Cookies.remove('username');
    Cookies.remove('usertype');
    Cookies.remove('city');

    // Redirect to the login page
    window.location.href = '../../index.html';
}
