<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;


use App\Client;

class ClientTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    /**
     *
     * @return void
     */
    public function testClientCreated()
    {
        $data = [
            'firstname' => $this->faker->name,
            'lastname' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm',
        ];

        $this->post(route('client.create'), $data)->assertJson(['id' => true]);
    }

    /**
     *
     * @return void
     */
    public function testClientShow ()
    {
        $client = factory(Client::class)->create();
        $this->get(route('client.show', $client->id))->assertStatus(200);
    }

    /**
     *
     * @return void
     */
    public function testClientShowAll ()
    {
        $clients = factory(Client::class, 10)->create()->map(function ($client) {
            return $client->only([ 'firstname', 'lastname', 'email' ]);
        });
        $this->get(route('client.show_all'))
            ->assertStatus(200)
            ->assertJson($clients->toArray())
            ->assertJsonStructure([
              '*' => [ 'firstname', 'lastname', 'email' ],
        ]);
    }

    /**
     *
     * @return void
     */
    public function testClientRemove ()
    {
      $client = factory(Client::class)->create();
      $data = ['deleted' => 1, 'id' => $client->id];
      $this->post(route('client.remove', $client->id), $data)
          ->assertStatus(200)->assertJson(['status' => 'done']);
      $this->post(route('project.remove', $client->id), $data)
          ->assertStatus(200)->assertJson(['status' => 'not_found']);
    }
}
