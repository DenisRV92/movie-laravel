<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: "Arial", sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .sidebar {
            width: 200px;
            background-color: #f8f9fa;
            height: 100vh;
            padding: 20px 0;
        }

        .sidebar a {
            display: block;
            padding: 10px;
            color: #343a40;
            text-decoration: none;
            margin-bottom: 10px;
        }

        .sidebar a:hover {
            background-color: #343a40;
            color: #f8f9fa;
        }

        .main-content {
            padding: 20px;
            flex-grow: 1;
        }
    </style>
</head>
<body>
<div class="sidebar">
    <a href="{{ route('my_movies') }}">Мои фильмы</a>
    <a href="{{ route('my_reviews') }}">Мои отзывы</a>
    <!-- Append more links here -->
</div>
<div class="main-content">
    <!-- This is where your page content goes -->
    @yield('main-content')
</div>
</body>
</html>
