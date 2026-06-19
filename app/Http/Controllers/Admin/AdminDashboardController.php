<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Empresa;
use App\Models\Jornada;
use App\Models\Professor;
use App\Models\Alumne;
use App\Models\Empresari;

class AdminDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_professors' => Professor::count(),
            'total_students' => Alumne::count(),
            'total_business_owners' => Empresari::count(),
            'total_companies' => Empresa::count(),
            'total_attendance_records' => Jornada::count(),
        ];

        $recent_users = User::latest()->limit(5)->get();
        $recent_companies = Empresa::latest()->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'recent_users', 'recent_companies'));
    }
}
