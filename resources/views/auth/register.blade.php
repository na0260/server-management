@extends('layouts.app')
@section('content')
    <div class="max-w-md mx-auto bg-white p-6 rounded-xl shadow mt-10">
        <h2 class="text-2xl font-bold mb-4 text-center">Register</h2>
        <form id="registerForm" class="space-y-4">
            <input type="text" name="name" placeholder="Name" class="w-full border px-3 py-2 rounded" required>
            <input type="email" name="email" placeholder="Email" class="w-full border px-3 py-2 rounded" required>
            <input type="password" name="password" placeholder="Password" class="w-full border px-3 py-2 rounded" required>
            <input type="password" name="password_confirmation" placeholder="Confirm Password" class="w-full border px-3 py-2 rounded" required>
            <button type="submit" class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700">Register</button>
        </form>
        <p class="text-sm mt-4 text-center">Already have an account? <a href="/login" class="text-indigo-600">Login</a></p>
    </div>

    <script>
        document.getElementById('registerForm').addEventListener('submit', async e => {
            e.preventDefault();
            const form = new FormData(e.target);
            const res = await fetch('/api/register', { method: 'POST', body: form });
            if(res.ok){
                const data = await res.json();
                localStorage.setItem('token', data.token);
                window.location.href = '/servers';
            } else {
                const error = await res.json();
                alert(error.message || 'Registration failed');
            }
        });
    </script>
@endsection
