<?php

namespace Tests\Feature;

use App\Models\Country;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CityTest extends TestCase
{
    use RefreshDatabase;
//    This an example for testing not all
    public function test_add_city(): void
    {
        $this->withoutExceptionHandling()
            ->postJson('api/cities', $this->getCityData())
            ->assertStatus(201);
    }

    private function getCityData(): array
    {
        $city_data = [];
        $country = Country::factory()->create();
        foreach (config('translatable.locales') as $locale) {
            $city_data +=[
                $locale => [
                    'name' => fake()->name(),
                    'description' => fake()->paragraph(2)
                ],
                'country_id' => $country->id
            ];
        }
        return $city_data;
    }
}
