<?php

namespace App\Filament\Resources\StudentResource\Pages;

use App\Filament\Resources\StudentResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;

class CreateStudent extends CreateRecord
{
    protected static string $resource = StudentResource::class;
    protected array $enrollmentData = []; 

    public function mutateFormDataBeforeCreate(array $data): array
    {
        $enrollmentFields = [
            'academic_year_id',
            'program_id',
            'study_group_id',
            'status',
            'graduation_year',
        ];
        
        $enrollmentDataTemp = [];

        foreach ($enrollmentFields as $field) {
            $enrollmentDataTemp[$field] = $data[$field] ?? null;
        }
        
        $this->enrollmentData = $enrollmentDataTemp;

        foreach ($enrollmentFields as $field) {
            unset($data[$field]);
        }

        return $data; 
    }

    protected function afterCreate(): void
    {
        if (! empty($this->enrollmentData)) {
            $dataToCreate = collect($this->enrollmentData)->only([
                'academic_year_id',
                'program_id',
                'study_group_id',
                'status',
                'graduation_year',
            ])->toArray();

            try {
                $this->record->enrollments()->create($dataToCreate);

                Notification::make()
                    ->title('Pendaftaran Berhasil! 🥳')
                    ->body('Selanjutnya, harap **Upload Dokumen Murid**.')
                    ->success()
                    ->send();


                $this->redirect($this->getResource()::getUrl('edit', ['record' => $this->record]));
            } catch (\Throwable $e) {
                Notification::make()
                    ->title('ERROR: Gagal Buat Pendaftaran')
                    ->body('Terjadi kesalahan saat menyimpan pendaftaran: '.$e->getMessage())
                    ->danger()
                    ->send();
            }
        } else {
            Notification::make()
                ->title('PERINGATAN!')
                ->body('Data Pendaftaran tidak ditemukan. Pastikan semua kolom wajib telah diisi.')
                ->warning()
                ->send();
        }
    }
}
