@extends('default')
@section('main')

{{ Notification::showAll() }}

<div class='row'>
<h2><p align='center'>{{$activity->name}}</p></h2><br>
</div>

<div class='row'>
<p align="center"><em>活动时间  {{$activity->start." ~ ".$activity->end}}</em></p>
</div>

<div class="col-md-offset-2 col-md-8 col-lg-8">
	
<P>
	{{$activity->policy}}

</P>
</div>

<div class="col-md-offset-2 col-md-4 col-lg-4">

	<a href='{{URL::route('login.confirm',['activity_id'=>$activity->id])}}' class='btn btn-success btn-small'>知晓并同意以上内容</a>

</div>

@stop