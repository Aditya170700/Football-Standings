<?php

namespace App\Http\Controllers;

use App\Models\Standing;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $results = Standing::with('team')
            ->orderBy('point', 'desc')
            ->orderBy('sg', 'desc')
            ->get();

        return view('home', [
            'results' => $results,
        ]);
    }
}
