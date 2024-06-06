document.addEventListener('DOMContentLoaded', function() {
    const username = Cookies.get('username');
    const usertype = Cookies.get('usertype');
    if (username && usertype) {
      // Redirect based on user type
      var redirectUrl = 'public_html/' + usertype + '/dashboard.html';
      window.location.href = redirectUrl;
    } else {
      window.location.href = 'index.html'; // Redirect to login page if cookie not found
    }
  });
  