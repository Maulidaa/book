<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\RequestUpdateRole;
use Illuminate\Http\Request;
use Symfony\Component\VarDumper\Cloner\Data;
use Yajra\DataTables\DataTables;

class UpdateRoleController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request
        $this->validate($request, [
            'role_id' => 'required|integer|exists:roles,id',
        ]);

        $user = auth()->user();

        // Find the request update role by ID
        $requestUpdateRole = RequestUpdateRole::create([
            'user_id' => $user->id,
            'role_id' => $request->role_id,
            'status' => 'pending',
        ]);

    }

    public function index()
    {
        return view('user.index');
    }

    public function getData()
    {
        $requests = RequestUpdateRole::with('user', 'role')->get();

        return DataTables::of($requests)
            ->addColumn('action', function ($requestUpdateRole) {
                return view('user.partials.actions', compact('requestUpdateRole'))->render();
            })
            ->make(true);
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();

        if ($user->role_id != 1) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        } else{
            // Validate the request
        $this->validate($request, [
            'status' => 'required|in:approved,rejected',
        ]);

        $requestUpdateRole = RequestUpdateRole::findOrFail($id);
        $requestUpdateRole->update([
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Role update request has been ' . $request->status);
        }        
    }
}
