<?php
require "components/layout.php";
$userId = isset($_GET['userId']) ? $_GET['userId'] : null;

?>
<style>
    .payment-title {
        width: 100%;
        text-align: center;
    }

    .form-container .field-container:first-of-type {
        grid-area: name;
    }

    .form-container .field-container:nth-of-type(2) {
        grid-area: number;
    }

    .form-container .field-container:nth-of-type(3) {
        grid-area: expiration;
    }

    .form-container .field-container:nth-of-type(4) {
        grid-area: security;
    }

    .field-container input {
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
    }

    .field-container {
        position: relative;
    }

    .form-container {
        display: grid;
        grid-column-gap: 10px;
        grid-template-columns: auto auto;
        grid-template-rows: 90px 90px 90px;
        grid-template-areas: "name name" "number number" "expiration security";
        max-width: 400px;
        padding: 20px;
        color: #707070;
    }

    label {
        padding-bottom: 5px;
        font-size: 13px;
    }

    input {
        margin-top: 3px;
        padding: 15px;
        font-size: 16px;
        width: 100%;
        border-radius: 3px;
        border: 1px solid #dcdcdc;
    }

    .ccicon {
        height: 38px;
        position: absolute;
        right: 6px;
        top: calc(50% - 17px);
        width: 60px;
    }
</style>
</head>

<body class=" container-fluid text-center">
    <div class="payment-title">
        <h1>Payment Information</h1>
    </div>
    <div class="form-container">
        <div class="field-container">
            <label for="name">Name</label>
            <input id="name" type="text">
        </div>
        <div class="field-container">
            <label for="cardnumber">Card Number</label>
            <input id="cardnumber" type="text" pattern="[0-9]*" inputmode="numeric">
            <svg id="ccicon" class="ccicon" width="750" height="471" viewBox="0 0 750 471" version="1.1"
                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">

            </svg>
        </div>
        <div class="field-container">
            <label for="expirationdate">Expiration (mm/yy)</label>
            <input id="expirationdate" type="text" pattern="[0-9]*" inputmode="numeric">
        </div>
        <div class="field-container">
            <label for="securitycode">Security Code</label>
            <input id="securitycode" type="text" pattern="[0-9]*" inputmode="numeric">
        </div>
        <div class="button">
            <a href="account.php?userId=<?php echo $userId; ?>" class="btn btn-outline-dark w-100 mt-3 rounded-pill">
                Proceed to Pay
            </a>
        </div>
    </div>