@extends('masterLayout.layout')
@section('title')
    Home Page
@endsection
@section('content')

    @cannot('isAdmin')
        <div class="card pb-4 px-0">
            <div class="card-header text-center bg-info bg-opacity-25">
                <h4 class="text-info">
                    Marked Attendance
                </h4>
            </div>
            <div class="card-body">
                @if ($status)
                    <div class="row-sm mt-4 text-center">
                        <button disabled class="btn btn-primary">
                            Present
                        </button>

                    </div>

                    <div class="row-sm mt-4 text-center">
                        <button disabled class="btn btn-success">
                            Leave
                        </button>
                    </div>
                @else
                    <div class="row-sm mt-4 text-center">

                        <x-form action="{{ route('attendance.store') }}">
                            <button class="btn btn-primary" name="attendance" value="p" type="submit">
                                Present
                            </button>
                        </x-form>
                    </div>
                    <div class="row-sm mt-4 text-center">
                        <x-form action="{{ route('attendance.store') }}">
                            <button class="btn btn-success" name="attendance" value="l" type="submit">
                                Leave
                            </button>
                        </x-form>
                    </div>
                @endif
            </div>

        </div>
    @endcannot

    @can('isAdmin')
        <div class="container">
            <div class="row">
                <form method="GET" action="{{route('attendance.reportAll')}}" class="row row-cols-lg-auto g-2 align-items-center mb-3">
                    @csrf
                    <div class="col-12">
                        <label class="pt-3">
                            <h5><strong>From:</strong></h5>
                        </label>
                    </div>
                    <div class="col-12">
                        <input type="date" name="Datefrom" class="form-control">
                    </div>
                    <div class="col-12">
                        <label class="pt-3">
                            <h5><strong>To:</strong></h5>
                        </label>
                    </div>
                    <div class="col-12">
                        <input type="date" name="Dateto" class="form-control">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card pb-4 px-0">
            <div class="card-header text-center bg-info bg-opacity-25">
                <h4 class="text-info">
                    All Users
                </h4>
            </div>
            <div class="card-body mt-4">
                <table class="table">
                    <thead class=" table-dark">
                        <tr>
                            <th>
                                Roll #
                            </th>
                            <th>
                                Name
                            </th>
                            <th>
                                Email
                            </th>
                            <th>
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>
                                    {{ $user->id }}
                                </td>
                                <td>
                                    {{ $user->name }}
                                </td>
                                <td>
                                    {{ $user->email }}
                                </td>
                                <td>
                                    <a href="{{ route('attendance.edit', $user->id) }}" class="btn btn-success"> Edit </a>
                                    <a href="{{ route('attendance.show', $user->id) }}" class="btn btn-warning"> Generate
                                        Report </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endcan
@endsection
