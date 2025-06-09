<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\CourseFamily;
use Illuminate\Database\Eloquent\Model;

use MoonShine\Laravel\Fields\Relationships\HasMany;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Components\Link;

/**
 * @extends ModelResource<CourseFamily>
 */
class CourseFamiliesResource extends ModelResource
{
    protected string $model = CourseFamily::class;

    protected string $title = 'Группы курсов';

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Название', 'name'),
            Text::make('Цветовой индекс', 'theme_color'),
        ];
    }

    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function formFields(): iterable
    {
        return [
            Box::make([
                Text::make('Название', 'name'),
                Text::make('Цветовой индекс', 'theme_color'),
            ])
        ];
    }

    /**
     * @return list<FieldContract>
     */
    protected function detailFields(): iterable
    {
        return [
            Text::make('Название', 'name'),
            Text::make('Цветовой индекс', 'theme_color'),
            HasMany::make('Курсы группы', 'courses'),
        ];
    }

    /**
     * @param CourseFamily $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }
}
