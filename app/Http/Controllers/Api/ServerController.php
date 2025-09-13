<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServerRequest;
use App\Http\Requests\UpdateServerRequest;
use App\Models\Server;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $query = Server::query();

            if ($request->filled('provider')) {
                $query->where('provider', $request->provider);
            }
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }
            if ($request->filled('search')) {
                $s = $request->search;
                $query->where(function ($q) use ($s) {
                    $q->where('name', 'like', "%$s%")
                        ->orWhere('ip_address', 'like', "%$s%");
                });
            }

            $sort = $request->get('sort', 'created_at');
            $dir = $request->get('dir', 'desc');
            $query->orderBy($sort, $dir);

            return $query->paginate($request->get('per_page', 20));
        } catch (\Exception $exception) {
            return response()->json([
                'message' => 'Failed to retrieve servers',
                'error' => $exception->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServerRequest $request)
    {
        try {
            $server = Server::create($request->validated());
            return response()->json($server, 201);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => 'Failed to create server',
                'error' => $exception->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Server $server)
    {
        return response()->json($server);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServerRequest $request, Server $server)
    {
        try {
            $data = $request->validated();

            $updated = DB::table('servers')
                ->where('id', $server->id)
                ->where('version', $server->version)
                ->update(array_merge(
                    $data,
                    [
                        'version' => $server->version + 1,
                        'updated_at' => now(),
                    ]
                ));

            if (!$updated) {
                // Conflict: another process already updated this record
                return response()->json([
                    'error' => 'Conflict',
                    'message' => 'Version mismatch. Resource was updated by another process.',
                    'current' => Server::find($server->id)
                ], 409);
            }

            return response()->json(Server::find($server->id));
        } catch (\Exception $exception) {
            return response()->json([
                'message' => 'Failed to update server',
                'error' => $exception->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Server $server)
    {
        try {
            $server->delete();
            return response()->json(null, 204);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => 'Failed to delete server',
                'error' => $exception->getMessage()
            ], 500);
        }
    }

    public function updateStatus(Request $request, Server $server)
    {
        try {
            $request->validate(['status' => 'required|in:active,inactive,maintenance']);
            $server->status = $request->status;
            $server->save();
            return $server;
        } catch (\Exception $exception) {
            return response()->json([
                'message' => 'Failed to update server status',
                'error' => $exception->getMessage()
            ], 500);
        }
    }
}
