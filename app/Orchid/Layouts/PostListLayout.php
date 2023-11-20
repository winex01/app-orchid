<?php

namespace App\Orchid\Layouts;

use App\Models\Post;
use Orchid\Screen\TD;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;

class PostListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'posts';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('title', 'Title')
                ->sort()
                ->render(function (Post $post) {
                    return Link::make($post->title)
                        ->route('platform.post.edit', $post);
                }),
            
            TD::make('hero')
                ->width('100')
                ->render(function (Post $post) {

                    if (!$post->hero) {
                        return;
                    }

                    return "<img src='".$post->hero."'
                                alt='sample'
                                class='mw-100 d-block img-fluid rounded-1 w-100'>
                            <span class='small text-muted mt-1 mb-0'># ".$post->id."</span>";
                }),
            

            TD::make('created_at', 'Created')->sort(),
            TD::make('updated_at', 'Last edit')->sort(),

            // actions
            // TD::make('Actions')
            // ->alignRight()
            // ->render(function(Post $post) {
            //     return Button::make('Delete')
            //         ->confirm('After deleting, the post will be gone forever.')
            //         ->method('delete', ['post' => $post->id]);
            // }),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn (Post $post) => DropDown::make('Actions')
                    ->icon('bs.three-dots-vertical')
                    ->list([

                        Link::make(__('Edit'))
                            ->route('platform.post.edit', $post->id)
                            ->icon('bs.pencil'),

                        Button::make(__('Remove'))
                            ->icon('bs.trash3')
                            ->confirm('After deleting, the post will be gone forever.')
                            ->method('remove', ['post' => $post->id]),
                    ])),
        ];
    }
}
