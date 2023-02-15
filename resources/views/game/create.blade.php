@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            {{ __('Add Games') }}
                            <a href="{{ route('games.index') }}" class="btn btn-sm btn-light">
                                Back
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (session('failed'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('failed') }}
                            </div>
                        @endif

                        @php
                            $games = old('games') ?? [
                                [
                                    'home_id' => '',
                                    'away_id' => '',
                                    'date' => '',
                                    'home_score' => 0,
                                    'away_score' => 0,
                                ],
                            ];
                        @endphp
                        <form method="post" action="{{ route('games.store') }}">
                            @method('POST')
                            @csrf
                            <div class="row">
                                <div class="col-12 mb-3" id="cover">
                                    @foreach ($games as $key => $game)
                                        <div class="row" id="{{ $key }}">
                                            <div class="col-12 mb-3">
                                                <span class="fw-bold">Pertandingan {{ $loop->iteration }}</span>
                                            </div>
                                            <div class="col-lg-6 mb-2">
                                                <div class="form-group">
                                                    <label>Home Team</label>
                                                    <select name="games[{{ $key }}][home_id]" class="form-control">
                                                        <option value="">-- Choose Team --</option>
                                                        @foreach ($home_teams as $team)
                                                            <option value="{{ $team->id }}"
                                                                {{ old('games.' . $key . '.home_id') == $team->id ? 'selected' : '' }}>
                                                                {{ $team->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('games.' . $key . '.home_id')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-6 mb-2">
                                                <div class="form-group">
                                                    <label>Away Team</label>
                                                    <select name="games[{{ $key }}][away_id]"
                                                        class="form-control">
                                                        <option value="">-- Choose Team --</option>
                                                        @foreach ($away_teams as $team)
                                                            <option value="{{ $team->id }}"
                                                                {{ old('games.' . $key . '.away_id') == $team->id ? 'selected' : '' }}>
                                                                {{ $team->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('games.' . $key . '.away_id')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-6 mb-2">
                                                <div class="form-group">
                                                    <label>Home Team
                                                        Score</label>
                                                    <input type="number" name="games[{{ $key }}][home_score]"
                                                        class="form-control"
                                                        value="{{ old('games.' . $key . '.home_score') }}">
                                                    @error('games.' . $key . '.home_score')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-6 mb-2">
                                                <div class="form-group">
                                                    <label>Away Team
                                                        Score</label>
                                                    <input type="number" name="games[{{ $key }}][away_score]"
                                                        class="form-control"
                                                        value="{{ old('games.' . $key . '.away_score') }}">
                                                    @error('games.' . $key . '.away_score')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-12 mb-2">
                                                <div class="form-group">
                                                    <label>Match Date</label>
                                                    <input type="date" name="games[{{ $key }}][date]"
                                                        class="form-control" value="{{ old('games.' . $key . '.date') }}">
                                                    @error('games.' . $key . '.date')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="col-12">
                                    <button type="button" class="btn btn-danger" id="add-form">Tambah
                                        Pertandingan</button>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function removeForm(id) {
            $(`#${id}`).remove();
        }

        $(function() {
            $('#add-form').on('click', function() {
                let lastId = $('#cover').children().length;

                let newRow = `
                <div class="row" id="${lastId}">
                    <div class="col-12">
                        <hr />
                    </div>
                    <div class="col-12 mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold">Pertandingan ${lastId + 1}</span>
                            <button type="button" class="btn btn-sm btn-danger" onclick="removeForm(${lastId})">Delete</button>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-2">
                        <div class="form-group">
                            <label>Home Team</label>
                            <select name="games[${lastId}][home_id]"
                                class="form-control">
                                <option value="">-- Choose Team --</option>
                                @foreach ($home_teams as $team)
                                    <option value="{{ $team->id }}"
                                        {{ old('games.' . $key . '.home_id') == $team->id ? 'selected' : '' }}>
                                        {{ $team->name }}</option>
                                @endforeach
                            </select>
                            @error('games.' . $key . '.home_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6 mb-2">
                        <div class="form-group">
                            <label>Away Team</label>
                            <select name="games[${lastId}][away_id]"
                                class="form-control">
                                <option value="">-- Choose Team --</option>
                                @foreach ($away_teams as $team)
                                    <option value="{{ $team->id }}"
                                        {{ old('games.' . $key . '.away_id') == $team->id ? 'selected' : '' }}>
                                        {{ $team->name }}</option>
                                @endforeach
                            </select>
                            @error('games.' . $key . '.away_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6 mb-2">
                        <div class="form-group">
                            <label>Home Team
                                Score</label>
                            <input type="number"
                                name="games[${lastId}][home_score]"
                                class="form-control"
                                value="{{ old('games.' . $key . '.home_score') }}">
                            @error('games.' . $key . '.home_score')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6 mb-2">
                        <div class="form-group">
                            <label>Away Team
                                Score</label>
                            <input type="number"
                                name="games[${lastId}][away_score]"
                                class="form-control"
                                value="{{ old('games.' . $key . '.away_score') }}">
                            @error('games.' . $key . '.away_score')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-12 mb-2">
                        <div class="form-group">
                            <label>Match Date</label>
                            <input type="date" name="games[${lastId}][date]"
                                class="form-control"
                                value="{{ old('games.' . $key . '.date') }}">
                            @error('games.' . $key . '.date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                `;

                $('#cover').append(newRow);
            });
        });
    </script>
@endsection
