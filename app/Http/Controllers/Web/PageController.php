<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function login() { return view('auth.login'); }
    public function register() { return view('auth.register'); }

    public function servers() { return view('admin.servers.index'); }
    public function createServer() { return view('admin.servers.create'); }
    public function editServer($id) { return view('admin.servers.edit', ['serverId' => $id]); }
}
