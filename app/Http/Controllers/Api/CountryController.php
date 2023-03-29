<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CountryRequest;
use App\Http\Resources\Api\CountryResource;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{

    public function index()
    {
        $countries = Country::query()
            ->with('translation','capital.translation')
            ->withCount('cities', 'areas')
            ->latest('id')
            ->paginate((int)($request->per_page ?? config("globals.pagination.per_page")));

        return $this->paginateResponse(data: CountryResource::collection($countries), collection: $countries);
    }

    public function store(CountryRequest $request)
    {
        Country::create($request->validated()); // + ['added_by_id' => auth()->id()] if auth
        return $this->successResponse(message: __('dashboard.message.success_add'), code: 201);
    }

    public function show(int $id)
    {
        return $this->showOrEdit($id, true);
    }

    public function edit(int $id)
    {
        return $this->showOrEdit($id, false);
    }

    private function showOrEdit(int $id, bool $show)
    {
        $country = Country::query()
            ->withCount('cities', 'areas')
            ->when(!$show, fn($q) => $q->with('translations'))
            ->when($show, fn($q) => $q->with('translation','capital.translation'))
            ->findOrFail($id);

        return $this->successResponse(data: CountryResource::make($country));
    }

    public function update(CountryRequest $request, $id)
    {
        $country = Country::query()->findOrFail($id);
        $country->update($request->validated());
        return $this->successResponse(message: __('dashboard.message.success_update'));
    }

    public function destroy($id)
    {
        $country = Country::query()->withCount('cities', 'areas')->findOrFail($id);
        if ($country->cities_count || $country->areas_count) {
            return $this->errorResponse(message: __('validation.country.restrict.cannot_delete_country_has_cities'));
        }
        $country->delete();
        return $this->successResponse(message: __('dashboard.message.success_delete'));
    }
}
