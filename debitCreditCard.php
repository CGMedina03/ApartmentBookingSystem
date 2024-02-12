<?php
session_start();

// Retrieve userId from session
$userId = isset($_SESSION['userId']) ? $_SESSION['userId'] : '';

// Retrieve selected payment option from form submission
$selectedPaymentOption = isset($_POST['paymentOption']) ? $_POST['paymentOption'] : '';

echo "User ID: $userId<br>";
echo "Selected Payment Option: $selectedPaymentOption";
?>

<style>
    body {
        overflow-x: hidden;
    }

    .row {
        display: -ms-flexbox;
        /* IE10 */
        display: flex;
        -ms-flex-wrap: wrap;
        /* IE10 */
        flex-wrap: wrap;
        margin: 30px 0;
    }

    .col-75 {
        -ms-flex: 75%;
        /* IE10 */
        flex: 75%;
        padding: 0 16px;
    }

    .container {
        background-color: #f2f2f2;
        padding: 5px 20px 15px 20px;
        border: 1px solid lightgrey;
        border-radius: 3px;
    }

    input[type="text"],
    input[type="password"] {
        width: 100%;
        margin-bottom: 0px;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 3px;
    }

    label {
        margin-bottom: 10px;
        display: block;
    }

    .icon-container {
        margin-bottom: 20px;
        padding: 7px 0;
        font-size: 24px;
    }

    .btn {
        background-color: #04aa6d;
        color: white;
        padding: 12px;
        margin: 10px 0;
        border: none;
        width: 100%;
        border-radius: 3px;
        cursor: pointer;
        font-size: 17px;
    }

    .btn:hover {
        background-color: #45a049;
    }

    .error-message {
        color: red;
        font-size: 12px;
        margin-top: 5px;
    }

    @media (max-width: 800px) {
        .row {
            flex-direction: column-reverse;
        }

        .col-25 {
            margin-bottom: 20px;
        }
    }

    #general-error {
        font-size: 20px;
        font-weight: bold;
    }

    .input-group .input-group-text {
        height: 100%;
    }
</style>
<title>Card Payment</title>
</head>

<div class="row">
    <div class="col-75">
        <div class="container">
            <form action="..\account.php" method="post" onsubmit="return validateForm()">
                <div class="row">
                    <div class="col-50">
                        <h3>Payment</h3>
                        <div class="col-50">
                            <label>Card Type</label>
                            <h4 id="cardtype-display"></h4>
                        </div>
                        <label for="cname">Card name</label>
                        <input type="text" id="cname" name="cardname" placeholder="John More Doe" required />
                        <div id="cname-error" class="error-message"></div>
                        <label for="ccnum">Card number</label>
                        <input type="text" id="ccnum" name="cardnumber" placeholder="1111222233334444" required />
                        <div id="ccnum-error" class="error-message"></div>
                        <label for="expmonth">Exp Month</label>
                        <input type="text" id="expmonth" name="expmonth" placeholder="1" required />
                        <div id="expmonth-error" class="error-message"></div>
                        <div class="row">
                            <div class="col-50">
                                <label for="expyear">Exp Year</label>
                                <input type="text" id="expyear" name="expyear" placeholder="2018" required />
                                <div id="expyear-error" class="error-message"></div>
                            </div>
                            <div class="col-50">
                                <label for="cvv">CVV</label>
                                <input type="text" id="cvv" name="cvv" placeholder="352" required />
                                <div id="cvv-error" class="error-message"></div>
                            </div>
                            <div class="col-50">
                                <label for="password">Password</label>
                                <div class="input-group ">
                                    <input type="password" id="password" name="password" class="form-control" />
                                    <div class="input-group-append">
                                        <span class="input-group-text" onclick="togglePasswordVisibility()">
                                            <i id="toggle-icon" class="fas fa-eye-slash "></i>
                                        </span>
                                    </div>
                                </div>
                                <div id="password-error" class="error-message"></div>
                                <span class="text-muted">For the password not enabled, leave the space blank</span>
                            </div>
                            <h2 id="general-error" class="error-message"></h2>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn">Continue to checkout</button>
            </form>
        </div>
    </div>
</div>
<script src="js\cardValidation.js">
</script>