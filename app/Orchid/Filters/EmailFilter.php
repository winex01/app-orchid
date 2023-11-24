<?php

namespace App\Orchid\Filters;

use App\Models\User;
use Orchid\Screen\Field;
use Orchid\Filters\Filter;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Illuminate\Database\Eloquent\Builder;

class EmailFilter extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string
    {
        return 'Email';
    }

    /**
     * The array of matched parameters.
     *
     * @return array|null
     */
    public function parameters(): ?array
    {
        return ['email'];
    }

    /**
     * Apply to a given Eloquent query builder.
     *
     * @param Builder $builder
     *
     * @return Builder
     */
    public function run(Builder $builder): Builder
    {
        // return $builder->where('email', $this->request->get('email'));

        return $builder->whereHas('user', function (Builder $query) {
            $query->where('email', $this->request->get('email'));
        });
    }

    /**
     * Get the display fields.
     *
     * @return Field[]
     */
    public function display(): iterable
    {
        // return [
        //     Input::make('email')
        //         ->type('text')
        //         ->value($this->request->get('email'))
        //         ->placeholder('Search...')
        //         ->title('Search')
        // ];

        return [
            Select::make('email')
                ->fromModel(User::class, 'email', 'email')
                ->empty()
                ->value($this->request->get('email'))
                ->title(__('Email')),
        ];
    }
}
