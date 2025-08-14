<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Role;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;

class CreateUserController extends Controller
{
    public function create()
    {
        $roles = Role::all(); 
        return view('user.create', compact('roles'));
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
                if (!\App\User::where('email', $row['email'])->exists()) {
                    \App\User::create([
                        'name' => $row['name'],
                        'email' => $row['email'],
                        'password' => Hash::make($row['password']),
                        'role_id' => $row['role_id'],
                    ]);
                }
            }
        }
        return redirect()->route('user.import_excel')->with('success', 'Import users from Excel berhasil!');
    }

    public function import_excel()
    {
        return view('user.import');
    }
}
