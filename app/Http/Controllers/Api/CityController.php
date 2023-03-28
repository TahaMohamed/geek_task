<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CityRequest;
use App\Http\Resources\Api\CityResource;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{

    public function index($country_id = null)
    {
        $cities = City::query()
            ->with('translation','country.translation','area.translation')
            ->when($country_id, fn($q) => $q->where('country_id',$country_id))
            ->paginate((int)($request->per_page ?? config("globals.per_page")));

        return $this->paginateResponse(data: CityResource::collection($cities), collection: $cities);
    }

    public function store(CityRequest $request)
    {
        City::create($request->validated()); // + ['added_by_id' => auth()->id()] if auth
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
        $city = City::query()
            ->with('country.translation','area.translation')
            ->when(!$show, fn($q) => $q->with('translations'))
            ->when($show, fn($q) => $q->with('translation'))
            ->findOrFail($id);

        return $this->successResponse(data: CityResource::make($city));
    }

    public function update(CityRequest $request, $id)
    {
        $city = City::query()->where('country_id', $request->country_id)->findOrFail($id);
        $city->update($request->validated());
        return $this->successResponse(message: __('dashboard.message.success_update'));
    }

    public function destroy($id)
    {
        $city = City::query()->findOrFail($id);
        $city->delete();
        return $this->successResponse(message: __('dashboard.message.success_delete'));
    }
}
