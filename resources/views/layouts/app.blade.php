<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
        }

        .sidebar {
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            background-color: #343a40;
            color: #fff;
        }

        .sidebar a {
            color: #adb5bd;
            text-decoration: none;
            padding: 10px 20px;
            display: block;
        }

        .sidebar a:hover {
            background-color: #495057;
            color: #fff;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
        }

        .navbar {
            margin-left: 250px;
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar d-flex flex-column p-3">
        <h3 class="text-white">My Dashboard</h3>
        <hr class="text-secondary">
        <a href="{{ url('/') }}">Dashboard</a>
        <a href="{{ url('doctors') }}">Doctors</a>
        <a href="{{ url('patients') }}">Patients</a>
        <a href="#">Reports</a>
        <a href="#">Settings</a>
        <a href="#" class="mt-auto text-danger">Logout</a>
    </div>

    <!-- Top Navbar -->
    <nav class="navbar navbar-expand navbar-light bg-light shadow-sm px-4">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">Welcome, Admin</span>
        </div>
    </nav>

    <!-- Page Content -->
    <main class="content">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
