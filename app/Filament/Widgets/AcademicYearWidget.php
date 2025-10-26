<?php

namespace App\Filament\Widgets;

use App\Models\AcademicYear;
use Filament\Widgets\Widget;

class AcademicYearWidget extends Widget
{
    protected static string $view = 'filament.widgets.academic-year-widget';
    protected int | string | array $columnSpan = 'full'; 

    protected function getViewData(): array
    {
        return [
            'academicYears' => AcademicYear::orderBy('name', 'asc')->get(),
        ];
    }
}
