document.addEventListener("DOMContentLoaded", function () {
    const registrationForm = document.getElementById("registration-form");

    // Ensure hotel_id is properly set
    const hotelId = new URLSearchParams(window.location.search).get("hotel_id");

    if (!hotelId) {
        alert("Hotel ID is missing. Please retry.");
        return;
    }

    // Handle form submission for calculating price and registration
    registrationForm.addEventListener("submit", function (e) {
        e.preventDefault();

        const checkInDate = document.getElementById("check_in_date").value;
        const checkOutDate = document.getElementById("check_out_date").value;
        const numberOfRooms = document.getElementById("num_rooms").value;
        const numberOfGuests = document.getElementById("num_guests").value;

        console.log({
            check_in_date: checkInDate,
            check_out_date: checkOutDate,
            number_of_rooms: numberOfRooms,
            number_of_guests: numberOfGuests,
        });
        

        // Validate input fields
        if (!checkInDate || !checkOutDate || numberOfRooms <= 0 || numberOfGuests <= 0) {
            alert("Please fill out all fields correctly.");
            return;
        }

        // Confirm with the user if they want to proceed
        
            // AJAX request to the server
            fetch(`hotel_reg.php?hotel_id=${hotelId}`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({
                    check_in_date: checkInDate,
                    check_out_date: checkOutDate,
                    num_rooms: numberOfRooms,
                    num_guests: numberOfGuests,
                }),
            })
                // .then((response) => response.json())
                // .then((data) => {
                //     if (data.success) {
                //         alert(data.message); // Booking success message
                //         window.location.href = "user_home.php"; // Redirect to user home
                //     } else {
                //         alert(data.message); // Show error message
                //     }
                // })
                // .catch((error) => {
                //     console.error("Error:", error);
                //     alert("An error occurred while processing your booking.");
                // });
                if (confirm("Are you sure you want to book this hotel?")) {
                    // Redirect to user_home.php
                    window.location.href = "user_home.php";
                }
        
        }
    );
});
