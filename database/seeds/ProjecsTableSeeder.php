<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Project;
use App\Task;
class ProjecsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $projects = array(
            array('name'=> 'Task Management'),
            array('name'=> 'User Management'),
        );

        $tasks = array(
            array('name'=>'Create Task Form', 'task_date'=> Carbon::now(), 'project_id'=> 1, 'user_id'=> 1),
            array('name'=>'Create Task Edit Form', 'task_date'=> Carbon::now(), 'project_id'=> 1, 'user_id'=> 1),
            array('name'=>'Create Show Task Form', 'task_date'=> Carbon::now(), 'project_id'=> 1, 'user_id'=> 1),
            array('name'=>'Create User Form', 'task_date'=> Carbon::now(), 'project_id'=> 2, 'user_id'=> 1),
            array('name'=>'Create User Edit Form', 'task_date'=> Carbon::now(), 'project_id'=> 2, 'user_id'=> 1),
            array('name'=>'Create Show User Form', 'task_date'=> Carbon::now(), 'project_id'=> 2, 'user_id'=> 1),
        );

        foreach ($projects as $project) {
            Project::create($project);
        }

        foreach ($tasks as $task) {
            Task::create($task);
        }
    }
}
