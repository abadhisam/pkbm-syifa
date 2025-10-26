<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\RelationManagers;
use App\Models\AcademicYear;
use App\Models\Program;
use App\Models\Student;
use App\Models\StudyGroup;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $pluralModelLabel = 'Daftar Murid';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
        ->select(['id', 'full_name', 'nik', 'nisn', 'gender', 'phone_number', 'created_at'])
        ->with([
            'activeEnrollment' => fn ($q) => $q
                ->select(['id', 'student_id', 'academic_year_id', 'program_id', 'study_group_id', 'status'])
                ->with([
                    'program:id,name',
                    'studyGroup:id,name',
                    'academicYear:id,name,is_active',
                ]),
        ]);
    }

    public static function form(Form $form): Form
    {
        $years = range(1990, 2030);
        $graduationYearOptions = array_combine($years, $years);

        return $form
            ->schema([
                Forms\Components\Section::make('Data Pribadi')
                    ->columns(3)
                    ->schema([
                        Forms\Components\TextInput::make('full_name')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(150)
                            ->placeholder('Contoh: Ahmad Fauzi'),
                            
                        Forms\Components\TextInput::make('nik')
                            ->label('NIK')
                            ->unique(ignoreRecord: true)
                            ->nullable()
                            ->numeric()
                            ->length(16)
                            ->placeholder('16 digit')
                            ->helperText('Nomor Induk Kependudukan (opsional)'),
                            
                        Forms\Components\TextInput::make('nisn')
                            ->label('NISN')
                            ->unique(ignoreRecord: true)
                            ->nullable()
                            ->numeric()
                            ->length(10)
                            ->placeholder('10 digit')
                            ->helperText('Nomor Induk Siswa Nasional (opsional)'),
                            
                        Forms\Components\Select::make('gender')
                            ->label('Jenis Kelamin')
                            ->options([
                                'Laki-laki' => 'Laki-laki',
                                'Perempuan' => 'Perempuan'
                            ])
                            ->required()
                            ->native(false),
                            
                        Forms\Components\TextInput::make('phone_number')
                            ->label('No. Telp/WA')
                            ->tel()
                            ->nullable()
                            ->maxLength(30)
                            ->placeholder('Contoh: 08123456789')
                            ->helperText('Untuk keperluan komunikasi'), 
                    ]),
                
                Forms\Components\Section::make('Alamat')
                    ->schema([
                        Forms\Components\Textarea::make('address')
                            ->label('Alamat Lengkap')
                            ->rows(3)
                            ->columnSpanFull()
                            ->placeholder('Contoh: Jl. Sudirman No. 123, RT 02/RW 05, Kelurahan Madiun'),
                    ]),

                Forms\Components\Section::make('Data Pendaftaran')
                    ->description('Isi data pendaftaran siswa untuk tahun ajaran aktif')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('academic_year_id')
                            ->label('Tahun Ajaran')
                            ->options(function () {
                                return cache()->remember('ay_options', 600, function () {
                                    return AcademicYear::query()
                                        ->orderByDesc('is_active')
                                        ->orderByDesc('name')
                                        ->get(['id', 'name', 'is_active'])
                                        ->mapWithKeys(fn ($ay) => [
                                            $ay->id => $ay->is_active ? "{$ay->name} (Aktif)" : $ay->name,
                                        ])->all();
                                });
                            })
                            ->default(fn () => AcademicYear::where('is_active', true)->value('id'))
                            ->required()
                            ->native(false)
                            ->searchable(),
                            
                        Forms\Components\Select::make('program_id')
                            ->label('Paket Program')
                            ->options(fn () => Program::pluck('name', 'id'))
                            ->required()
                            ->native(false)
                            ->searchable()
                            ->live()
                            ->helperText('Pilih Paket A, B, atau C'),
                            
                        Forms\Components\Select::make('study_group_id')
                            ->label('Kelompok Belajar')
                            ->options(fn () => StudyGroup::pluck('name', 'id'))
                            ->nullable()
                            ->native(false)
                            ->searchable()
                            ->helperText('Pilih kelompok belajar yang sesuai'),
                            
                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                'Aktif' => 'Aktif',
                                'Alumni' => 'Alumni',
                                'Tidak Selesai' => 'Tidak Selesai',
                            ])
                            ->default('Aktif')
                            ->required()
                            ->native(false),
                            
                        Forms\Components\Select::make('graduation_year')
                            ->label('Tahun Lulus')
                            ->options($graduationYearOptions)
                            ->searchable()
                            ->nullable()
                            ->native(false)
                            ->helperText('Tahun lulus dari sekolah asal')
                    ])
                    // ->visibleOn('create')
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('full_name')
                    ->label('Nama Lengkap')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->weight('medium'),
                    
                Tables\Columns\TextColumn::make('nik')
                    ->label('NIK')
                    ->searchable()
                    ->toggleable()
                    ->placeholder('Belum ada')
                    ->copyable(),
                    
                Tables\Columns\TextColumn::make('nisn')
                    ->label('NISN')
                    ->searchable()
                    ->toggleable()
                    ->placeholder('Belum ada')
                    ->copyable(),
                    
                Tables\Columns\TextColumn::make('gender')
                    ->label('L/P')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Laki-laki' => 'info',
                        'Perempuan' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'Laki-laki' => 'L',
                        'Perempuan' => 'P',
                        default => $state,
                    }),
                    
                Tables\Columns\TextColumn::make('phone_number')
                    ->label('No. Telp')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->copyable(),
                    
                Tables\Columns\TextColumn::make('activeEnrollment.program.name')
                    ->label('Paket')
                    ->sortable()
                    ->badge()
                    ->color('primary')
                    ->placeholder('Belum terdaftar'),
                    
                Tables\Columns\TextColumn::make('activeEnrollment.studyGroup.name')
                    ->label('Kelompok')
                    ->sortable()
                    ->badge()
                    ->color('info')
                    ->placeholder('-'),
                    
                Tables\Columns\TextColumn::make('activeEnrollment.status')
                    ->label('Status')
                    ->sortable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Aktif' => 'success',
                        'Alumni' => 'info',
                        'Tidak Selesai' => 'warning',
                        default => 'gray',
                    })
                    ->placeholder('Belum terdaftar'),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Terdaftar Sejak')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('academic_year')
                    ->label('Tahun Ajaran')
                    ->options(fn () => AcademicYear::pluck('name', 'id'))
                    ->default(fn () => AcademicYear::where('is_active', true)->value('id'))
                    ->query(function (Builder $query, array $data): Builder {
                        $yearId = $data['value'] ?? AcademicYear::where('is_active', true)->value('id');
                        
                        if ($yearId) {
                            return $query->whereHas('enrollments', fn ($q) => 
                                $q->where('academic_year_id', $yearId)
                            );
                        }
                        
                        return $query;
                    }),
                
                Tables\Filters\SelectFilter::make('program')
                    ->label('Paket Program')
                    ->options(fn () => Program::pluck('name', 'id'))
                    ->query(function (Builder $query, array $data): Builder {
                        if (empty($data['value'])) {
                            return $query;
                        }
                        
                        return $query->whereHas('enrollments', fn ($q) => 
                            $q->where('program_id', $data['value'])
                        );
                    }),

                Tables\Filters\SelectFilter::make('study_group')
                    ->label('Kelompok Belajar')
                    ->options(fn () => StudyGroup::pluck('name', 'id'))
                    ->query(function (Builder $query, array $data): Builder {
                        if (empty($data['value'])) {
                            return $query;
                        }
                        
                        return $query->whereHas('enrollments', fn ($q) => 
                            $q->where('study_group_id', $data['value'])
                        );
                    }),
                    
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status Siswa')
                    ->options([
                        'Aktif' => 'Aktif',
                        'Alumni' => 'Alumni',
                        'Tidak Selesai' => 'Tidak Selesai',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        if (empty($data['value'])) {
                            return $query;
                        }
                        
                        return $query->whereHas('enrollments', fn ($q) => 
                            $q->where('status', $data['value'])
                        );
                    }),
                    
                Tables\Filters\SelectFilter::make('gender')
                    ->label('Jenis Kelamin')
                    ->options([
                        'Laki-laki' => 'Laki-laki',
                        'Perempuan' => 'Perempuan',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Lihat'),
                Tables\Actions\EditAction::make()
                    ->label('Edit'),
                Tables\Actions\DeleteAction::make()
                    ->label('Hapus'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Hapus Terpilih'),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->emptyStateHeading('Belum ada data murid')
            ->emptyStateDescription('Silakan tambah data murid terlebih dahulu')
            ->emptyStateIcon('heroicon-o-users');
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\DocumentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
            'view' => Pages\ViewStudent::route('/{record}')
        ];
    }
}
