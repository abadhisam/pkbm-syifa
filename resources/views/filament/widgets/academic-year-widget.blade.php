<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            Pilih Tahun Ajaran
        </x-slot>

        <x-slot name="description">
            Klik salah satu tahun ajaran untuk melihat data
        </x-slot>

        @php $columns = 3; @endphp
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 1rem;">
            @forelse ($academicYears as $year)
                <a
                    href="{{ route('filament.admin.resources.students.index', ['active_ta' => $year->id]) }}"
                    style="
                        display: block;
                        text-decoration: none;
                        color: inherit;
                    "
                >
                    <x-filament::card>
                        <div style="display:flex; justify-content:space-between; align-items:center;">
                            <div style="display:flex; align-items:center; gap:0.75rem;">
                                <x-filament::icon icon="heroicon-o-calendar-days" class="w-5 h-5 text-primary-500" />
                                <div>
                                    <div style="font-weight:600;">{{ $year->name }}</div>
                                    @if($year->starts_on && $year->ends_on)
                                        <div style="font-size:0.875rem; color:#6b7280;">
                                            {{ $year->starts_on->format('M Y') }} – {{ $year->ends_on->format('M Y') }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            @if ($year->is_active)
                                <x-filament::badge color="success">Berjalan</x-filament::badge>
                            @else
                                <x-filament::badge color="gray"></x-filament::badge>
                            @endif
                        </div>
                    </x-filament::card>
                </a>
            @empty
                <x-filament::card>
                    <div style="font-size:0.875rem; color:#6b7280;">Tahun Ajaran belum ditambahkan.</div>
                </x-filament::card>
            @endforelse
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
