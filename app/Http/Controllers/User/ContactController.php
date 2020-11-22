<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\ContactUpdateRequest;

class ContactController extends Controller
{
    public function __construct()
    {
       $this -> middleware(['auth', 'verified']);
    }

    public function index() // Display a listing of the resource
    {
      return \View::make('contents.user.contact.index') -> with(['contact' => \DB::table('contacts') -> first()]);
    }

    public function update(ContactUpdateRequest $request) // Update the specified resource in storage
    {
      $validatedData = $request -> validated();

      \DB::table('contacts') -> update($validatedData);

      return ['success' => true];
    }
}
