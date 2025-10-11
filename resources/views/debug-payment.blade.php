<!DOCTYPE html>
<html>

<head>
    <title>Debug Mayar Payment</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <h1>Debug Mayar Payment</h1>
    <button id="test-payment">Test Payment</button>
    <div id="result"></div>

    <script>
        document.getElementById('test-payment').addEventListener('click', function() {
            console.log('Button clicked');

            fetch('/tenant/payment/create', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        meter_id: 1,
                        payment_method: 'mayar'
                    })
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    return response.text(); // Get as text first
                })
                .then(text => {
                    console.log('Response text:', text);
                    document.getElementById('result').innerHTML = text;

                    try {
                        const data = JSON.parse(text);
                        console.log('Parsed data:', data);
                    } catch (e) {
                        console.log('Not JSON response');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('result').innerHTML = 'Error: ' + error.message;
                });
        });
    </script>
</body>

</html>
