@extends('layouts.admin')

@section('content')
    @include('partials.session_message')
    <h1 class="ps-1 py-3">La lista dei progetti</h1>
    <div class="text-end">
        <a href="{{ route('admin.projects.create') }}" class="btn btn-success">Nuovo progetto</a>
    </div>

    <form action="{{ route('admin.projects.index') }}" method="GET" class="my-2">
        @csrf
        <label for="type">Tecnologia</label>
        <select name="type_id" id="type">
            <option value="">All</option>
            @foreach ($types as $type)
                <option value="{{ $type->id }}">{{ $type->name }}</option>
            @endforeach
        </select>
        <button class="btn btn-primary" type="submit">Cerca</button>
    </form>

    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Titolo</th>
                <th scope="col">Tipo</th>
                <th scope="col">Tecnologia</th>
                <th scope="col">Slug</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($projects as $project)
                <tr class="align-middle">
                    <th scope="row">{{ $project->id }}</th>
                    <td>{{ $project->title }}</td>
                    <td>
                        @if ($project->type)
                            <span>{{ $project->type->name }}</span>
                        @else
                            <span>Null</span>
                        @endif
                    </td>
                    {{-- <td>
                        {{$project->technology?->name}}
                    </td> --}}
                    <td>
                        @forelse ($project->technologies as $technology)
                            <span>{{ $technology->name }} {{ $loop->last ? '' : ',' }}</span>
                        @empty
                            <span>Null</span>
                        @endforelse
                    </td>
                    <td class="text-wrap">{{ $project->slug }}</td>
                    <td class="text-nowrap">
                        <a href="{{ route('admin.projects.show', $project->slug) }}" class="btn btn-success">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.projects.edit', $project->slug) }}" class="btn btn-warning">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <form class="d-inline-block" action="{{ route('admin.projects.destroy', $project->slug) }}"
                            method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div>
        {{ $projects->links() }}
    </div>

    {{-- <img src="{{ asset('storage/superman.webp') }}" alt="prova"> --}}
@endsection
