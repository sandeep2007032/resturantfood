function showBookButton() {
    const isLoggedIn = true;  // You would determine this based on user login status
  
    if (isLoggedIn) {
      const bookSection = document.getElementById('book-section');
      bookSection.style.display = 'block';
    }
  }
  
  function bookTable() {
    const phoneNumber = prompt('Please enter your phone number:');
  
    // Send reservation request to the server (assuming a backend API)
    // Here, we're just displaying a confirmation message
    alert('Table booked successfully! Your table number is: 12');
  
    // Send a message to the provided phone number (hypothetically through an API)
    // For demonstration purposes, we're just logging the message
    console.log(`Message sent to ${phoneNumber}: Your table number is 12`);
  }
  
  // Call the function to display the book button based on login status
  showBookButton();
  