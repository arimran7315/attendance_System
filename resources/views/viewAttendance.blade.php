@extends('masterLayout.layout')
@section('title')
    Home Page
@endsection
@section('content')
<div class="container">
    <div class="row">
        <form method="GET" action="{{route('attendance.report')}}" class="row row-cols-lg-auto g-2 align-items-center mb-3">
            @csrf
            <input type="hidden" name="id" value="{{$user->id}}">
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
                @can('isAdmin')
                    Attendance of {{ $user->name }}
                @endcan
                @cannot('isAdmin')
                    Your Attendance Record
                @endcannot
            </h4>
        </div>
        <div class="card-body mt-4">
            <table class="table">
                <thead class=" table-dark">
                    <tr>
                        <th>Id</th>
                        <th>
                            Name
                        </th>
                        <th>
                            Status
                        </th>
                        <th>
                            Date
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $count = 0;
                        $absent = 0;
                        $present = 0;
                        $leave = 0;
                    @endphp
                    @foreach ($user->attendances as $attendance)
                        <tr>
                            @php
                                $count++;
                            @endphp
                            <td>
                                @php
                                    echo $count;
                                @endphp
                            </td>
                            <td>
                                {{ $user->name }}
                            </td>
                            <td>
                                @if ($attendance->status == 1)
                                    Present
                                    @php
                                        $present++;
                                    @endphp
                                @elseif ($attendance->status == 2)
                                    Leave
                                    @php
                                        $leave++;
                                    @endphp
                                @else
                                    @php
                                        $absent++;
                                    @endphp
                                    Absent
                                @endif
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($attendance->created_at)->format('Y-F-d') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-secondary bg-opacity-25">
                    <tr>
                        <th>
                            <b>Total Presents</b> : @php
                                echo $present;
                            @endphp
                        </th>
                        <th>
                            <b>Total Absents</b> : @php
                                echo $absent;
                            @endphp
                        </th>
                        <th>
                            <b>Total Leaves</b> : @php
                                echo $leave;
                            @endphp
                        </th>
                        <th>
                            <b>Total Lectures</b> : @php
                                echo $count;
                            @endphp
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection