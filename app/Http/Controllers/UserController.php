<?php

namespace App\Http\Controllers;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        dd(auth()->user());
    }

    public function logout()
    {
        auth()->logout();
    }
}
