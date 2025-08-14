<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Role;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class CreateUserController extends Controller
{
    public function create()
    {
        $breadcrumb = [
            ['title' => 'Dashboard', 'url' => route('dashboard')],
            ['title' => 'User Management', 'url' => route('role.index')],
            ['title' => 'Create User', 'url' => route('user.create')],
        ];
        
        
        $roles = Role::all(); 
        return view('user.create', compact('roles', 'breadcrumb'));
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role_id' => 'required|integer|exists:roles,id',
        ]);

        // Create the user
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'role_id' => $request->input('role_id'),
        ]);

        $user->email_verified_at = now();
        $user->save();

        return redirect()->route('user.create')->with('success', 'User created successfully.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        $file = $request->file('file');
        $data = \Maatwebsite\Excel\Facades\Excel::toArray([], $file);

        // Asumsi data di sheet pertama, baris pertama adalah header
        $rows = $data[0];
        $header = array_map('strtolower', $rows[0]);
        unset($rows[0]);

        foreach ($rows as $row) {
            $row = array_combine($header, $row);
            if (!empty($row['email']) && !empty($row['name']) && !empty($row['password']) && !empty($row['role_id'])) {
                // Cek email unik
                if (!User::where('email', $row['email'])->exists()) {
                    $user = User::create([
                        'name' => $row['name'],
                        'email' => $row['email'],
                        'password' => Hash::make($row['password']),
                        'role_id' => $row['role_id'],
                    ]);
                    $user->email_verified_at = now();
                    $user->save();
                }
            }
        }
        return redirect()->route('user.import_excel')->with('success', 'Import users from Excel berhasil!');
    }

    public function import_excel()
    {
        $breadcrumb = [
            ['title' => 'Dashboard', 'url' => route('dashboard')],
            ['title' => 'User Management', 'url' => route('role.index')],
            ['title' => 'Import User', 'url' => route('user.import_excel')],
        ];
        return view('user.import', compact('breadcrumb'));
    }

    public function index()
    {
        $breadcrumb = [
            ['title' => 'Dashboard', 'url' => route('dashboard')],
            ['title' => 'User Management', 'url' => route('role.index')],
        ];
        return view('user.index', compact('breadcrumb'));
    }

    public function getData()
    {
        $users = User::with('role')->get();

        return DataTables::of($users)
            ->addColumn('action', function ($user) {
                return view('user.partials.actions', compact('user'))->render();
            })
            ->make(true);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role_id' => 'required|integer|exists:roles,id',
        ]);

        // Update user data
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->role_id = $request->input('role_id');
        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }
        $user->save();

        return redirect()->route('user.index')->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('user.index')->with('success', 'User deleted successfully.');
    }
    
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('user.edit', compact('user', 'roles'));
    }
}
