<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Professor;
use App\Models\Alumne;
use App\Models\Empresari;
use Illuminate\Support\Facades\Hash;

class AdminUsersController extends Controller
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
            new Middleware('admin'),
        ];
    }

    public function index()
    {
        $users = User::with(['professor', 'alumne', 'empresari'])->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load(['professor', 'alumne', 'empresari', 'contracts']);
        return view('admin.users.show', compact('user'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:professor,alumne,empresari',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Create role relationship
        match($validated['role']) {
            'professor' => Professor::create(['user_id' => $user->id]),
            'alumne' => Alumne::create(['user_id' => $user->id]),
            'empresari' => Empresari::create(['user_id' => $user->id]),
        };

        return redirect()->route('admin.users.show', $user)->with('success', 'Usuari creat correctament');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update($validated);

        return redirect()->route('admin.users.show', $user)->with('success', 'Usuari actualitzat');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Usuari eliminat');
    }

    public function importForm()
    {
        return view('admin.users.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt|max:5120',
        ]);

        $file = $request->file('file');
        $path = $file->getRealPath();
        $data = array_map('str_getcsv', file($path));
        
        $count = 0;
        foreach ($data as $index => $row) {
            if ($index === 0) continue; // Skip header
            if (count($row) < 2 || empty($row[0]) || empty($row[1])) continue;

            $user = User::updateOrCreate(
                ['email' => $row[1]],
                [
                    'name' => $row[0],
                    'email' => $row[1],
                    'password' => Hash::make($row[2] ?? 'password123'),
                ]
            );

            // Create role if specified
            $role = strtolower($row[3] ?? 'professor');
            if ($role === 'professor' && !$user->professor) {
                Professor::create(['user_id' => $user->id]);
            } elseif ($role === 'alumne' && !$user->alumne) {
                Alumne::create(['user_id' => $user->id]);
            } elseif ($role === 'empresari' && !$user->empresari) {
                Empresari::create(['user_id' => $user->id]);
            }

            $count++;
        }

        return redirect()->route('admin.users.index')->with('success', "Importats $count usuaris");
    }
}
