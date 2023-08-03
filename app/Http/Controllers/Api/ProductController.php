<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index() {

    }

    public function store(ProductRequest $request) {
        $company = new Product();
        $company->fill($request -> all());
        $company -> save();

        return response() -> json();
    }

    public function show() {

    }

    public function update() {

    }

    public function destroy() {

    }
}
