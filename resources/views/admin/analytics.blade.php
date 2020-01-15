@extends('layouts.admin')

@section('body')


<div class="table-responsive">

    <h2>Coming Soon</h2>
    <p>In the mean while, make use of google analytics site </p>

    <p> Request login details from Jason/Shane Linden </p>
    <a
        href="https://analytics.google.com/analytics/web/provision/?authuser=0#/realtime/rt-location/a147755764w209861901p201821608/">
        link to AlphaReact Analytiscs</a>
    {{csrf_field()}}
</div> @endsection