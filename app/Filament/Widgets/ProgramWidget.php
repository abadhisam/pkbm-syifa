<?php

namespace App\Filament\Widgets;

use App\Models\Program;
use Filament\Widgets\Widget;

class ProgramWidget extends Widget
{
    protected static string $view = 'filament.widgets.program-widget';

    protected int|string|array $columnSpan = 'full';

    public ?string $heading = 'Programs (Paket A/B/C)';

    public function getViewData(): array
    {
        $programs = Program::query()
            ->orderBy('name')
            ->get(['id', 'name', 'name', 'description']);

        return compact('programs');
    }
}
