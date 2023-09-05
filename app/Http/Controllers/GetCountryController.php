<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetCountryController extends Controller
{
    public function __invoke(): JsonResponse
    {
        $countries = Country::all()->get();
        return response()->json($countries);
    }
}
