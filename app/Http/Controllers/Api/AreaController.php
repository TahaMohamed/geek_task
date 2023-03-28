<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AreaRequest;
use App\Http\Resources\Api\AreaResource;
use App\Models\Area;
use Illuminate\Http\Request;

class AreaController extends Controller
{

    public function index($country_id = null)
    {
        $areas = Area::query()
            ->with('translation','country.translation')
            ->withCount('cities')
            ->when($country_id, fn($q) => $q->where('country_id',$country_id))
            ->paginate((int)($request->per_page ?? config("globals.per_page")));

        return $this->paginateResponse(data: AreaResource::collection($areas), collection: $areas);
    }

    public function store(AreaRequest $request)
    {
        Area::create($request->validated()); // + ['added_by_id' => auth()->id()] if auth
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
        $area = Area::query()
            ->with('country.translation')
            ->withCount('cities')
            ->when(!$show, fn($q) => $q->with('translations'))
            ->when($show, fn($q) => $q->with('translation'))
            ->findOrFail($id);

        return $this->successResponse(data: AreaResource::make($area));
    }

    public function update(AreaRequest $request, $id)
    {
        $area = Area::query()->where('country_id', $request->country_id)->findOrFail($id);
        $area->update($request->validated());
        return $this->successResponse(message: __('dashboard.message.success_update'));
    }

    public function destroy($id)
    {
        $area = Area::query()->findOrFail($id);
        $area->delete();
        return $this->successResponse(message: __('dashboard.message.success_delete'));
    }
}
