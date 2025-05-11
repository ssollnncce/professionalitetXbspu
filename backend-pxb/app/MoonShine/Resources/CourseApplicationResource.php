<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\CourseApplication;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;

use MoonShine\Actions\Action;
use MoonShine\Fields\Text;
use MoonShine\MoonShineRequest;
use Illuminate\Support\Facades\DB;


/**
 * @extends ModelResource<CourseApplication>
 */
class CourseApplicationResource extends ModelResource
{
    protected string $model = CourseApplication::class;

    protected string $title = 'Заявки на курсы';
    


    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
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
        ];
    }

    /**
     * @param CourseApplication $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }

    /**
     * Отключаем редактирование формы и кнопки удаления
     */
    public function disableForm(): bool
    {
        return true; // Отключаем редактирование формы
    }

    public function deleteButton(): bool
    {
        return false; // Отключаем кнопку удаления
    }
}
