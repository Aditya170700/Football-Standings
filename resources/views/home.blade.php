@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            {{ __('Klasemen') }}
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
                                    <th scope="col" style="width: 5%" class="text-center">No</th>
                                    <th scope="col">Klub</th>
                                    <th scope="col">Ma</th>
                                    <th scope="col">Me</th>
                                    <th scope="col">S</th>
                                    <th scope="col">K</th>
                                    <th scope="col">GM</th>
                                    <th scope="col">GK</th>
                                    <th scope="col">SG</th>
                                    <th scope="col">Point</th>
                                </thead>
                                <tbody>
                                    @forelse ($results as $result)
                                        <tr>
                                            <td style="width: 5%" class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $result->team?->name }}</td>
                                            <td>{{ $result->ma }}</td>
                                            <td>{{ $result->me }}</td>
                                            <td>{{ $result->s }}</td>
                                            <td>{{ $result->k }}</td>
                                            <td>{{ $result->gm }}</td>
                                            <td>{{ $result->gk }}</td>
                                            <td>{{ $result->sg }}</td>
                                            <td>{{ $result->point }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="text-center" colspan="10">Data tidak ada</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
