<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\RequestUpdateRole;
use App\User;
use Illuminate\Http\Request;
use Symfony\Component\VarDumper\Cloner\Data;
use Yajra\DataTables\DataTables;
use App\Role;

class UpdateRoleController extends Controller
{
    public function create()
    {
        $breadcrumb = [
                ['title' => 'Dashboard', 'url' => route('dashboard')],
                ['title' => 'Profile', 'url' => route('profile')],
                ['title' => 'Request Role Change', 'url' => route('profile.index')],
            ];
        $roles = Role::all();
        return view('auth.request_role', compact('roles', 'breadcrumb'));
    }

    public function store(Request $request)
    {
        // Validate the request
        $this->validate($request, [
            'role_id' => 'required|integer|exists:roles,id',
        ]);

        $user = auth()->user();

        // Cek apakah sudah ada request yang belum selesai
        $existing = \App\RequestUpdateRole::where('user_id', $user->id)
            ->where('status', 'pending')
            ->first();

        if ($existing) {
            return redirect()->back()->with('success', 'You have requested a role change. Please wait for the administrator’s approval.');
        }

        // Buat request baru
        RequestUpdateRole::create([
            'user_id' => $user->id,
            'role_id' => $request->role_id,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Role change request has been submitted. Please wait for admin approval.');
    }

    public function index()
    {
        $breadcrumb = [
            ['title' => 'Dashboard', 'url' => route('dashboard')],
            ['title' => 'User Management', 'url' => route('role.index')],
        ];
        return view('user.role', compact('breadcrumb'));
    }

    public function getData()
    {
        $requests = RequestUpdateRole::with('user', 'role')->get();

        return DataTables::of($requests)
            ->addColumn('action', function ($requestUpdateRole) {
                return view('user.partials.actions-role', compact('requestUpdateRole'))->render();
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

        $user_id = $requestUpdateRole->user_id;

        $user = User::findOrFail($user_id);
        $user->role_id = $request->status == 'approved' ? $requestUpdateRole->role_id : 2;
        $user->save();

        return redirect()->back()->with('success', 'Role update request has been ' . $request->status);
        }        
    }
}
