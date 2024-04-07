<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

trait ApiResponder
{

	/**
	 * Build success response
	 * @param string/array $data
	 * @param int  $code
	 * @return Illuminate\Http\JsonResponse
	*/
	public function successResponse($data, $code = 200)
	{
		return response()->json(['data' => $data], $code);
	}




	/**
	 * Build error response
	 * @param string/array $message
	 * @param int  $code
	 * @return Illuminate\Http\JsonResponse
	*/
	public function errorResponse($message, $code)
	{
		return response()->json(['error' => $message, 'code' => $code], $code);
	}


}
