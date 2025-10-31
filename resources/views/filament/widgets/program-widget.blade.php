<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            Program Pendidikan
        </x-slot>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1rem; margin-top: 1rem;">
            @foreach($programs as $index => $program)
                @php
                    $colors = [
                        ['bg' => '#EFF6FF', 'badge' => '#DBEAFE', 'text' => '#1E40AF', 'icon' => '#2563EB', 'accent' => '#3B82F6'],
                        ['bg' => '#F0FDF4', 'badge' => '#DCFCE7', 'text' => '#15803D', 'icon' => '#16A34A', 'accent' => '#22C55E'],
                        ['bg' => '#FAF5FF', 'badge' => '#F3E8FF', 'text' => '#6B21A8', 'icon' => '#9333EA', 'accent' => '#A855F7'],
                    ];
                    $color = $colors[$index % count($colors)];
                @endphp

                <div style="position: relative; overflow: hidden; border-radius: 0.5rem; border: 1px solid #E5E7EB; background: white; padding: 1.5rem; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); transition: box-shadow 0.2s;">

                    <!-- Badge Program -->
                    <div style="position: absolute; top: 1rem; right: 1rem;">
                        <span style="display: inline-flex; align-items: center; justify-content: center; width: 2.5rem; height: 2.5rem; border-radius: 9999px; font-size: 0.875rem; font-weight: 700; background-color: {{ $color['badge'] }}; color: {{ $color['text'] }};">
                            {{ chr(64 + $program['id']) }}
                        </span>
                    </div>

                    <!-- Icon Program -->
                    <div style="margin-bottom: 1rem;">
                        <div style="display: flex; align-items: center; justify-content: center; width: 3.5rem; height: 3.5rem; border-radius: 0.5rem; background-color: {{ $color['bg'] }};">
                            @if($program['id'] == 1)
                                <svg style="width: 1.75rem; height: 1.75rem; color: {{ $color['icon'] }};" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            @elseif($program['id'] == 2)
                                <svg style="width: 1.75rem; height: 1.75rem; color: {{ $color['icon'] }};" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                </svg>
                            @else
                                <svg style="width: 1.75rem; height: 1.75rem; color: {{ $color['icon'] }};" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/>
                                </svg>
                            @endif
                        </div>
                    </div>

                    <!-- Content -->
                    <div>
                        <h3 style="font-size: 1.125rem; font-weight: 600; color: #111827; margin-bottom: 0.5rem;">
                            {{ $program['name'] }}
                        </h3>
                        <p style="font-size: 0.875rem; color: #6B7280; line-height: 1.6;">
                            {{ $program['description'] }}
                        </p>
                    </div>

                    <!-- Decorative Element -->
                    <div style="position: absolute; bottom: 0; right: 0; width: 6rem; height: 6rem; background-color: {{ $color['accent'] }}; opacity: 0.05; border-top-left-radius: 9999px;"></div>
                </div>
            @endforeach
        </div>

        <style>
            @media (max-width: 768px) {
                [style*="grid-template-columns"] {
                    grid-template-columns: 1fr !important;
                }
            }
        </style>
    </x-filament::section>
</x-filament-widgets::widget>
