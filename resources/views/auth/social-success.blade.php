<!DOCTYPE html>
<html>
<head>
    <title>Login Sukses</title>
    <script>
        window.opener.location.href = "{{ $redirectTo }}";
        window.close();
    </script>
</head>
<body>
    <p>Login berhasil. Menutup jendela...</p>
</body>
</html>
