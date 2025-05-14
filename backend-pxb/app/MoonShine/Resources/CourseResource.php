<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Course;

use App\Models\CourseFamily;
use MoonShine\UI\Fields\Date;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;
use MoonShine\Laravel\Fields\Relationships\HasMany;

/**
 * @extends ModelResource<Course>
 */
class CourseResource extends ModelResource
{
    protected string $model = Course::class;

    protected string $title = 'Все курсы';
    
    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Название', 'name'),
            Text::make('Группа курсов', 'courseFamily.name'),
            Text::make('Преподаватель', 'teacher.full_name'),

        ];
    }

    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function formFields(): iterable
    {
        return [
            Box::make([
                ID::make(),
                Text::make('Название', 'name'),
                Textarea::make('Описание', 'description'),
                Text::make('Путь к изображению', 'image_path'),
                Select::make('Группа курсов', 'course_family_id')
                    ->options(CourseFamily::all()->mapWithKeys(fn ($family) => [
                        $family->id => $family->name
                    ])->toArray()),
                Select::make('Преподаватель', 'teacher_id')
                    ->options(fn () => \App\Models\Teacher::all()->mapWithKeys(fn ($teacher) => [
                        $teacher->id => $teacher->full_name
                    ])->toArray()),
                Text::make('Цена', 'price'),
                Date::make('Дата начала', 'start_date'),
                Text::make('Продолжительность', 'duration')
            ])
        ];
    }

    /**
     * @return list<FieldContract>
     */
    protected function detailFields(): iterable
    {
        return [
            ID::make(),
            Text::make('Название', 'name'),
            HasMany::make('Записанные пользователи', 'courseSignups', function () {
                return [
                    Text::make('Имя', 'user.full_name'),
                    Text::make('Email', 'user.email'),
                ];
            }),

        ];
    }

    /**
     * @param Course $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }
}
