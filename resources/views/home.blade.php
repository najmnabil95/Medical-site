@extends('layouts.app')

@section('title')
    {{ $settings->site_name ?? 'مستشفى الشفاء الدولي' }} | {{ $settings->site_name_en ?? 'Al-Shifa International Hospital' }}
@endsection

@section('content')
    <!-- Alert Success Notification if any -->
    @if(session('success'))
        <div role="alert-flash" class="fixed bottom-6 left-6 bg-emerald-500 hover:bg-emerald-600 text-white font-medium py-3 px-6 rounded-xl shadow-2xl z-[99999] transition-all duration-300 transform scale-100 flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Dynamic Screens Loop -->
    @foreach($screens as $screen)
        @if($screen->component !== 'NewsTicker')
            @includeIf('components.home.' . $screen->component)
        @endif
    @endforeach
@endsection
