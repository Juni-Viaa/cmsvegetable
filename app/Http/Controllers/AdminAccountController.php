<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $columns = [
            'username' => 'Username',
            'phone_number' => 'Phone Number'
        ];

        $editFields = [
            [
                'type' => 'text', 
                'name' => 'name', 
                'label' => 'Username Name',
                'placeholder' => 'Enter username name',
                'required' => true
            ],
            [
                'type' => 'text', 
                'name' => 'password', 
                'label' => 'Password',
                'placeholder' => 'Enter new password',
                'required' => true
            ],
            [
                'type' => 'text', 
                'name' => 'confirm_password', 
                'label' => 'Confirmation Password',
                'placeholder' => 'Enter password confirmation',
                'required' => true
            ],
        ];

        $query = User::select(array_merge(array_keys($columns), ['user_id']));

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%$search%");
        }

        $data = $query->paginate(10);

        return view('admin.admin_account', compact('data', 'columns', 'editFields'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
