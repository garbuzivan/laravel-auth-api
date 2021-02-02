<!DOCTYPE html>
<html>
<head>
    <title>{{ $data['title'] ?? null }}</title>
</head>
<body>
<h1>{{ $data['title'] ?? null }}</h1>
<p>{!! $data['body'] ?? null !!}</p>
</body>
</html>
