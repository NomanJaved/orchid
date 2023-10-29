<?php

namespace App\Orchid\Screens;

use Orchid\Screen\Screen;

use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;

use Orchid\Screen\Actions\ModalToggle;

use App\Models\Task;
use Illuminate\Http\Request;


class TaskScreen extends Screen
{
    /**
     * A method that defines all screen input data
     * is in it that database queries should be called,
     * api or any others (not necessarily explicit),
     * the result of which should be an array,
     * appeal to which his keys will be used.
     */
    public function query(): array
    {
        return [
            'tasks' => Task::latest()->get(),
        ];
    }

    /**
     * The name is displayed on the user's screen and in the headers
     */
    public function name(): ?string
    {
        return "TaskScreen";
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Orchid Quickstart";
    }
    
    /**
     * Identifies control buttons and events.
     * which will have to happen by pressing
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Add Task')
                ->modal('taskModal')
                ->method('create')
                ->icon('plus'),
        ];
    }

    /**
     * Set of mappings
     * rows, tables, graphs,
     * modal windows, and their combinations
     */
    public function layout(): iterable
    {
        return [
            Layout::modal('taskModal', Layout::rows([
                Input::make('task.name')
                    ->title('Name')
                    ->placeholder('Enter task name')
                    ->help('The name of the task to be created.'),
            ]))
                ->title('Create Task')
                ->applyButton('Add Task'),
        ];
    }


    /**
    * @param \Illuminate\Http\Request $request
    *
    * @return void
    */
    public function create(Request $request)
    {
        // Validate form data, save task to database, etc.
        $request->validate([
            'task.name' => 'required|max:255',
        ]);

        $task = new Task();
        $task->name = $request->input('task.name');
        $task->save();
    }

    

    

}