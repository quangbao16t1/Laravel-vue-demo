<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;

class CategoryController extends Controller
{

  // public function index(Request $request): Response
  // {
  //   $globalSearch = AllowedFilter::callback('global', function ($query, $value) {
  //     $query->where(function ($query) use ($value) {
  //       Collection::wrap($value)->each(function ($value) use ($query) {
  //         $query
  //           ->orWhere('name', 'LIKE', "%{$value}%")
  //           ->orWhere('description', 'LIKE', "%{$value}%");
  //       });
  //     });
  //   });
  //   $companies = QueryBuilder::for(category::class)
  //     ->defaultSort('name')
  //     ->allowedSorts(['description'])
  //     ->allowedFilters(['name', 'description', $globalSearch])
  //     ->paginate(8)
  //     ->withQueryString();

  //   return Inertia::render('category/Index', ['companies' => $companies])->table(function (InertiaTable $table) {
  //     $table->column('id', 'ID', searchable: true, sortable: true);
  //     $table->column('name', 'Name', searchable: true, sortable: true);
  //     $table->column('description', 'Description', searchable: true, sortable: true);
  //     $table->column('type', 'Type', searchable: true, sortable: true);
  //     $table->column('address', 'Address', searchable: true, sortable: true);
  //     $table->column('phone_number', 'Phone Number', searchable: true, sortable: true);
  //     $table->column('created_at', 'Join Date', searchable: true, sortable: true);
  //   });
  // }

  public function store(CategoryRequest $request)
  {
    $category = new Category();
    $category->fill($request->all());
    $category->save();

    return response()->json($category);
  }

  public function show($id)
  {
    $category = Category::find($id);

    return response()->json(($category));
  }

  public function getAll()
  {
    $category = Category::with('company')->get()->map(function ($item) {
      return [
        'id' => $item -> id,
        'name' => $item -> name,
        'description' => $item -> description,
        'company_id' => $item -> company_id,
        'company' => $item -> company,
        'created_at' => $item -> created_at -> toDateString()
      ];
    });

    return response()->json($category);
  }

  public function update(CategoryRequest $request, $id)
  {
    $category = Category::find($id);
    $category -> fill($request -> all());
    $category -> save();

    return response()->json($category);
  }

  public function destroy()
  {
  }
}
