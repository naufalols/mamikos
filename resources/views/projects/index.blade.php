@extends('layouts.app')

@section('content')
    <header class="flex item-center mb-3 py-4">
       <div class="flex justify-between items-end w-full">
            <h2 class="text-gray-600 text-sm font-normal">My Project</h2>
            <a type="button" class="button-blue" href="{{url('/projects/create')}}">New Project</a>
       </div>
    </header>
    

        <main class="lg:flex lg:flex-wrap -mx-3">
        @forelse($projects as $project)
        <div class="lg:w-1/3 px-3 pb-6">
            @include('projects.card')
        </div>
        @empty
            <li>No Projects Yet.</li>   
        @endforelse
        </main>
   
@endsection
