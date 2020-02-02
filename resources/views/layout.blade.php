<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Little Mnemo - @yield('title')</title>
    <link rel="stylesheet" href="/css/app.css">
    <link href="https://fonts.googleapis.com/css?family=Inconsolata&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet">
</head>
<body>
    <div id="app">
    @yield('content')
    </div>
    <script src="/js/app.js"></script>
</body>
</html>
