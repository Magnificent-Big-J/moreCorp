<?php

namespace Tests\Unit;

use App\Project;
use App\Task;
use Carbon\Carbon;
use Tests\TestCase;
use Faker\Factory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    protected $headers = [];
    protected $scopes = [];
    protected $tasks;

    protected $faker;

    public function setUp(): void
    {
        parent::setUp();

        $this->tasks = new Task();
        $this->faker = Factory::create();

    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testcreate_a_task()
    {
        $date = date('Y-m-d');
        //Get token
        $token = $this->authenticatedUser();
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('POST','/api/tasks',[
            'name' => $this->faker->word,
            'task_date' =>   $date,
            'priority' => 'LOW',
            'project' => rand(1,2),
            'status' => 'NEW'
        ]);

        $response->assertStatus(200);

    }

    /**
     *
     */
    public function test_get_tasks()
    {
        $token = $this->authenticatedUser();
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('GET','/api/tasks');

        $response->assertStatus(200);
    }

    public function test_update_task()
    {
        //Get latest task

        $task = Task::latest()->first();
        //Create date
        $date = date('Y-m-d');
        //Get token
        $token = $this->authenticatedUser();
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('POST','/api/task/update/' . $task->id,[
            'name' => $this->faker->word,
            'task_date' =>   $date,
            'priority' => 'HIGH',
            'project' => rand(1,2),
            'status' => 'INPROGRESS'
        ]);

        $response->assertStatus(200);

    }

    public function test_delete_task()
    {
        $task = Task::latest()->first();

        $token = $this->authenticatedUser();
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('POST','/api/task/delete/' . $task->id);

        $response->assertStatus(200);
    }

    public function test_get_project_task()
    {
        $token = $this->authenticatedUser();
        $project = Project::latest()->first();
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('GET','/api/task/project/' . $project->id);

        $response->assertStatus(200);
    }
    protected function authenticatedUser()
    {
        $body = [
            'username' => 'mnisij64@gmail.com',
            'password' => 'password',
            'grant_type' => config('services.passport.grant_type'),
            'client_id' => config('services.passport.client_id'),
            'client_secret' => config('services.passport.client_secret'),
            'scope' => '*'
        ];
      $response =  $this->json('POST','/oauth/token',$body,['Accept' => 'application/json']);
        $response = json_decode($response->content());
      return $response->access_token;
    }
}
