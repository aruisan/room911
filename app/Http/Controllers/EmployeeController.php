<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Employee;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Imports\EmployeesImport;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
         // Obtener los filtros de búsqueda
         $search = $request->input('search');
         $departmentId = $request->input('department_id');
 
         // Filtrar los empleados según los filtros aplicados
         $employees = Employee::with('department', 'accessLogs')
             ->when($search, function ($query, $search) {
                 $query->where('internal_id', 'like', "%{$search}%")
                       ->orWhere('first_name', 'like', "%{$search}%")
                       ->orWhere('last_name', 'like', "%{$search}%");
             })
             ->when($departmentId, function ($query, $departmentId) {
                 $query->where('department_id', $departmentId);
             })
             ->orderBy('created_at', 'desc')
             ->paginate(10)
             ->withQueryString(); // Agrega esto para mantener los filtros en la URL
 
         return Inertia::render('Employee/EmployeeList', [
             'employees' => $employees,
             'departments' => Department::all(),
             'filters' => [
                 'search' => $search,
                 'department_id' => $departmentId,
             ],
         ]);
    }

    public function create()
    {
        $departments = Department::all();
        return Inertia::render('Employee/EmployeeForm', ['departments' => $departments]);
    }

    public function edit(Employee $employee)
    {
        $departments = Department::all();
        return Inertia::render('Employee/EmployeeForm', [
            'employee' => $employee,
            'departments' => $departments,
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'internal_id' => 'required|string|unique:employees,internal_id',
            'department_id' => 'required|exists:departments,id',
        ]);

        Employee::create($request->all());
        return redirect()->route('employees.index')->with('success', 'Employee registered successfully.');
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'internal_id' => 'required|string|unique:employees,internal_id,' . $employee->id,
            'department_id' => 'required|exists:departments,id',
        ]);

        $employee->update($request->all());

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }

    public function formImport(){
        $departments = Department::all();
        return Inertia::render('Employee/EmployeeImport', [
            'departments' => $departments
        ]);
    }

    public function import(Request $request){
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
            'department_id' => 'required|exists:departments,id',
        ]);

        // Importar los empleados usando Laravel Excel
        Excel::import(new EmployeesImport($request->department_id), $request->file('file'));

        return redirect()->back()->with('success', 'Employees uploaded successfully.');
    }

    public function history(Employee $employee, Request $request)
    {
          // Obtener las fechas de inicio y fin del request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Ajustar la fecha final para incluir todo el día final
        if ($endDate) {
            $endDate = Carbon::parse($endDate)->endOfDay(); // Establece la hora a 23:59:59
        }

        // Filtrar los registros de acceso por fecha si se proporcionan y paginar los resultados
        $accessLogs = $employee->accessLogs()
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString(); // Agrega esto para mantener los filtros en la URL

        return Inertia::render('Employee/EmployeeHistory', [
            'employee' => $employee,
            'access_logs' => $accessLogs,
            'filters' => [
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ],
        ]);
    }

    public function downloadHistory(Employee $employee, Request $request)
    {
        // Obtener las fechas de inicio y fin del request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Ajustar la fecha final para incluir todo el día final
        if ($endDate) {
            $endDate = Carbon::parse($endDate)->endOfDay();
        }

        // Filtrar los registros de acceso por fecha si se proporcionan
        $accessLogs = $employee->accessLogs()
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Generar el PDF usando una vista Blade
        $pdf = PDF::loadView('pdf.employee_history', [
            'employee' => $employee,
            'access_logs' => $accessLogs,
        ]);

        // Descargar el PDF
        return $pdf->download("history_{$employee->first_name}_{$employee->last_name}.pdf");
    }
}