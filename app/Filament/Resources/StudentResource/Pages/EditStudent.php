<?php

namespace App\Filament\Resources\StudentResource\Pages;

use App\Filament\Resources\StudentResource;
use App\Models\AcademicYear;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Arr;

class EditStudent extends EditRecord
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

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $enrollment = Arr::only($data, [
            'academic_year_id',
            'program_id',
            'study_group_id',
            'status',
            'graduation_year',
        ]);

        foreach (array_keys($enrollment) as $f) {
            unset($data[$f]);
        }

        $ayId = $enrollment['academic_year_id']
            ?? AcademicYear::where('is_active', true)->value('id');

        try {
            $this->record->enrollments()->updateOrCreate(
                ['academic_year_id' => $ayId],
                $enrollment
            );
        } catch (\Throwable $e) {
            Notification::make()
                ->title('Gagal menyimpan Enrollment')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
