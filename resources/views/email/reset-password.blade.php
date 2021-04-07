<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Đặt lại mật khẩu</title>
</head>
<body>
	<h2>Thông báo từ {{ config('app.name') }}</h2>
	<p>Link đặt lại mật khẩu: <a href="{{ route('password.resetform', $token) }}">Click</a></p>
</body>
</html>