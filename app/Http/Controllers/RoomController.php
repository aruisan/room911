<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Employee;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(Employee $employee){

        if (!$employee) {
            return redirect()->back()->withErrors(['Employee not found']);
        }
    
        // Puedes usar dd($employee) para depurar y revisar los datos enviados
        return Inertia::render('Room911/RoomIndex', [
            'employee' => $employee,
        ]);
    }
}
