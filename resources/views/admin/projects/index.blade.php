@extends('layouts.app')

@section('content')

    <div class="container my-4">
        @if (session('deleted'))
            <div class="alert alert-success" role="alert">
                {{ session('deleted') }}
            </div>
        @endif

        <h1 class="my-5">
            I MIEI PROGETTI
            <a href="{{route('admin.projects.create')}}" class="btn btn-light">
                <i class="fa-solid fa-plus"></i>
            </a>
        </h1>

        <table class="table">
            <thead>
                <tr>
                    <th>#id</th>
                    <th>Title</th>
                    <th>Start Date</th>
                    <th>Status</th>
                    <th class="text-center">Category</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($projects as $project)
                    <tr>
                        <th> {{ $project->id }} </th>
                        <td> {{ $project->title }} </td>
                        <td> {{ ($project->start_date)->format('d/m/Y') }} </td>
                        <td> {{ $project->status }} </td>
                        <td class="text-center">
                            @if ($project->type)
                                <span class="badge text-bg-info">
                                    <a href="{{route('admin.projectsPerType', $project->type)}}" class="text-white link-offset-2 link-underline link-underline-opacity-0">
                                        {{ $project->type->name }}
                                    </a>
                                </span>
                            @else
                                ---
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{route('admin.projects.show', $project)}}" class="btn btn-success">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-warning">
                                <i class="fa-solid fa-pencil"></i>
                            </a>
                            <form action="{{route('admin.projects.destroy', $project)}}" method="POST" class="d-inline" onsubmit="return confirm('Sei sicuro di voler eliminare {{$project->title}}?')">
                            @csrf
                            @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{$projects->links()}}
    </div>
@endsection

