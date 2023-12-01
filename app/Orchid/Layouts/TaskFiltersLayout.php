<?php

namespace App\Orchid\Layouts;

use App\Orchid\Filters\EmailFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class TaskFiltersLayout extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): iterable
    {
        return [
            EmailFilter::class,
        ];
    }
}
