<?php

namespace App\Imports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EmployeesImport implements ToModel, WithHeadingRow
{
    protected $departmentId;

    public function __construct($departmentId)
    {
        $this->departmentId = $departmentId;
    }

    public function model(array $row)
    {
        // Asignar cada fila del Excel a un nuevo empleado
        return new Employee([
            'first_name' => $row['first_name'],
            'last_name' => $row['last_name'],
            'internal_id' => $row['internal_id'],
            'department_id' => $this->departmentId,
        ]);
    }
}

