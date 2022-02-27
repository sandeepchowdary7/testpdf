<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>RSS Feed</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />
</head>
<body>

<div class="text-center mb-3">
    <h2>{{ $rss_feed['title'] }}</h2>
    <img src="{{ $rss_feed['url'] ?? '' }}" alt="{{ $rss_feed['title'] ?? '' }}" width="{{ $rss_feed['width'] ?? '' }}" height="{{ $rss_feed['height'] ?? '' }}"/>
    <h4><a href="{{ $rss_feed['link'] ?? '' }}" target="_blank">Read More....</a> </h4>
</div>
<script src="{{ asset('js/app.js') }}" type="text/js"></script>
</body>
</html>
