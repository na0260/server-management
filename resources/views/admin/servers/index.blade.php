@extends('layouts.app')
@section('content')
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold">Servers</h2>
        <a href="/servers/create" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">+ Add Server</a>
    </div>

    <div class="flex gap-2 mb-4">
        <input id="searchInput" type="text" placeholder="Search by name/IP" class="border px-3 py-2 rounded flex-1">
        <select id="providerFilter" class="border px-3 py-2 rounded">
            <option value="">All Providers</option>
            <option value="aws">AWS</option>
            <option value="digitalocean">DigitalOcean</option>
            <option value="vultr">Vultr</option>
            <option value="other">Other</option>
        </select>
        <button id="filterBtn" class="bg-gray-600 text-white px-4 py-2 rounded">Filter</button>
    </div>

    <div id="serverList" class="grid gap-4 md:grid-cols-3"></div>

    <script>
        async function fetchServers(params="") {
            let res = await fetch("/api/servers?" + params, { headers: { 'Authorization': 'Bearer ' + localStorage.getItem('token') } });
            let data = await res.json();
            const list = document.getElementById("serverList");
            list.innerHTML = "";
            data.data.forEach(s => {
                list.innerHTML += `
            <div class="bg-white p-4 rounded shadow">
                <h3 class="font-bold">${s.name}</h3>
                <p class="text-sm">Provider: ${s.provider}</p>
                <p class="text-sm">IP: ${s.ip_address}</p>
                <p class="text-sm">Status: ${s.status}</p>
                <p class="text-sm">Version: ${s.version}</p>
                <div class="flex gap-2 mt-2">
                    <a href="/servers/${s.id}/edit" class="text-blue-600">Edit</a>
                    <button onclick="deleteServer(${s.id})" class="text-red-600">Delete</button>
                </div>
            </div>
        `;
            });
        }

        async function deleteServer(id) {
            if(!confirm("Delete this server?")) return;
            await fetch(`/api/servers/${id}`, { method: 'DELETE', headers: { 'Authorization': 'Bearer ' + localStorage.getItem('token') } });
            fetchServers();
        }

        document.getElementById('filterBtn').addEventListener('click', () => {
            const search = document.getElementById('searchInput').value;
            const provider = document.getElementById('providerFilter').value;
            fetchServers(`search=${search}&provider=${provider}`);
        });

        fetchServers();
    </script>
@endsection
