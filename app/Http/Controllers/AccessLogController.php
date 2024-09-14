<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\AccessLog;
use Illuminate\Http\Request;

class AccessLogController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */


    public function store(Request $request) {
        $employee = Employee::where('internal_id', $request->internal_id)->first();
        $reason = (is_null($employee) 
                    ? 'no employee with that internal id exists'
                    : !$employee->access_allowed)
                        ? 'The employee does not have access to room 911'
                        : 'successful access';
        
        $log = AccessLog::create([
            'employee_id' => $employee->id,
            'successful' => is_null($employee) || !$employee->access_allowed ? FALSE : TRUE
        ]);

        /*
        return is_null($employee) || !$employee->access_allowed 
                ? 'no'
                : 'si';
                */
        return is_null($employee) || !$employee->access_allowed 
                ? redirect()->route('welcome')->with('warning', $reason)
                : redirect()->route('room', $employee->id)->with('success', $reason);
    }
}
