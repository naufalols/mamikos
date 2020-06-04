<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class projectsTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @test
     */

    use WithFaker, RefreshDatabase;


    public function guests_cannot_create_project()
    {
        $attributes = factory('App\Project')->raw();
        $this->post('/projects', $attributes)->assertRedirect('login');
    }

    /**
     * A basic feature test example.
     *
     * @test
     */

    public function guests_cannot_view_project()
    {
        $this->get('/projects')->assertRedirect('login');
    }

    /**
     * A basic feature test example.
     *
     * @test
     */

    public function guests_cannot_view_a_single_project()
    {
        $project = factory('App\Project')->create();

        $this->get($project->path())->assertRedirect('login');
    }
    /**
     * A basic feature test example.
     *
     * @test
     */
    public function a_user_can_create_a_project()
    {
        $this->withoutExceptionHandling();

        $this->actingAs(factory('App\User')->create());

        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph
        ];

        $this->post('/projects', $attributes)->assertRedirect('/projects');

        $this->assertDatabaseHas('projects', $attributes);

        $this->get('/projects')->assertSee($attributes['title']);
    }


    /**
     * @test
     */
    public function a_user_can_view_their_project()
    {

        $this->be(factory('App\User')->create());

        $this->withoutExceptionHandling();


        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);

        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }


    /**
     * A basic feature test example.
     *
     * @test
     */

    public function an_authenticated_useer_cannot_view_the_projects_of_others()
    {
        $this->be(factory('App\User')->create());

        // $this->withoutExceptionHandling();


        $project = factory('App\Project')->create();

        $this->get($project->path())->assertStatus(403);
    }
    /**
     * A basic feature test example.
     *
     * @test
     */

    public function a_project_require_a_title()
    {
        $this->actingAs(factory('App\User')->create());
        $attributes = factory('App\Project')->raw(['title' => '']);
        $this->post('/projects', $attributes)->assertSessionHasErrors('title');
    }
    /**
     * A basic feature test example.
     *
     * @test
     */
    public function a_project_require_a_description()
    {

        $this->actingAs(factory('App\User')->create());
        $attributes = factory('App\Project')->raw(['description' => '']);
        $this->post('/projects', $attributes)->assertSessionHasErrors('description');
    }
}
