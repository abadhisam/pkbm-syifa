<?php

namespace App\Filament\Resources\StudentResource\Pages;

use App\Filament\Resources\StudentResource;
use App\Filament\Resources\StudentResource\RelationManagers;
use App\Models\AcademicYear;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewStudent extends ViewRecord
{
    protected static string $resource = StudentResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $enr = $this->record->activeEnrollment;

        if ($enr) {
            $data['academic_year_id'] = $enr->academic_year_id;
            $data['program_id']       = $enr->program_id;
            $data['study_group_id']   = $enr->study_group_id;
            $data['status']           = $enr->status;
            $data['graduation_year']  = $enr->graduation_year;
        } else {
            $data['academic_year_id'] = AcademicYear::where('is_active', true)->value('id');
        }

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
    
    public function getRelationManagers(): array
    {
        return [
            RelationManagers\DocumentsRelationManager::class, 
        ];
    }
}