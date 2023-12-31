<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CompanyController extends Controller
{
  public function index(Request $request): Response
  {
    return Inertia::render('Company/Index', [
      'status' => session('status'),
    ]);
  }
}
