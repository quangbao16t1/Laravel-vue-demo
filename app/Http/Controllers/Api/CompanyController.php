<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use App\Models\Company;

class CompanyController extends Controller
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
  //   $companies = QueryBuilder::for(Company::class)
  //     ->defaultSort('name')
  //     ->allowedSorts(['description'])
  //     ->allowedFilters(['name', 'description', $globalSearch])
  //     ->paginate(8)
  //     ->withQueryString();

  //   return Inertia::render('Company/Index', ['companies' => $companies])->table(function (InertiaTable $table) {
  //     $table->column('id', 'ID', searchable: true, sortable: true);
  //     $table->column('name', 'Name', searchable: true, sortable: true);
  //     $table->column('description', 'Description', searchable: true, sortable: true);
  //     $table->column('type', 'Type', searchable: true, sortable: true);
  //     $table->column('address', 'Address', searchable: true, sortable: true);
  //     $table->column('phone_number', 'Phone Number', searchable: true, sortable: true);
  //     $table->column('created_at', 'Join Date', searchable: true, sortable: true);
  //   });
  // }

  public function store(CompanyRequest $request)
  {
    $company = new Company();
    $company->fill($request->all());
    $company->save();

    return response()->json($company);
  }

  public function show($id)
  {
    $company = Company::find($id);

    return response()->json(($company));
  }

  public function getAll()
  {
    $company = Company::all()->map(function ($item) {
      return
        [
          'id' => $item->id,
          'name' => $item->name,
          'description' => $item->description,
          'type' => $item->type,
          'address' => $item->address,
          'phone_number' => $item->phone_number,
          'created_at' => $item->created_at->toDateString(),
          'created_at_fe' => $item->created_at_fe
        ];
    });

    return response()->json($company);
  }

  public function update()
  {
  }

  public function destroy()
  {
  }
}
