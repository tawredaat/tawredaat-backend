<!DOCTYPE html>
<html lang="english">

<head>
    <title>Geidea</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
</head>

<body class="">
    <div class="loading">
    </div>
    <main class="home-holder">
        <div class="container">
            <div class="home-content">
                <h1>Hellow, Geidea</h1>
                <button onclick="payNow()">Pay Now</button>
            </div>
            <div id="hpp-div-placeholder">

            </div>
        </div>
    </main>
    <script src="https://www.merchant.geidea.net/hpp/geideapay.min.js"></script>
    <script>
        var merchantKey = "c86f1b4e-b08a-4e0d-8702-c7c832b3f3d6";

        function onSuccess() {
            return {
                "responseCode": "200",
                "responseMessage": "Your payment at tawredaat was successful.",
                "detailedResponseCode": "string",
                "detailedResponseMessage": "string"
            }
        }

        function onError() {
            return {
                "responseCode": "100",
                "responseMessage": "Your payment at tawredaat was failed.",
                "detailedResponseCode": "string",
                "detailedResponseMessage": "string"
            }
        }

        function onCancel() {
            return {
                "responseCode": "010",
                "responseMessage": "Your payment at tawredaat was cancelled.",
                "detailedResponseCode": "string",
                "detailedResponseMessage": "string"
            }
        }

        function payNow() {
            const payment = new GeideaApi("c86f1b4e-b08a-4e0d-8702-c7c832b3f3d6", onSuccess, onError, onCancel);
            payment.configurePayment({
                "amount": 1500,
                "currency": "EGP",
                "callbackUrl": "https://merchant.site/callback",
                "email": {
                    "email": "customer@email.com",
                    "showEmail": true
                }
            });
            payment.startPayment();
        }
    </script>
</body>

</html>
