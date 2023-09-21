<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
	<p>Click vào link bên dưới để xác nhận</p>
	<a href="{{route('newsletter-verify', $subscriber->verified_token)}}">Active</a>
</body>
</html>
