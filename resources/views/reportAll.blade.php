@extends('masterLayout.layout')
@section('title')
    Home Page
@endsection
@section('content')
    <div class="card pb-4 px-0">
        <div class="card-header text-center bg-info bg-opacity-25">
            <h4 class="text-info">
                @can('isAdmin')
                    Data from: <b class="text-primary"> {{ \Carbon\Carbon::parse($from)->format('d-M-Y') }} </b>to: <b class="text-primary">{{ \Carbon\Carbon::parse($to)->format('d-M-Y') }}</b>
                @endcan
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
                            Email
                        </th>
                        <th>
                            P
                        </th>
                        <th>
                            A
                        </th>
                        <th>
                            L
                        </th>
                        <th>
                            Grade
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
                    @foreach ($user as $u)
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
                                {{ $u->name }}
                            </td>
                            <td>
                                {{ $u->email }}
                            </td>
                            <td>
                                @foreach ($attendance as $a)
                                    @if ($u->id == $a->user_id)
                                       @if ($a->status == '1' && $a->status != '2' && $a->status != '0')
                                          @php
                                               $present++;
                                          @endphp
                                       @endif
                                    @endif
                                @endforeach
                                @php
                                    if($present == 0){
                                        echo '0';
                                    }else{
                                        echo $present;
                                        $present = 0;
                                    }
                                @endphp
                            </td>
                            <td>
                                @foreach ($attendance as $a)
                                @if ($u->id == $a->user_id)
                                   @if ($a->status != '1' && $a->status != '2' && $a->status == '0')
                                      @php
                                           $absent++;
                                      @endphp
                                   @endif
                                @endif
                            @endforeach
                            @php
                                if($absent == 0){
                                    echo '0';
                                }else{
                                    echo $absent;
                                    $absent = 0;
                                }
                            @endphp
                            </td>
                            <td>
                                @foreach ($attendance as $a)
                                @if ($u->id == $a->user_id)
                                   @if ($a->status != '1' && $a->status == '2' && $a->status != '0')
                                      @php
                                           $leave++;
                                      @endphp
                                   @endif
                                @endif
                            @endforeach
                            @php
                                if($leave == 0 && $leave == null){
                                    echo '0';
                                }else{
                                    echo $leave;
                                    $leave = 0;
                                }
                            @endphp
                            </td>
                            <td>
                                @php if ($present >= 26) {
                                    echo "A";
                                } else if ($present < 26 && $present >= 20) {
                                    echo "B";
                                } else if ($present < 20 && $present >= 15) {
                                    echo "C";
                                } else if ($present < 15 && $present >= 10) {
                                    echo "D";
                                } else {
                                    echo "F";
                                }
                                @endphp
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
@endsection
