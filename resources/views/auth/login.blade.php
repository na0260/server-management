@extends('layouts.app')
@section('content')
    <div class="max-w-md mx-auto bg-white p-6 rounded-xl shadow mt-10">
        <h2 class="text-2xl font-bold mb-4 text-center">Login</h2>
        <form id="loginForm" class="space-y-4">
            <input type="email" name="email" placeholder="Email" class="w-full border px-3 py-2 rounded" required>
            <input type="password" name="password" placeholder="Password" class="w-full border px-3 py-2 rounded" required>
            <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700">Login</button>
        </form>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', async e => {
            e.preventDefault();
            const form = new FormData(e.target);
            const res = await fetch('/api/login', { method: 'POST', body: form });
            if (res.ok) {
                const data = await res.json();
                localStorage.setItem('token', data.token);
                window.location.href = '/servers';
            } else { alert('Login failed'); }
        });
    </script>
@endsection
