@extends('layouts.app')

@section('content')

    <div class="container my-4">
        @if (session('deleted'))
            <div class="alert alert-success" role="alert">
                {{ session('deleted') }}
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <h1 class="my-5">
            I MIEI PROGETTI
            <a href="{{route('admin.projects.create')}}" class="btn btn-light">
                <i class="fa-solid fa-plus"></i>
            </a>
        </h1>

        <form action="{{ route('admin.projects.index') }}" method="GET" class="d-flex justify-content-between align-items-center mb-4">
            <input name="search" class="form-control me-2" type="search" placeholder="Search" aria-label="Search" value="{{ request('search') }}">
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form>

        @if ($projects->isEmpty())
            <div class="alert alert-warning text-center" role="alert">
                <span class="d-block">La Ricerca non ha prodotto risultati</span>
                <a href=" {{ route('admin.projects.index') }} " class="text-center btn btn-outline-warning m-3">Tutti i Progetti</a>
            </div>
        @else

            <form id="delete-multiple-form" action="{{ route('admin.deleteMultiple') }}" method="POST">
                @csrf
                @method('DELETE')

                <div class="d-flex justify-content-between align-items-center">
                    <div class="col">
                        <button type="submit" class="btn btn-danger mb-3" id="delete-selected-btn" disabled>Elimina Selezionati</button>
                    </div>
                </div>

                <table class="table">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="select-all"></th>
                            <th>#id</th>
                            <th>Title</th>
                            <th>Start Date</th>
                            <th>Status</th>
                            <th class="text-center">Type</th>
                            <th class="text-center">Technologies</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($projects as $project)
                            <tr>
                                <td><input type="checkbox" name="projects[]" value="{{ $project->id }}" class="project-checkbox"></td>
                                <th> {{ $project->id }} </th>
                                <td> {{ $project->title }} </td>
                                <td> {{ ($project->start_date)->format('d/m/Y') }} </td>
                                <td> {{ $project->status }} </td>
                                <td class="text-center">
                                    @if ($project->type)
                                        <a href="{{route('admin.projectsPerType', $project->type)}}" class="btn btn-light">
                                            {{ $project->type->name }}
                                        </a>
                                    @else
                                        ---
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($project->technologies)
                                        @forelse($project->technologies as $technology)
                                            <span class="badge text-bg-info">{{$technology->name}}</span>
                                        @empty
                                            ---
                                        @endforelse
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
            </form>
            
            {{$projects->appends(['search' => request()->input('search')])->links()}}

        @endif
    </div>

    <script>
        // Funzione che abilita/disabilita il bottone in base al numero di checkbox selezionate
        function toggleDeleteButton() {
            const selectedCheckboxes = document.querySelectorAll('.project-checkbox:checked');
            const deleteButton = document.getElementById('delete-selected-btn');
            // Disabilita il bottone se nessuna checkbox è selezionata
            deleteButton.disabled = selectedCheckboxes.length === 0;
        }

        // Aggiunge un listener all'elemento "select-all"
        document.getElementById('select-all').addEventListener('click', function(event) {
            // prende tutte le checkbox
            const checkboxes = document.querySelectorAll('.project-checkbox');
            checkboxes.forEach(checkbox => {
                //checkbox.checked restituisce true o false ed è modificato dallo stato di select-all(event.target)
                checkbox.checked = event.target.checked;
            });
            // Controlla se abilitare o disabilitare il bottone
            toggleDeleteButton();
        });

        // Seleziona tutte le checkbox con classe 'project-checkbox'
        const checkboxes = document.querySelectorAll('.project-checkbox');
        // Aggiunge un listener di eventi "change" a ogni checkbox per verificare quando cambiano
        checkboxes.forEach(checkbox => {
            // collega all'evento change della singola checkbox la funzione toggleDeleteButton
            checkbox.addEventListener('change', toggleDeleteButton);
        });

    </script>

@endsection

@section('title')
    Projects
@endsection

