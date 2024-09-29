
<?php
// Assume the session has already started
include('server.php');
session_start();

// Initialize variables for response and card details
$response = '';
$cardDetails = array();

// Check if the user is logged in
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    // Perform a query to get card details for the logged-in user
    $query = "SELECT * FROM card WHERE username = '$username'";

    // Execute the query
    $result = $conn->query($query);

    if ($result !== false) {
        if ($result->num_rows > 0) {
            // User has a card, fetch the details
            $cardDetails = $result->fetch_assoc();
            $response = 'success';
        } else {
            // User doesn't have a card, set response accordingly
            $response = 'no_card';
        }
    } else {
        // Handle the case where the query fails
        $response = 'query_error';
    }
} else {
    // Handle the case where the user is not logged in
    $response = 'user_not_logged_in';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Your existing head content here -->
    <meta cha$et="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Card Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Include jQuery (required for intl-tel-input) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Add these links to include Swiper CSS and JS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <link href="craft.css" rel="stylesheet">
 <script>
        $(document).ready(function () {
            $("#head").load("navbar2.html");
        });
        $(document).ready(function () {
            $("#footer").load("footer.html");
        });
    </script>
    <style>
        #creditcarddiv{
            background-image: url('img/credit.jpg');
    object-fit: 100%;
  background-size: 100%;
        }
 .credit-card {
   
    /*background-color: #026476;*/
    color: #000;
    padding: 20px;
    border-radius: 10px;
    /*box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);*/
    text-align: center;
    position: relative;
}

.card-icon {
    width: 60px;
    height: auto;
    margin: 15px;
}

.card-header {
    font-size: 1.5em;
    font-weight: bold;
    margin: 15px;
    /*margin-bottom: 15px;*/
}

.card-number {
    font-size: 1.5em;
    margin-bottom: 15px;
}

.cardholder-name,
.date-of-issue,
.card-balance {
    font-size: 1.2em;
    margin-bottom: 15px;
}

.card-balance {
    display: none;
}

.btn-primary {
    background-color: #FFB400;
    border-color: #FFB400;
}

.btn-primary:hover {
    background-color: #D29200;
    border-color: #D29200;
}



    </style>
</head>

<body>
<div class="head" id="head">
    <!-- Your header content here -->
</div>

    <!-- Your existing body content here -->

    <div class="container mt-5">
    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#profileModal">Check Profile</button>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card my-3" >
                <div class="card-body" id="creditcarddiv">
                    <?php
                    // Display HTML based on the response
                    if ($response === 'success') {
                        echo '<div class="credit-card">';
                        echo '<div class="d-flex justify-content-between align-items-center">';
                        echo '<img src="./img/logo.jpeg" alt="Credit Card Icon" class="card-icon">';
                        echo '<div class="card-header text-end">HandMade-Haven</div>';
                        echo '</div>';
                        echo '<div class="cardholder-info">';
                        echo '<div class="card-label">Cardholder Name</div>';
                        echo '<div class="cardholder-name">' . $cardDetails['name'] . '</div>';
                        echo '</div>';
                        echo '<div class="card-number-info">';
                        echo '<div class="card-label">Card Number</div>';
                        echo '<div class="card-number">' . formatCardNumber($cardDetails['card_number']) . '</div>';
                        echo '</div>';
                        echo '<div class="date-of-issue">Issued On: ' . $cardDetails['date_of_issue'] . '</div>';
                        echo '<div class="card-balance">Balance: $' . $cardDetails['balance'] . '</div>';
                        echo '<div class="text-center my-3">';
                        echo '<button class="btn btn-primary" onclick="toggleBalance()">Balance</button>';
                        echo '</div>';
                        echo '</div>';
                        echo '<div class="text-center my-2"><a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#buyCardModal">Add Balance</a></div>';
       
                    } elseif ($response === 'no_card') {
                        echo '<div class="alert alert-warning text-center" role="alert">No card found for the user. Please buy your fi$t card.</div>';
                        // Add a button or link to buy a card
                        echo '<div class="text-center"><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#buyCardForm">Buy Card</button></div>';
                    } else {
                        // Handle other responses (query_error, user_not_logged_in, etc.)
                        echo '<div class="alert alert-danger text-center" role="alert">Error: ' . $response . '</div>';
                    }
                    
                    ?>
                </div>
            </div>
            </div>
    </div>
</div>


<?php
// Function to format card number into four-four groups
function formatCardNumber($cardNumber) {
    // Remove any non-numeric characte$
    $cardNumber = preg_replace('/\D/', '', $cardNumber);

    // Split the card number into groups of four
    $formattedNumber = implode(' ', str_split($cardNumber, 4));

    return $formattedNumber;
}


