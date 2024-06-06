document.addEventListener('deviceready', onDeviceReady, false);

function onDeviceReady() {
    // Check if the unique identifier is already stored
    var uniqueId = window.localStorage.getItem('uniqueId');
    
    if (!uniqueId) {
        // Generate a new unique identifier
        uniqueId = generateUniqueId();
        
        // Store the unique identifier locally
        window.localStorage.setItem('uniqueId', uniqueId);
    }

    console.log('Unique ID:', uniqueId);
}

function generateUniqueId() {
    // Generate a random number and combine it with a timestamp to create a unique identifier
    var randomNumber = Math.floor(Math.random() * 1000000); // Generate a random number between 0 and 999999
    var timestamp = new Date().getTime(); // Get the current timestamp
    return 'user_' + timestamp + '_' + randomNumber;
}
