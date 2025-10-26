# Mayar Payment Gateway Setup

## Mayar API Configuration

Aplikasi ini menggunakan Mayar sebagai payment gateway utama menggantikan Midtrans.

### 1. Environment Variables

Tambahkan konfigurasi berikut ke file `.env`:

```env
# Mayar Configuration
MAYAR_API_KEY=eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWV9.ppid4p7HLGtlNgCNvl8KnkCGMKhN_jyEaFCvcMJggKHT4O7KVoxQ7VzagGfCRr5fWzQRtDw8cH5Y6qKf3FUK_n-1vD0VvR2q-X3q6u0JhEOvQvKwq5RWVZ-Y6u3f9VzJ_Q
MAYAR_WEBHOOK_TOKEN=2614b16cd03b270989abe8c0fdf5e3be57e34bb37d65f370f9de155cfd013c16b3a338db777e446f41f3f25af86ac0d89dd472f2e365c2531d9e68560338751f
MAYAR_SANDBOX=true
```

### 2. Webhook URL untuk Dashboard Mayar

Saat konfigurasi di dashboard Mayar, gunakan URL berikut:

**Production URL:**

```
Webhook URL: https://yourdomain.com/mayar/webhook
```

**Development/Testing dengan ngrok:**

```
Webhook URL: https://your-ngrok-id.ngrok.io/mayar/webhook
```

### 3. API Endpoints

Mayar menggunakan dua environment berbeda:

-   **Sandbox:** `https://api.mayar.club/hl/v1`
-   **Production:** `https://api.mayar.id/hl/v1`

Environment dapat diatur melalui admin dashboard atau environment variable `MAYAR_SANDBOX`.

## API Endpoints

### Create Payment

```
POST /mayar/create-payment
Authorization: Bearer {token}
Content-Type: application/json
```

Body:

```json
{
    "room_id": 1,
    "amount": 500000,
    "description": "Pembayaran Kos Bulan Januari 2024"
}
```

Response:

```json
{
    "success": true,
    "data": {
        "payment_id": "mayar_12345",
        "payment_link": "https://app.mayar.id/payment/abc123",
        "amount": 500000,
        "status": "pending"
    }
}
```

### Payment Status Check

```
GET /mayar/payment-status/{paymentId}
Authorization: Bearer {token}
```

Response:

```json
{
    "success": true,
    "data": {
        "payment_id": "mayar_12345",
        "status": "paid|pending|failed|expired",
        "amount": 500000,
        "paid_at": "2024-01-15T10:30:00Z"
    }
}
```

### Webhook Callback (Mayar webhook)

```
POST /mayar/webhook
```

Header:

-   `X-Webhook-Token`: Token untuk validasi webhook

Body (otomatis dari Mayar):

```json
{
    "payment_id": "mayar_12345",
    "status": "paid|failed|expired",
    "amount": 500000,
    "paid_at": "2024-01-15T10:30:00Z"
}
```

### Redirect URLs

Setelah pembayaran, user akan di-redirect ke:

```
GET /payment/success?payment_id=mayar_12345
GET /payment/pending?payment_id=mayar_12345
GET /payment/failed?payment_id=mayar_12345
```

## Payment Flow

1. **Frontend:** Call `/mayar/create-payment` untuk mendapat payment link
2. **Frontend:** Redirect user ke payment link Mayar
3. **User:** Melakukan pembayaran di Mayar
4. **Mayar:** Send webhook notification ke `/mayar/webhook`
5. **Backend:** Update payment status di database
6. **Mayar:** Redirect user ke success/failed page

## Configuration

### Admin Dashboard

1. Login ke admin dashboard
2. Masuk ke **Global Settings** → **Payment Gateway**
3. Pastikan **Payment Type** sudah diatur ke **Mayar**
4. Atur **Mayar API Key** dengan token yang valid
5. Atur **Webhook Token** untuk validasi webhook
6. Atur **Redirect URL** untuk redirect setelah pembayaran
7. Pilih **Environment** (Sandbox/Production)

### Database Fields

Tabel `global_settings` memiliki field:

-   `mayar_api_key`: Bearer token untuk API Mayar
-   `mayar_webhook_token`: Token untuk validasi webhook
-   `mayar_redirect_url`: URL redirect setelah pembayaran
-   `mayar_sandbox`: Boolean untuk environment (1=sandbox, 0=production)
-   `payment_type`: Diatur ke 'mayar'

Tabel `transactions` memiliki field:

-   `mayar_payment_id`: ID pembayaran dari Mayar
-   `mayar_link`: Link pembayaran yang digenerate Mayar

## Testing

### Local Development

1. Install ngrok dan jalankan: `ngrok http 80`
2. Update webhook URL di dashboard Mayar dengan ngrok URL
3. Test payment flow dengan environment sandbox

### Production

1. Pastikan domain sudah SSL/HTTPS
2. Update webhook URL di dashboard Mayar
3. Ganti environment ke production
4. Test dengan nominal kecil terlebih dahulu

## Troubleshooting

### Common Issues

1. **Webhook tidak terima notifikasi:**

    - Cek webhook URL di dashboard Mayar
    - Pastikan webhook token sudah benar
    - Cek log aplikasi untuk error

2. **Payment link tidak muncul:**

    - Cek API key Mayar
    - Pastikan internet connection
    - Cek log untuk API response error

3. **Redirect tidak bekerja:**
    - Cek redirect URL setting
    - Pastikan URL accessible dari Mayar

### Logs

Semua aktivitas Mayar akan dicatat di log aplikasi dengan prefix:

-   `[MAYAR]` untuk payment operations
-   `[MAYAR_WEBHOOK]` untuk webhook notifications

```bash
# Check logs
tail -f storage/logs/laravel.log | grep MAYAR
```
