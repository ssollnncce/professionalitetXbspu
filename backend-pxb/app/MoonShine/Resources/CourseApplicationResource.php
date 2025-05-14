<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\CourseApplication;
use Illuminate\Mail\Mailables\Content;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;

use MoonShine\Actions\Action;
use MoonShine\UI\Fields\Text;
use Illuminate\Support\Facades\DB;
use MoonShine\Support\Enums\HttpMethod;
use MoonShine\UI\Fields\Preview;
use MoonShine\UI\Fields\Date;

use MoonShine\Support\ListOf;
use MoonShine\UI\Components\ActionButton;
use Illuminate\Http\Request;

use MoonShine\Laravel\MoonShineRequest;
use MoonShine\Http\Responses\MoonShineJsonResponse;
use App\Mail\ApplicationConfirmed;
use App\Mail\ApplicationReject;
use Illuminate\Support\Facades\Mail;


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
            Text::make('Имя', 'user.full_name'),
            Text::make('Курс', 'course.name'),
            Text::make('Почта', 'user.email'),
            Text::make('Телефон', 'user.phone'),
            Preview::make('Статус', 'status')
                ->badge(fn($status, $field) => $status === 'Awaiting confirmation' ? 'yellow' : ($status === 'Confirmed' ? 'green' : 'red')),
            Date::make('Дата создания', 'created_at')
                ->format('d.m.Y')
                ->sortable()
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
    protected function indexButtons(): ListOf
    {
        return parent::indexButtons()
            ->except(fn(ActionButton $btn) => $btn->getName() === 'resource-delete-button')
            ->except(fn(ActionButton $btn) => $btn->getName() === 'resource-edit-button')
            ->except(fn(ActionButton $btn) => $btn->getName() === 'resource-detail-button')
            ->prepend(
                ActionButton::make('Подтвердить', )
                    ->success()
                    ->withConfirm(
                        title: 'Подтверждение заявки',
                        content: 'Вы уверены, что хотите подтвердить заявку?',
                        button: 'Подтвердить',
                    )
                    ->method('confirmApplication'),
                ActionButton::make('Отклонить')
                    ->error() 
                    ->method('rejectApplication')  
            );
    }

    public function confirmApplication(Request $request)
    {
        $id = $request->get('resourceItem'); // получаем id текущей записи
        $item = CourseApplication::findOrFail($id);
    
        $item->update(['status' => 'Confirmed']);

        DB::table('course_signups')->insert([
            'users_id' => $item->user_id,
            'course_id' => $item->course_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Отправляем письмо пользователю
        $user = $item->user; // Предполагается, что у CourseApplication есть связь с User
        $course = $item->course; // Предполагается, что у CourseApplication есть связь с Course

        Mail::to($user->email)->send(new ApplicationConfirmed($user, $course));
    }

    public function rejectApplication(Request $request)
    {
        $id = $request->get('resourceItem'); // получаем id текущей записи
        $item = CourseApplication::findOrFail($id);
    
        $item->update(['status' => 'Decline']);
    
        // Отправляем письмо пользователю
        $user = $item->user; // Предполагается, что у CourseApplication есть связь с User
        $course = $item->course; // Предполагается, что у CourseApplication есть связь с Course

        Mail::to($user->email)->send(new ApplicationReject($user, $course));
    }
}
