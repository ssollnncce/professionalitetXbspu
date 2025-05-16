<?php

declare(strict_types=1);

namespace App\MoonShine\Layouts;

use MoonShine\MenuManager\MenuGroup;
use MoonShine\MenuManager\MenuItem; 
use App\MoonShine\Resources\CourseResource;
use App\MoonShine\Resources\CourseApplicationResource;

use MoonShine\Laravel\Layouts\AppLayout;
use MoonShine\ColorManager\ColorManager;
use MoonShine\Contracts\ColorManager\ColorManagerContract;
use MoonShine\Laravel\Components\Layout\{Locales, Notifications, Profile, Search};
use MoonShine\UI\Components\{Breadcrumbs,
    Components,
    Layout\Flash,
    Layout\Div,
    Layout\Body,
    Layout\Burger,
    Layout\Content,
    Layout\Footer,
    Layout\Head,
    Layout\Favicon,
    Layout\Assets,
    Layout\Meta,
    Layout\Header,
    Layout\Html,
    Layout\Layout,
    Layout\Logo,
    Layout\Menu,
    Layout\Sidebar,
    Layout\ThemeSwitcher,
    Layout\TopBar,
    Layout\Wrapper,
    When};
use App\MoonShine\Resources\CourseSignupResource;

final class MoonShineLayout extends AppLayout
{
    protected function assets(): array
    {
        return [
            ...parent::assets(),
        ];
    }

    protected function menu(): array
    {
        return [
            MenuGroup::make('Курсы', [
                MenuItem::make('Список курсов', CourseResource::class),
                MenuItem::make('Заявки на курсы', CourseApplicationResource::class),
                MenuItem::make('Запись на курсы', CourseSignupResource::class),
            ]),
            MenuGroup::make('Настройки', [
            ])
                ->icon('Logo', true, 'icons')
        ];
    }

    /**
     * @param ColorManager $colorManager
     */
    protected function colors(ColorManagerContract $colorManager): void
    {
        parent::colors($colorManager);

        // $colorManager->primary('#00000');
    }

    public function build(): Layout
    {
        return parent::build();
    }

    protected function getLogoComponent(): Logo {
        
        return Logo::make(
            $this->getHomeUrl(),
            $this->getLogo(),
            $this->getLogo(small: true),
        );
    }
}
