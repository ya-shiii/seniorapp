$(document).ready(function () {
    // Function to fetch full name from session and display it
    function fetchFullName() {
        $.ajax({
            type: 'GET',
            url: 'php/fetch_session.php', // You need to create this file to fetch full name from session
            dataType: 'json',
            success: function (data) {
                if (data.success && data.role === 'citizen') {
                    $('#fullname-display').text(data.fullname);
                    console.log(data.fullname);
                } else {
                    // Alert unauthorized access and redirect to unauthorized page if session is not set or user is not admin
                    alert('You need to login first.');
                    window.location.href = data.success ? 'index.html' : 'index.html';
                }
            },
            error: function (xhr, status, error) {
                $('#fullname-display').text("Error fetching full name");
            }
        });
    }

    // Fetch and display full name on page load
    fetchFullName();

    // Function to fetch and populate cards for items
    function fetchseniorcitizens() {
        $.ajax({
            type: 'GET',
            url: 'php/fetch_citizens.php',
            dataType: 'json',
            success: function (data) {
                console.log(data); // Add this line to debug the response
                if (Array.isArray(data)) {
                    // Loop through each item and populate cards
                    data.forEach(function (item) {
                        var card = `
                            <div class="col-lg-4 col-md-6 col-sm-10 my-2">
                                <a href="#" class="card h-100 bg-dark text-white w-auto">
                                    <div class="card-body">
                                        <div class="mb-4 col-12" style="height: 200px; overflow:hidden">
                                            <img src="${item.imageUrl}" alt="${item.FirstName} ${item.LastName}" class="img-fluid w-full mb-3">
                                        </div>
                                        <h5 class="card-text text-bold">${item.FirstName} ${item.LastName}</h5>
                                        <p class="card-text">ID: ${item.SeniorID}</p>
                                        <p class="card-text">Age: ${item.Age}</p>
                                        <p class="card-text">Gender: ${item.Gender}</p>
                                        <p class="card-text">Address: ${item.Address}</p>
                                    </div>
                                </a>
                            </div>`;

                        $('.row').append(card);
                    });
                } else {
                    console.error("Expected an array but got:", data);
                }
            },
            error: function (xhr, status, error) {
                console.error("Error fetching items:", error);
            }
        });
    }

    // Call function to fetch and populate cards for items
    fetchseniorcitizens();

    // Logout functionality
    $('#logout-link').click(function (event) {
        event.preventDefault();
        alert('Logged out successfully.')
        window.location.href = 'php/logout.php';
    });
});
