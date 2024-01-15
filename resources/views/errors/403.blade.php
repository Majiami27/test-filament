@extends('errors::minimal')

@section('title', __('Forbidden'))
@section('code', '403')
@section('message', __($exception->getMessage() ?: 'Forbidden'))

@section('button')
    <div class="text-center">
        <button>
            <a href="{{ route('filament.admin.pages.dashboard') }}">Go Back</a>
        </button>
    </div>
@endsection