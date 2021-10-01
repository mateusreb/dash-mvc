<html>
  <head>
    <title>Buy cool new product</title>
    <script src="https://js.stripe.com/v3/"></script>
  </head>
  <body>
    <div id="paymentResponse"></div>
    <h2>PBLA</h2>
    <p>Price: <b>$9.00</b></p>
    <button class="btn btn-success btn-next" id="checkout-button">Checkout</button>
  </body>
  <script>
var buyBtn = document.getElementById('checkout-button');
var responseContainer = document.getElementById('paymentResponse');
    
// Create a Checkout Session with the selected product
var createCheckoutSession = function (stripe) {
    return fetch("/stripe-checkout-session", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            checkoutSession: 1,
        }),
    }).then(function (result) {
        return result.json();
    });
};
// Handle any errors returned from Checkout
var handleResult = function (result) {
    if (result.error) {
        responseContainer.innerHTML = '<p>'+result.error.message+'</p>';
    }
    buyBtn.disabled = false;
    buyBtn.textContent = 'Buy Now';
};

// Specify Stripe publishable key to initialize Stripe.js
var stripe = Stripe('pk_test_51HFHmtLZVrpu8S5YndJo8RQk03EqcNXMPpIckjKXclWLo90ws14dFYE72CxVLTWcyHL3sXSu7FG2zeBL0xKzCtwh00YUqTh1Ho');

buyBtn.addEventListener("click", function (evt) {
    buyBtn.disabled = true;
    buyBtn.textContent = 'Please wait...';
    
    createCheckoutSession().then(function (data) {
        if(data.sessionId){
            stripe.redirectToCheckout({
                sessionId: data.sessionId,
            }).then(handleResult);
        }else{
            handleResult(data);
        }
    });
});
</script>
</html>