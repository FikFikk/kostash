@extends('dashboard.tenants.layouts.app')

@section('title', 'Test Payment')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h1>Test Mayar Payment</h1>
                <button id="simple-pay-btn" class="btn btn-primary">Test Bayar Sederhana</button>
                <div id="result" class="mt-3"></div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('simple-pay-btn');
            const result = document.getElementById('result');

            btn.addEventListener('click', function() {
                console.log('Button clicked!');
                result.innerHTML = 'Processing...';
                btn.disabled = true;

                // Test with POST request
                fetch('/test-mayar-direct', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            test: true
                        })
                    })
                    .then(response => {
                        console.log('Response status:', response.status);
                        return response.text();
                    })
                    .then(text => {
                        console.log('Response text:', text);
                        result.innerHTML = `<pre>${text}</pre>`;

                        try {
                            const data = JSON.parse(text);
                            if (data.payment_url) {
                                result.innerHTML +=
                                    `<br><a href="${data.payment_url}" target="_blank" class="btn btn-success">Open Payment Page</a>`;
                            }
                        } catch (e) {
                            console.log('Response is not JSON');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        result.innerHTML = `Error: ${error.message}`;
                    })
                    .finally(() => {
                        btn.disabled = false;
                    });
            });
        });
    </script>
@endsection
