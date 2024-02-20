<?php
session_start();
require "../components/connect.php"; // Assuming this file contains the database connection
require "../components/layout.php";
$userId = $_GET['userId'];

// Update the dateMoved column to the current date for the specified userId
$sql = "UPDATE rented SET dateMoved = CURDATE() WHERE id = '$userId'";

if ($conn->query($sql) === TRUE) {
    $_SESSION['successPaymentMessage'] = "Payment successful. Thank you!";
    unset($_SESSION["successPaymentMessage"]);
} else {
    $_SESSION['errorMessage'] = "Error updating record: " . $conn->error;
}
$conn->close();
?>

<meta charset="utf-8" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1" />

<title>One Time PIN | Maya</title>

<meta name="description" content="" />
<meta name="keywords" content="" />
<meta name="robot" content="index,follow" />
<meta name="copyright" content="Copyright © 2022 Maya. All rights reserved." />
<meta name="format-detection" content="telephone=no" />

<link type="text/css" rel="stylesheet"
    href="https://iam-assets-staging.paymaya.com/maya-connect-ui/2.0.18/styles/main.css" charset="UTF-8" />

<script type="text/javascript"
    src="https://iam-assets-staging.paymaya.com/maya-connect-ui/2.0.18/scripts/vendor/jquery.min.js"
    charset="UTF-8"></script>
<script type="text/javascript"
    src="https://iam-assets-staging.paymaya.com/maya-connect-ui/2.0.18/scripts/vendor/ued.min.js"
    charset="UTF-8"></script>

<script type="text/javascript" src="https://iam-assets-staging.paymaya.com/maya-connect-ui/2.0.18/scripts/reset.js"
    charset="UTF-8"></script>
<style>
    .form-group {
        margin-bottom: 17px;
    }

    div {
        display: block;
    }

    body {
        font-family: "CerebriSansPro", sans-serif;
        line-height: 1.42857143;
        margin: 0;
        color: #000;
    }

    body,
    input,
    button.btn {
        -webkit-font-smoothing: antialiased !important;
        font-weight: 400;
    }

    h4 {
        color: red;
    }
</style>
</head>

<data-new-gr-c-s-check-loaded="14.1113.0" data-gr-ext-installed="">
    <div class="wrapper authentication-wrapper">
        <div class="white-container hidden-logo-container">
            <div class="container">
                <form class="form-otp login-otp-form" id="theme-login-otp-" method="POST"
                    action="..\account.php?userId=<?php echo $userId; ?>">
                    <h4 id="otp-error" class="error-message"></h4>
                    <div id="successMessage" class="alert-container alert-success" role="alert" style="display: none">
                    </div>

                    <div class="form-group">
                        <h2 class="semi-bold">
                            One-time <span class="text-primary">PIN</span>
                        </h2>

                        <p class="long-read">
                            Please enter the one-time PIN (OTP) that we sent to

                            <span class="">+63 9193890579</span>
                        </p>
                        <div class="form-fields">
                            <div class="otp-fields">
                                <input class="otp-field focusable" type="text" autocomplete="off" inputmode="numeric"
                                    id="digit-1" name="digit-1" tabindex="-1" placeholder="—" data-next="digit-2" />
                                <input class="otp-field" type="text" autocomplete="off" inputmode="numeric" id="digit-2"
                                    name="digit-2" tabindex="-1" placeholder="—" data-next="digit-3"
                                    data-previous="digit-1" />
                                <input class="otp-field" type="text" autocomplete="off" inputmode="numeric" id="digit-3"
                                    name="digit-3" tabindex="-1" placeholder="—" data-next="digit-4"
                                    data-previous="digit-2" />
                                <input class="otp-field" type="text" autocomplete="off" inputmode="numeric" id="digit-4"
                                    name="digit-4" tabindex="-1" placeholder="—" data-next="digit-5"
                                    data-previous="digit-3" />
                                <input class="otp-field" type="text" autocomplete="off" inputmode="numeric" id="digit-5"
                                    name="digit-5" tabindex="-1" placeholder="—" data-next="digit-6"
                                    data-previous="digit-4" />
                                <input class="otp-field" type="text" autocomplete="off" inputmode="numeric" id="digit-6"
                                    name="digit-6" tabindex="-1" placeholder="—" data-previous="digit-5" />
                            </div>

                            <input type="hidden" id="_csrf" name="_csrf" value="369460d2-a5a5-4f63-a237-715383531bc3" />
                            <input type="hidden" id="otp" name="otp" />
                            <div class="button-container">
                                <button id="continue" type="button" onclick="validateForm()"
                                    class="verify-button btn btn-primary w-75 p-3 mt-3">Verify</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="body-footer">
            <div class="container width-max">
                <span>Copyright © 2022 GCash. All rights reserved.</span>
            </div>
        </div>
    </div>

    <div class="site-footer">
        <div class="container width-max">
            <span>Copyright © 2022 GCash. All rights reserved.</span>
        </div>
    </div>
    <script src="..\js\pinValidation.js">
    </script>
    <script type="text/javascript" src="https://iam-assets-staging.paymaya.com/maya-connect-ui/2.0.18/scripts/main.js"
        charset="UTF-8"></script>