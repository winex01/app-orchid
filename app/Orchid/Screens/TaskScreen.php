<?php

namespace App\Orchid\Screens;

use App\Models\Task;
use App\Models\User;
use Orchid\Screen\TD;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Toast;
use Orchid\Screen\Fields\Relation;
use Orchid\Support\Facades\Layout;
use App\Orchid\Filters\EmailFilter;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\ModalToggle;
use App\Orchid\Layouts\TaskFiltersLayout;

class TaskScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            // 'tasks' => Task::latest()->get()
            'tasks' => Task::
                // filters(TaskFiltersLayout::class)
                filters([EmailFilter::class])
                ->defaultSort('id', 'desc')
                ->paginate(5),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Simple To-Do List';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return 'Orchid Quickstart';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
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
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            // TaskFiltersLayout::class,
            Layout::selection([
                EmailFilter::class,
            ]),
            // table
            Layout::table('tasks', [
                TD::make('name')
                    ->sort()
                    ->filter(TD::FILTER_TEXT),
                
                TD::make('user.name', 'Assignee')
                ->render(function ($task) {

                    if (!$task->user){
                        return;
                    }
                    
                    return Link::make($task->user->email)
                        ->route('platform.systems.users.edit', $task->user->id);
                    // return dump($task);
                })
                ->sort()
                ->filter(),

                // actions
                TD::make(__('Actions'))
                    ->align(TD::ALIGN_CENTER)
                    ->width('100px')
                    ->render(fn (Task $task) => DropDown::make('Actions')
                        ->icon('bs.three-dots-vertical')
                        ->list([
    
                            Button::make(__('Remove'))
                                ->icon('bs.trash3')
                                ->confirm('After deleting, the task will be gone forever.')
                                ->method('remove', ['task' => $task->id]),
                        ])),

            ]),


            // modal
            Layout::modal('taskModal', Layout::rows([
                Input::make('task.name')
                    ->title('Name')
                    ->placeholder('Enter task name')
                    ->help('The name of the task to be created.'),
                
                Relation::make('task.user')
                    ->title('User')
                    ->fromModel(User::class, 'email'),
                
            ]))
                ->title('Create Task')
                ->applyButton('Add Task')

        ];
    }

    public function create(Request $request)
    {
        // Validate form data, save task to database, etc.
        $request->validate([
            'task.name' => 'required|max:255',
        ]);

        $task = new Task();
        $task->name = $request->input('task.name');
        
        if ($request->has('task.user')) {
            $user = User::find($request->input('task.user'));

            if ($user) {
                // Associate the user with the task
                $task->user()->associate($user);
            } else {
                // Handle case where user doesn't exist
            }
        }
        
        $task->save();


        Alert::success('You have successfully created a task.');
    }

    public function remove(Task $task)
    {
        $task->delete();

        Alert::success('You have successfully deleted the task.');
    }
}
