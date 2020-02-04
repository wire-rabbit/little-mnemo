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
    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1>Major System Word Lookup</h1>
            <p class="lead">Enter a number to fetch a list of words that represent it using the <a href="https://en.wikipedia.org/wiki/Mnemonic_major_system" target="_blank">Major System</a>.</p>
        </div>
    </div>
    <div id="app">
    @yield('content')
    </div>
    <script src="/js/app.js"></script>
</body>
</html>
