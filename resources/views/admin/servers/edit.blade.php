@extends('layouts.app')
@section('content')
    <div class="max-w-lg mx-auto bg-white p-6 rounded-xl shadow mt-6">
        <h2 class="text-2xl font-bold mb-4">Edit Server</h2>
        <form id="editServerForm" class="space-y-4">
            <input type="text" name="name" placeholder="Server Name" class="w-full border px-3 py-2 rounded" required>
            <input type="text" name="ip_address" placeholder="IP Address" class="w-full border px-3 py-2 rounded" required>
            <select name="provider" class="w-full border px-3 py-2 rounded" required>
                <option value="">Select Provider</option>
                <option value="aws">AWS</option>
                <option value="digitalocean">DigitalOcean</option>
                <option value="vultr">Vultr</option>
                <option value="other">Other</option>
            </select>
            <select name="status" class="w-full border px-3 py-2 rounded" required>
                <option value="">Select Status</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
                <option value="maintenance">Maintenance</option>
            </select>
            <input type="number" name="cpu_cores" placeholder="CPU Cores" class="w-full border px-3 py-2 rounded" required>
            <input type="number" name="ram_mb" placeholder="RAM (MB)" class="w-full border px-3 py-2 rounded" required>
            <input type="number" name="storage_gb" placeholder="Storage (GB)" class="w-full border px-3 py-2 rounded" required>
            <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700">Update Server</button>
        </form>
    </div>

    <script>
        const serverId = '{{ $serverId }}';

        async function loadServer() {
            const res = await fetch(`/api/servers/${serverId}`, {
                headers: { 'Authorization': 'Bearer ' + localStorage.getItem('token') }
            });
            if(res.ok){
                const s = await res.json();
                document.querySelector('input[name="name"]').value = s.name;
                document.querySelector('input[name="ip_address"]').value = s.ip_address;
                document.querySelector('select[name="provider"]').value = s.provider;
                document.querySelector('select[name="status"]').value = s.status;
                document.querySelector('input[name="cpu_cores"]').value = s.cpu_cores;
                document.querySelector('input[name="ram_mb"]').value = s.ram_mb;
                document.querySelector('input[name="storage_gb"]').value = s.storage_gb;
            } else {
                alert('Failed to load server');
            }
        }

        document.getElementById('editServerForm').addEventListener('submit', async e => {
            e.preventDefault();
            const form = new FormData(e.target);
            const obj = Object.fromEntries(form.entries());

            const res = await fetch(`/api/servers/${serverId}`, {
                method: 'PUT',
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('token'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(obj)
            });
            if(res.ok){
                alert('Server updated successfully!');
                window.location.href = '/servers';
            } else {
                const error = await res.json();
                alert(error.error || 'Failed to update server');
            }
        });

        loadServer();
    </script>
@endsection
