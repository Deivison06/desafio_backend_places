<?php

namespace Tests\Feature;

use App\Models\Place;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PlaceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_places()
    {
        Place::factory()->count(3)->create();

        $response = $this->getJson(route('places.index'));

        $response->assertOk()
            ->assertJsonStructure(['data']);
    }

    /** @test */
    public function it_can_create_a_place()
    {
        $data = [
            'name' => 'Praça Central',
            'city' => 'Fortaleza',
            'state' => 'CE',
        ];

        $response = $this->postJson(route('places.store'), $data);

        $response->assertCreated()
            ->assertJsonFragment(['name' => 'Praça Central']);
        $this->assertDatabaseHas('places', ['name' => 'Praça Central']);
    }

    /** @test */
    public function it_can_show_a_place()
    {
        $place = Place::factory()->create();

        $response = $this->getJson(route('places.show', $place->id));

        $response->assertOk()
            ->assertJsonFragment(['id' => $place->id]);
    }

    /** @test */
    public function it_can_update_a_place()
    {
        $place = Place::factory()->create();

        $data = ['name' => 'Novo Nome'];

        $response = $this->putJson(route('places.update', $place), $data);

        $response->assertOk()
            ->assertJsonFragment(['name' => 'Novo Nome']);
        $this->assertDatabaseHas('places', ['name' => 'Novo Nome']);
    }

    /** @test */
    public function it_can_delete_a_place()
    {
        $place = Place::factory()->create();

        $response = $this->deleteJson(route('places.destroy', $place));

        $response->assertNoContent();
        $this->assertDatabaseMissing('places', ['id' => $place->id]);
    }
}
