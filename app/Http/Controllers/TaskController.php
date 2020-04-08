<?php

namespace App\Http\Controllers;

use App\Task;
use App\Project;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TaskController extends Controller
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $tasks = Task::orderBy('priority','ASC')
            ->where('user_id', auth()->user()->id)
            ->orderBy('project_id','ASC')
            ->get();

        return response()->json($tasks);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=> 'required',
            'task_date'=> 'required',
            'priority'=> 'required',
            'project'=> 'required',
        ]);

        $data = [
            'name' => $request->name,
            'task_date' => Carbon::parse($request->task_date),
            'priority' => $this->checkPriority($request->priority),
            'project_id' => $request->project,
            'user_id' => auth()->user()->id,

        ];

       $task = Task::create($data);
       $message = 'Task is successfully created';

        return response()->json(['task'=> $task,'status'=>$message], 200);

    }

    /**
     * @param Task $task
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $task = Task::find($id);

        if($task->delete()) {
           return response()->json('Task is successfully deleted');
        }
        return response()->json('Something went wrong');
    }

    /**
     * @param Task $task
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Task $task, Request $request)
    {
        $this->validate($request, [
            'name'=> 'required',
            'priority'=> 'required',
            'project'=> 'required',
            'status'=> 'required',
        ]);


        $data = [
            'name' => $request->name,
            'task_date' =>   Carbon::parse($request->task_date),
            'priority' => $this->checkPriority($request->priority),
            'project_id' => $request->project,
            'status' => $this->checkStatus($request->status),
            'user_id' => auth()->user()->id,

        ];

        $task->update($data);

        return response()->json(['task'=> $task, 'message'=>'Updated successfully'], 200);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatus(Request $request, $id)
    {
        $task = Task::find($id);

        $task->status = $this->checkStatus($request->status);
        $task->save();

        return response()->json('Status changed', 200);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProject($id)
    {
        $project = Project::find($id);

        return response()->json($project->tasks);
    }

    /**
     * @param $status
     * @return int
     */
    protected function checkStatus($status)
    {
        switch ($status) {
            case 'NEW':
                return Task::TASK_STATUS_NEW;
                break;
            case 'INPROGRESS':
                return Task::TASK_STATUS_INPROGRESS;
                break;
            case 'COMPLETED':
                return Task::TASK_STATUS_COMPLETED;
                break;
        }
    }

    /**
     * @param $priority
     * @return int
     */
    protected function checkPriority($priority)
    {
        switch ($priority) {
            case 'LOW':
                return Task::TASK_PRIORITY_LOW;
                break;
            case 'MEDIUM':
                return Task::TASK_PRIORITY_MEDIUM;
                break;
            case 'HIGH':
                return Task::TASK_PRIORITY_HIGH;
                break;
        }
    }

}
