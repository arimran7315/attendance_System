@extends('masterLayout.layout')
@section('title')
    Home Page
@endsection
@section('content')
    <div class="card pb-4 px-0">
        <div class="card-header text-center bg-info bg-opacity-25">
            <h4 class="text-info">
                @can('isAdmin')
                Attendance of {{$user->name}}
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
                    <th>
                        ID
                    </th>
                    <th>
                        Status
                    </th>
                    <th>
                        Date
                    </th>
                    <th>
                        Edit
                    </th>
                    <th>
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                 @foreach($user->attendances as $attendance)
                    <tr>
                        <td>
                            {{$user->id}}
                        </td>
                        <td>
                            @if ($attendance->status == 1)
                                Present
                            @elseif ($attendance->status == 2)
                                Leave
                            @else
                                Absent
                            @endif
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($attendance->created_at)->format('Y-F-d') }}
                        </td>
                        <td>
                            <x-form action="{{ route('attendance.update', $attendance->id) }}">
                                @method('PUT')
                                <select name="status" class="form-select">
                                    <option value="0" {{ $attendance->status == 0 ? 'selected' : '' }}>Absent</option>
                                    <option value="1" {{ $attendance->status == 1 ? 'selected' : '' }}>Present</option>
                                    <option value="2" {{ $attendance->status == 2 ? 'selected' : '' }}>Leave</option>
                                </select>
                            </td>
                            <td>
                                <button type="submit" class="btn btn-warning">Update</button>
                            </x-form>
                            <x-form action="{{ route('attendance.destroy', $attendance->id) }}" >
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </x-form>
                    </tr>
                @endforeach
            </tbody>
           </table>
        </div>
    </div>
@endsection
