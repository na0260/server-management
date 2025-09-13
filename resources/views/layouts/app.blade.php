<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Cloud Server Manager' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

<nav class="bg-white shadow-md">
    <div class="container mx-auto flex justify-between items-center p-4">
        <a href="/" class="font-bold text-xl text-indigo-600">CloudManager</a>
        <div id="navLinks" class="flex gap-4 items-center">
            <a href="/login" id="loginLink" class="text-indigo-600 hover:underline">Login</a>
            <a href="/register" id="registerLink" class="text-green-600 hover:underline">Register</a>
            <a href="/servers" id="serversLink" class="hidden text-indigo-600 hover:underline">Servers</a>
            <button id="logoutBtn" class="hidden bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Logout</button>
        </div>
    </div>
</nav>

<main class="flex-1 container mx-auto p-4">
    @yield('content')
</main>

<script>
    function renderNav() {
        const token = localStorage.getItem('token');
        const login = document.getElementById('loginLink');
        const register = document.getElementById('registerLink');
        const servers = document.getElementById('serversLink');
        const logout = document.getElementById('logoutBtn');

        if (token) {
            login.style.display = 'none';
            register.style.display = 'none';
            servers.style.display = 'inline-block';
            logout.style.display = 'inline-block';
        } else {
            login.style.display = 'inline-block';
            register.style.display = 'inline-block';
            servers.style.display = 'none';
            logout.style.display = 'none';
        }
    }

    document.addEventListener('DOMContentLoaded', renderNav);

    document.getElementById('logoutBtn')?.addEventListener('click', async () => {
        await fetch('/api/logout', {
            method: 'POST',
            headers: { 'Authorization': 'Bearer ' + localStorage.getItem('token') }
        });
        localStorage.removeItem('token');
        window.location.href = '/login';
    });
</script>
</body>
</html>
