<?php

namespace App\Http\Controllers\Api;

use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use App\Services\UploadService;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    use ApiResponder;

    public function index()
    {
        if (request()->sort) {
            if (request()->sort == "latest") {
                $query = Employee::latest('id');
            }
            if (request()->sort == "oldest") {
                $query = Employee::oldest('id');
            }
        }else{

            $query = Employee::orderBy("created_at","DESC");
        }
        $employees = $query->paginate(10);
        if (count($employees) < 1)  return $this->errorResponse('No record found', 422);
        return $this->successResponse($employees);
    }

    public function store(Request $request)
    {
        $data = Validator::make($request->all(), [
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:employees,email',
            'contact' => 'required|max:11|unique:employees,contact',
            'address' => 'required|max:11',
            'gender' => 'required|in:Male,Female',
            'date_of_birth' => 'required',
            'photo' => 'nullable|image|max:200',
        ]);

        if ($data->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $data->errors(),
            ]);
        } else {
            if ($request->hasFile('photo')) {
                $fileName = $request->photo->getClientOriginalName();
                $img_url = UploadService::upload($request->photo, 'Profile', $fileName);
            }
            // Send request to end point
            $employee = Employee::create([
                'first_name' =>$request->first_name,
                'last_name' =>$request->last_name,
                'email' =>$request->email,
                'contact' =>$request->contact,
                'gender' =>$request->gender,
                'date_of_birth' =>$request->date_of_birth,
                'address' =>$request->address,
                'photo' => $request->photo ? $img_url : null,
            ]);

            return $this->successResponse($employee);
        }
    }
    public function show($id)
    {
        $employee = Employee::find($id);
        if (!$employee)  return $this->errorResponse('No record found', 422);
        return $this->successResponse($employee);
    }


    public function updatePhoto(Request $request,$id)
    {
        $data = Validator::make($request->all(), [
            'photo' => 'required|image|max:200',
        ]);

        if ($data->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $data->errors(),
            ]);
        } else {
            $employee = Employee::find($id);
            if (!$employee)  return $this->errorResponse('No record found', 422);
            if ($request->hasFile('photo')) {
                $fileName = $request->photo->getClientOriginalName();
                $img_url = UploadService::upload($request->photo, 'Profile', $fileName);
            }
            $employee->update([
                'photo' => $img_url,
            ]);
            return $this->successResponse($employee);

        }
    }
    public function update(Request $request, $id)
    {
        $employee = Employee::find($id);
        if (!$employee)  return $this->errorResponse('No record found', 422);
        $employee->update([
            'first_name' =>$request->first_name,
            'last_name' =>$request->last_name,
            'email' =>$request->email,
            'contact' =>$request->contact,
            'gender' =>$request->gender,
            'date_of_birth' =>$request->date_of_birth,
            'address' =>$request->address,
        ]);
        return $this->successResponse($employee);
    }

    public function destroy($id)
    {
        $employee = Employee::find($id);
        if (!$employee)  return $this->errorResponse('No record found', 422);
        $employee->delete();
        return $this->successResponse('Employee Deleted Successfully!', 200);
    }
}
