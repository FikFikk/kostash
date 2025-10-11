<!DOCTYPE html>
<html>

<head>
    <title>Test Payment Final</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 50px;
            background: #f5f5f5;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .test-button {
            background: #28a745;
            color: white;
            border: none;
            padding: 15px 30px;
            font-size: 18px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            margin: 10px 0;
        }

        .test-button:hover {
            background: #218838;
        }

        .test-button:disabled {
            background: #6c757d;
            cursor: not-allowed;
        }

        .log {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
            max-height: 300px;
            overflow-y: auto;
            font-family: monospace;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Final Payment Test</h1>
        <p>Test semua fungsi payment dengan simple approach</p>

        <button class="test-button" onclick="testDirectPayment()">
            🚀 Test Direct Payment
        </button>

        <button class="test-button" onclick="testMeterPayment()">
            💰 Test Meter Payment (ID: 1)
        </button>

        <button class="test-button" onclick="clearLog()">
            🧹 Clear Log
        </button>

        <div class="log" id="log">
            <strong>Console Log:</strong><br>
            Ready to test...
        </div>
    </div>

    <script>
        function log(message) {
            const logDiv = document.getElementById('log');
            const time = new Date().toLocaleTimeString();
            logDiv.innerHTML += `<br>[${time}] ${message}`;
            logDiv.scrollTop = logDiv.scrollHeight;
        }

        function clearLog() {
            document.getElementById('log').innerHTML = '<strong>Console Log:</strong><br>Ready to test...';
        }

        function testDirectPayment() {
            log('🚀 Starting direct payment test...');

            const data = {
                meter_id: 1,
                payment_method: 'mayar'
            };

            log('📤 Sending data: ' + JSON.stringify(data));

            fetch('/test-mayar-direct', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => {
                    log(`📥 Response status: ${response.status}`);
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    log('✅ Success response: ' + JSON.stringify(data, null, 2));

                    if (data.error) {
                        log('❌ Error: ' + data.error);
                        return;
                    }

                    if (data.payment_url) {
                        log('🔗 Payment URL found: ' + data.payment_url);
                        log('🎯 Ready to redirect!');
                    } else {
                        log('❌ No payment URL in response');
                    }
                })
                .catch(error => {
                    log('💥 Error: ' + error.message);
                    console.error('Payment error:', error);
                });
        }

        function testMeterPayment() {
            log('💰 Testing meter payment...');

            // Simulate the real payment function
            const button = event.target;
            const originalText = button.innerHTML;

            button.disabled = true;
            button.innerHTML = '⏳ Processing...';

            const data = {
                meter_id: 1,
                payment_method: 'mayar'
            };

            log('📤 Meter payment data: ' + JSON.stringify(data));

            fetch('/test-mayar-direct', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => {
                    log(`📥 Meter payment response: ${response.status}`);
                    return response.json();
                })
                .then(data => {
                    log('✅ Meter payment success: ' + JSON.stringify(data, null, 2));

                    if (data.payment_url) {
                        log('🎯 Would redirect to: ' + data.payment_url);
                        // window.location.href = data.payment_url; // Uncomment to actually redirect
                    }
                })
                .catch(error => {
                    log('💥 Meter payment error: ' + error.message);
                })
                .finally(() => {
                    button.disabled = false;
                    button.innerHTML = originalText;
                });
        }

        // Log initial state
        log('🌟 Test page loaded successfully');
        log('🔑 CSRF token available: ' + (document.querySelector('meta[name="csrf-token"]') ? 'YES' : 'NO'));
    </script>
</body>

</html>
