<?php

namespace App\Filament\Resources\StudentResource\Pages;

use App\Filament\Resources\StudentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateStudent extends CreateRecord
{
    protected static string $resource = StudentResource::class;

    public function mutateFormDataBeforeCreate(array $data): array
    {
        $data['enrollment_data'] = [
            'academic_year_id' => $data['academic_year_id'],
            'program_id' => $data['program_id'],
            'study_group_id' => $data['study_group_id'] ?? null,
            'status' => $data['status'],
            'origin_school' => $data['origin_school'] ?? null,
            'graduation_year' => $data['graduation_year'] ?? null,
        ];

        unset($data['academic_year_id'], $data['program_id'], $data['study_group_id'], $data['status'], $data['origin_school'], $data['graduation_year']);

        return $data;
    }

    public static function afterCreate(array $data, Model $record): void
    {
        if (isset($data['enrollment_data'])) {
            $record->enrollments()->create($data['enrollment_data']);
        }
    }
}
