@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            {{ __('Games') }}
                            <a href="{{ route('games.create') }}" class="btn btn-sm btn-primary">
                                Tambah
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <th scope="col" class="text-end">Home</th>
                                    <th scope="col">Away</th>
                                </thead>
                                <tbody>
                                    @forelse ($results as $result)
                                        <tr>
                                            <td class="text-end">{{ $result->home_team?->name }}
                                                ({{ $result->home_score }})
                                            </td>
                                            <td>({{ $result->away_score }}) {{ $result->away_team?->name }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="text-center" colspan="2">Data tidak ada</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{ $results->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
