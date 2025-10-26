<?php

namespace App\Filament\Resources\StudentResource\RelationManagers;

use App\Models\StudentDocument;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Validation\Rule;

class DocumentsRelationManager extends RelationManager
{
    protected static string $relationship = 'documents';
    protected static ?string $recordTitleAttribute = 'document_type';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('document_type')
                ->label('Jenis Dokumen')
                ->options([
                    'Ijazah Terakhir' => 'Ijazah Terakhir',
                    'Kartu Keluarga' => 'Kartu Keluarga (KK)',
                    'Akte Kelahiran' => 'Akte Kelahiran',
                    'Transkrip Nilai' => 'Transkrip Nilai',
                    'Foto Diri' => 'Foto Diri',
                    'Formulir Pendaftaran' => 'Formulir Pendaftaran',
                    'Raport' => 'Raport' 
                ])
                ->options(function (Get $get, ?StudentDocument $record) {
                    $student = $this->getOwnerRecord();
                    $taken = $student->documents()
                        ->when($record, fn($q) => $q->where('id', '!=', $record->id))
                        ->pluck('document_type')
                        ->all();

                    $all = [
                        'Ijazah Terakhir' => 'Ijazah Terakhir',
                        'Kartu Keluarga' => 'Kartu Keluarga (KK)',
                        'Akte Kelahiran' => 'Akte Kelahiran',
                        'Transkrip Nilai' => 'Transkrip Nilai',
                        'Foto Diri' => 'Foto Diri',
                        'Formulir Pendaftaran' => 'Formulir Pendaftaran',
                        'Raport' => 'Raport' 
                    ];

                    return collect($all)->reject(fn($_, $key) => in_array($key, $taken))->toArray();
                })
                ->required()
                ->rules([
                    function () {
                        $studentId = $this->getOwnerRecord()->getKey();
                        return Rule::unique('student_documents', 'document_type')
                            ->where('student_id', $studentId);
                    },
                ])
                ->native(false),
           Forms\Components\FileUpload::make('file_path')
                ->label('Upload File')
                ->disk('public')
                ->directory('student_files')
                ->acceptedFileTypes(['application/pdf', 'image/*'])
                ->maxSize(5 * 1024) // 5 MB
                ->required(fn(?StudentDocument $record) => $record?->file_path ? false : true)
                ->downloadable()
                ->openable(),
        ])->columns(2);    
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('document_type')
                    ->label('Jenis')
                    ->badge(),
                Tables\Columns\ImageColumn::make('file_path')
                    ->label('Gambar')
                    ->disk('public')
                    ->height(80),
                Tables\Columns\TextColumn::make('created_at')->label('Diupload pada')->dateTime()->since(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Tambah Dokumen'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->emptyStateHeading('Belum ada dokumen');
    }
}
