<link href="{{ asset('css/activity.css') }}" rel="stylesheet">
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <table class="logTable">
                    <tr class="headerRow">
                        <td class="headerRow"> Activity Type </td>
                        <td class="headerRow"> Content </td>
                        <td class="headerRow"> User </td>
                        <td class="headerRow"> Post </td>
                        <td class="headerRow"> Date </td>
                    </tr>
                    @foreach($activities as $activity)
                        <tr class="regularRow">
                            <td class="regularRow"> {{ $activity->activity_type }} </td>
                            <td class="regularRow"> {{ $activity->content }} </td>
                            <td class="regularRow"> {{ $activity->user_id }} </td>
                            <td class="regularRow"> {{ $activity->post_id }} </td>
                            <td class="regularRow"> {{ $activity->created_at }} </td>

                        </tr>


                    @endforeach

                </table>
            </div>
        </div>
    </div>
</div>

@endsection