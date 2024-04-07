<?php

namespace App\Http\Controllers\Api;

use App\Models\Company;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use App\Services\UploadService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    use ApiResponder;

    public function index()
    {

        if (request()->sort) {
            if (request()->sort == "latest") {
                $query = Company::latest('id');
            }
            if (request()->sort == "oldest") {
                $query = Company::oldest('id');
            }
        }else{

            $query = Company::all();
        }
        $companies = $query->paginate(20);
        if (count($companies) < 1)  return $this->errorResponse('No record found', 422);
        return $this->successResponse($companies);
    }

    public function store(Request $request)
    {
        $data = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'contact' => 'required|max:11',
            'address' => 'required|max:11',
            'logo' => 'nullable|image|max:200',
        ]);
        if ($data->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $data->errors(),
            ]);
        } else {

            // Send request to end point
            $company = Company::create([
                'name' => $request->name,
                'email' => $request->email,
                'contact' => $request->contact,
                'address' => $request->address,
                'logo' => $request->name,
            ]);

            return $this->successResponse($company);
        }
    }
    public function show($id)
    {
        $company = Company::find($id);
        if (!$company)  return $this->errorResponse('No record found', 422);
        return $this->successResponse($company);
    }

    public function updateLogo(Request $request, $id)
    {
        $company = Company::find($id);
        if (!$company)  return $this->errorResponse('No record found', 422);
        if ($request->hasFile('logo')) {
            $fileName = $request->logo->getClientOriginalName();
            $img_url = UploadService::upload($request->logo, 'Logos', $fileName);
        }
        $company->update([
            'logo' => $img_url,
        ]);
        return $this->successResponse($company);
    }
    public function update(Request $request, $id)
    {
        $company = Company::find($id);
        if (!$company)  return $this->errorResponse('No record found', 422);
        $company->update([
            'name' => $request->name,
            'email' => $request->email,
            'contact' => $request->contact,
            'address' => $request->address,
        ]);
        return $this->successResponse($company);
    }

    public function destroy($id)
    {
        $company = Company::find($id);
        if (!$company)  return $this->errorResponse('No record found', 422);
        $company->delete();
        return $this->successResponse('Company Deleted Successfully!', 200);
    }
}
