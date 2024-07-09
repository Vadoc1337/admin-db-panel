/******* This function checks if the input value contains spaces and removes them if the input id is 'username', 'password', or 'login'. ******/
function checkForSpaces(input) {
    if (input.id === 'username' || input.id === 'password' || input.id === "login") {
        if (input.value.includes(' ')) {
            input.value = input.value.replace(/\s/g, '');
        }
    }
}

/*********This function converts the date input to ISO format.**************/
document.querySelector('form').addEventListener('submit', function (e) {
    let birthDateInput = document.getElementById('birth_date');
    let date = new Date(birthDateInput.value);
    if (!isNaN(date.getTime())) {
        birthDateInput.value = date.toISOString().split('T')[0];
    }
});

/***********This function handles the search functionality.****************/

// Wait for the DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('search__input');
    const clearButton = document.getElementById('search__clear-button');
    let typingTimer;
    const doneTypingInterval = 500; // ms

    // Function to toggle clear button visibility
    function toggleClearButton() {
        clearButton.style.display = searchInput.value ? 'block' : 'none';
    }

    // Function to reset search
    function resetSearch() {
        // Only submit if the search field is empty
        if (searchInput.value === '') {
            // Reset sort and order parameters
            const urlParams = new URLSearchParams(window.location.search);
            urlParams.delete('search');
            urlParams.delete('sort');
            urlParams.delete('order');

            // Redirect to the page with reset parameters
            window.location.href = window.location.pathname + '?' + urlParams.toString();
        }
    }

    // Show/hide clear button based on input content
    searchInput.addEventListener('input', function () {
        toggleClearButton();

        // Clear the existing timer
        clearTimeout(typingTimer);

        // Start a new timer
        typingTimer = setTimeout(resetSearch, doneTypingInterval);
    });

    // Clear the search input and reset the search
    clearButton.addEventListener('click', function () {
        searchInput.value = '';
        toggleClearButton();
        resetSearch();
    });

    // Initial toggle on page load
    toggleClearButton();
});

/****************This function handles the max length of the input fields****************/
document.getElementById('search__input').addEventListener('input', function (event) {
    const maxLength = 100;
    if (event.target.value.length > maxLength) {
        event.target.value = event.target.value.substring(0, maxLength);
    }
});
document.getElementById('username').addEventListener('input', function (event) {
    const maxLength = 50;
    if (event.target.value.length > maxLength) {
        event.target.value = event.target.value.substring(0, maxLength);
    }
});
document.getElementById('password').addEventListener('input', function (event) {
    const maxLength = 255;
    if (event.target.value.length > maxLength) {
        event.target.value = event.target.value.substring(0, maxLength);
    }
});
