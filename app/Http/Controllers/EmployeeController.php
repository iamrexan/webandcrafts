<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\User;
use App\Models\Employee;
use App\Models\Designation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\Mail\SendEmployeeConfirmation;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      // $data = Employee::select('*')->with(['designation']);
      // dd($data);
      if ($request->ajax()) {
          $data = Employee::select('*')->with(['designation']);
          return DataTables::of($data)
                  ->addIndexColumn()
                  ->addColumn('action', function($row){
                         $btn = '<a href="'.route('employee.edit', $row->id).'" class="edit btn btn-primary btn-sm mr-2">Edit</a>
                         <a href="'.route('employee.delete', $row->id).'" class="edit btn btn-primary btn-sm">Delete</a>';
                          return $btn;
                  })
                  ->rawColumns(['action'])
                  ->make(true);
      }
      
      return view('employee.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('employee.form')->withDesignation(Designation::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:employees',
            'designation_id' => 'required',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $input = $request->all();
        if ($image = $request->file('photo')) {
          $destinationPath = 'image/';
          $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
          $image->move($destinationPath, $profileImage);
          $input['photo'] = "$profileImage";
        }  
        $input['password'] = Hash::make(config('app.default_employee_password'));
        // dd($input['password']);
        $data = Employee::create($input);
        \Mail::to($data->email)->send(new SendEmployeeConfirmation($data));

        return redirect()->route('employee.index')
                        ->with('success', 'Employee created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        return view('employee.edit')->with(["data" => Employee::find($request->id), "designation" => Designation::all()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, Employee $employee)
    {
      $employee = $employee->find($id);
      $request->validate([
        'name' => 'required',
        'email' => ['required', Rule::unique('employees')->ignore($employee->id)],
        'designation_id' => 'required',
        'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
      ]);

      $input = $request->all();

      if (!\is_null($request->file('photo'))) {
          $image = $request->file('photo');
          $destinationPath = 'image/';
          $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
          $image->move($destinationPath, $profileImage);
          $input['photo'] = "$profileImage";
      } else {
          unset($input['photo']);
      }
        
      $employee->update($input);
      return redirect()->route('employee.index')
                      ->with('success','Employee created successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee, $id)
    {
      $employee->find($id)->delete();
   
      return redirect()->route('employee.index')
                      ->with('success','Employee deleted successfully');
    }
}
