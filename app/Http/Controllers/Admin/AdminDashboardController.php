<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Empresa;
use App\Models\Jornada;
use App\Models\Professor;
use App\Models\Alumne;
use App\Models\Empresari;
use App\Models\Ra;
use App\Models\Contract;

class AdminDashboardController extends Controller
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
        $stats = [
            'total_users' => User::count(),
            'total_professors' => Professor::count(),
            'total_students' => Alumne::count(),
            'total_business_owners' => Empresari::count(),
            'total_companies' => Empresa::count(),
            'total_ras' => Ra::count(),
            'total_contracts' => Contract::count(),
            'total_jornades' => Jornada::count(),
        ];

        $recent_users = User::latest()->limit(5)->get();
        $recent_companies = Empresa::latest()->limit(5)->get();
        $recent_ras = Ra::latest()->limit(3)->get();
        $recent_contracts = Contract::latest()->limit(3)->get();

        return view('admin.dashboard', compact('stats', 'recent_users', 'recent_companies', 'recent_ras', 'recent_contracts'));
    }
}