?>
   <!---->
   <script>
    function toggleBalance() {
        var balanceDiv = $('.card-balance');
        balanceDiv.toggle();
        
        // Change button text based on the visibility of the balance
        var buttonText = balanceDiv.is(':visible') ? 'Hide Balance' : 'Balance';
        $('.btn-primary').text(buttonText);
    }
</script>

<!-- Modal for Buying Card -->
<div class="modal fade" id="buyCardForm" tabindex="-1" role="dialog" aria-labelledby="buyCardFormLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="buyCardFormLabel">Buy Card</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="cardForm">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="initialAmount" class="form-label">Initial Amount</label>
                        <select class="form-select" id="initialAmount" name="initialAmount" required>
                            <option value="500">500 $</option>
                            <option value="1000">1000 $</option>
                            <option value="1500">1500 $</option>
                            <option value="2000">2000 $</option>
                        </select>
                    </div>
                    <button type="button" class="btn btn-primary" onclick="buyCardInit()">Buy</button>
                </form>
            </div>
        </div>
    </div>
</div>



<!-- Modal for Buying Card -->
<div class="modal fade" id="buyCardModal" tabindex="-1" role="dialog" aria-labelledby="buyCardModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="buyCardModalLabel">Add Balance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Select the amount for your card or enter a custom amount:</p>
                <select class="form-select" id="cardAmount">
                    <option value="500">500 $</option>
                    <option value="1000">1000 $</option>
                    <option value="1500">1500 $</option>
                    <option value="2000">2000 $</option>
                </select>
                <div class="mb-3">
                    <label for="customAmount" class="form-label">Custom Amount ($)</label>
                    <input type="number" class="form-control" id="customAmount" placeholder="Enter custom amount">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" onclick="buyCard()">Add Balance</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for User Profile -->
<div class="modal fade" id="profileModal" tabindex="-1" role="dialog" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="profileModalLabel">User Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php
                // Fetch user information from the signup table
                $queryProfile = "SELECT * FROM userlogin WHERE username = '$username'";
                $resultProfile = $conn->query($queryProfile);

                if ($resultProfile !== false && $resultProfile->num_rows > 0) {
                    $profileData = $resultProfile->fetch_assoc();
                    echo '<p><strong>Username:</strong> ' . $profileData['username'] . '</p>';
                    echo '<p><strong>Email:</strong> ' . $profileData['email'] . '</p>';
                    echo '<p><strong>Security Answer:</strong> ' . $profileData['sec_answer'] . '</p>';
                } else {
                    echo '<p>No profile information found.</p>';
                }
                ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Add a loading indicator (spinner) to your HTML -->


<script>
    function buyCardInit() {
        // Display the loading message
        alert('Your request is being processed. Please wait a few seconds.');

        // Get form data
        const formData = $('#cardForm').serialize();

        // Perform AJAX request to buy card
        $.ajax({
            type: 'POST',
            url: 'buy_card_Init.php', // Replace with the actual PHP script handling card purchase
            data: formData,
            dataType: 'json',
            success: function (response) {
                // Hide the loading message after receiving the response
                alert('Card purchase request processed.');

                // Show success or error message
                if (response.success) {
                    alert('Card purchased successfully!');
                    // Close the modal and refresh the page or update the balance without refreshing
                    $('#buyCardForm').modal('hide');
                    location.reload(); // You can use a more sophisticated approach with AJAX to update the balance without refreshing
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function () {
                // Hide the loading message in case of an error
                alert('An error occurred while buying the card.');
            }
        });
    }
</script>



<script>
    function buyCard() {
        // Get selected card amount
        const selectedAmount = $('#cardAmount').val();
        
        // If custom amount is entered, use it; otherwise, use the selected amount
        const customAmount = $('#customAmount').val() || selectedAmount;

        // Perform AJAX request to buy card
        $.ajax({
            type: 'POST',
            url: 'buy_card.php', // Replace with the actual PHP script handling card purchase
            data: { amount: customAmount },
            dataType: 'json',
            success: function (response) {
                // Show success or error message
                if (response.success) {
                    alert('Balance Added successfully!'); // You can enhance this with a modal or a more styled message
                    // Close the modal
                    $('#buyCardModal').modal('hide');
                    // Refresh the page or update the balance without refreshing
                    location.reload(); // You can use a more sophisticated approach with AJAX to update the balance without refreshing
                } else {
                    alert('Error: ' + response.message); // Display error message
                }
            },
            error: function () {
                alert('An error occurred while buying the card.'); // Display error message
            }
        });
    }
</script>

<!-- ... Your remaining HTML code ... -->


<!---->
<div id="footer"></div>
<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>
