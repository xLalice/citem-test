<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class RegistrationController extends Controller
{
    
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users', 
            'username' => 'required|string|alpha_num|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::min(8)], 
            'type' => 'required|in:Buyer,Exhibitor,Visitor',

            'company_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'region' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'year_established' => 'required|digits:4|integer|max:' . (date('Y') + 1),
            'website' => 'nullable|url',
            'brochure' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

        try {
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'username' => $request->username,
                'password' => Hash::make($request->password), 
                'type' => $request->type,
            ]);

            $brochurePath = null;
            if ($request->hasFile('brochure')) {
                $brochurePath = $request->file('brochure')->store('brochures', 'public');
            }

            Company::create([
                'user_id' => $user->id,
                'company_name' => $request->company_name,
                'address' => $request->address,
                'city' => $request->city,
                'region' => $request->region,
                'country' => $request->country,
                'year_established' => $request->year_established,
                'website' => $request->website,
                'brochure_path' => $brochurePath,
            ]);

            DB::commit();

            return response()->json(['message' => 'Registration successful!'], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Registration failed due to a server error.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}