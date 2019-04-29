<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;


use App\Project;

class ProjectTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    private $statuses = ['planned', 'running', 'on hold', 'finished', 'cancel'];

    /**
     *
     * @return void
     */
    public function testProjectCreated()
    {
        $data = [
            'name' => $this->faker->name,
            'description' => $this->faker->name,
            'status' => $this->statuses[mt_rand(0, 4)],
        ];

        $this->post(route('project.create'), $data)->assertJson(['project' => true]);
    }


    /**
     *
     * @return void
     */
    public function testProjectUpdate ()
    {
        $project = factory(Project::class)->create();
        $data = [
            'name' => $this->faker->realText(20),
            'description' => $this->faker->realText(200),
            'status' => $this->statuses[mt_rand(0, 4)],
        ];

        $this->post(route('project.update', $project->id), $data)
            ->assertStatus(200)->assertJson(['id' => true]);
    }

    /**
     *
     * @return void
     */
    public function testProjectShow ()
    {
        $project = factory(Project::class)->create();
        $this->get(route('project.show', $project->id))->assertStatus(200);
    }

    /**
     *
     * @return void
     */
    public function testProjectShowAll ()
    {
        $projects = factory(Project::class, 10)->create()->map(function ($project) {
            return $project->only([ 'name', 'description', 'status' ]);
        });
        $this->get(route('project.show_all'))
            ->assertStatus(200)
            ->assertJson($projects->toArray())
            ->assertJsonStructure([
              '*' => [ 'name', 'description', 'status' ],
        ]);
    }

    /**
     *
     * @return void
     */
    public function testProjectRemove ()
    {
        $project = factory(Project::class)->create();
        $data = ['deleted' => 1];
        $this->post(route('project.remove', $project->id), $data)
            ->assertStatus(200)->assertJson(['status' => 'not_found']);
    }
}
