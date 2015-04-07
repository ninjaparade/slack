@extends('layouts/default')

{{-- Page title --}}
@section('title')
@parent
{{{ trans("action.{$mode}") }}} {{ trans('ninjaparade/slack::slackevents/common.title') }}
@stop

{{-- Queue assets --}}
{{ Asset::queue('validate', 'platform/js/validate.js', 'jquery') }}
{{ Asset::queue('selectize', 'selectize/js/selectize.js', 'jquery') }}
{{ Asset::queue('selectize', 'selectize/css/selectize.bootstrap3.css', 'styles') }}

{{-- Inline scripts --}}
@section('scripts')
<script>
	$('#channel').selectize({
		sortField: 'text'
	});
</script>
@parent
@stop

{{-- Inline styles --}}
@section('styles')
@parent
@stop

{{-- Page --}}
@section('page')

<section class="panel panel-default panel-tabs">

	{{-- Form --}}
	<form id="content-form" action="{{ request()->fullUrl() }}" role="form" method="post" data-parsley-validate>

		{{-- Form: CSRF Token --}}
		<input type="hidden" name="_token" value="{{ csrf_token() }}">

		<header class="panel-heading">

			<nav class="navbar navbar-default navbar-actions">

				<div class="container-fluid">

					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#actions">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>

						<ul class="nav navbar-nav navbar-cancel">
							<li>
								<a class="tip" href="{{ route('admin.ninjaparade.slack.slackevents.all') }}" data-toggle="tooltip" data-original-title="{{{ trans('action.cancel') }}}">
									<i class="fa fa-reply"></i> <span class="visible-xs-inline">{{{ trans('action.cancel') }}}</span>
								</a>
							</li>
						</ul>

						<span class="navbar-brand">{{{ trans("action.{$mode}") }}} <small>{{{ $slackevent->exists ? $slackevent->id : null }}}</small></span>
					</div>

					{{-- Form: Actions --}}
					<div class="collapse navbar-collapse" id="actions">

						<ul class="nav navbar-nav navbar-right">

							@if ($slackevent->exists)
							<li>
								<a href="{{ route('admin.ninjaparade.slack.slackevents.delete', $slackevent->id) }}" class="tip" data-action-delete data-toggle="tooltip" data-original-title="{{{ trans('action.delete') }}}" type="delete">
									<i class="fa fa-trash-o"></i> <span class="visible-xs-inline">{{{ trans('action.delete') }}}</span>
								</a>
							</li>
							@endif

							<li>
								<button class="btn btn-primary navbar-btn" data-toggle="tooltip" data-original-title="{{{ trans('action.save') }}}">
									<i class="fa fa-save"></i> <span class="visible-xs-inline">{{{ trans('action.save') }}}</span>
								</button>
							</li>

						</ul>

					</div>

				</div>

			</nav>

		</header>

		<div class="panel-body">

			<div role="tabpanel">

				{{-- Form: Tabs --}}
				<ul class="nav nav-tabs" role="tablist">
					<li class="active" role="presentation"><a href="#general" aria-controls="general" role="tab" data-toggle="tab">{{{ trans('ninjaparade/slack::slackevents/common.tabs.general') }}}</a></li>
					<li role="presentation"><a href="#attributes" aria-controls="attributes" role="tab" data-toggle="tab">{{{ trans('ninjaparade/slack::slackevents/common.tabs.attributes') }}}</a></li>
				</ul>

				<div class="tab-content">
					{{-- Form: General --}}
					<div role="tabpanel" class="tab-pane fade in active" id="general">

						<fieldset>

							<div class="row">

								<div class="form-group{{ Alert::onForm('name', ' has-error') }}">

									<label for="name" class="control-label">
										<i class="fa fa-info-circle" data-toggle="popover" data-content="{{{ trans('ninjaparade/slack::slackevents/model.general.name_help') }}}"></i>
										{{{ trans('ninjaparade/slack::slackevents/model.general.name') }}}
									</label>

									<input type="text" class="form-control" name="name" id="name" placeholder="{{{ trans('ninjaparade/slack::slackevents/model.general.name') }}}" value="{{{ input()->old('name', $slackevent->name) }}}">

									<span class="help-block">{{{ Alert::onForm('name') }}}</span>

								</div>


								<div class="form-group{{ Alert::onForm('channel', ' has-error') }}">

									<label for="channel" class="control-label">
										<i class="fa fa-info-circle" data-toggle="popover" data-content="{{{ trans('ninjaparade/slack::slackevents/model.general.channel_help') }}}"></i>
										{{{ trans('ninjaparade/slack::slackevents/model.general.channel') }}}
									</label>
									
									<select class="form-control" name="channel[]" id="channel" required multiple>
									
										@foreach ($slackchannels as $channel)
											
											<option value="{{$channel->id}}" @if( in_array( $channel->id, array_pluck($slackevent->channels, 'id'))) selected="selected" @endif>{{$channel->name}}</option>
										@endforeach
										
									</select>
								
								<span class="help-block">{{{ Alert::onForm('channel') }}}</span>

								</div>

			


							</div>

						</fieldset>

					</div>

					{{-- Form: Attributes --}}
					<div role="tabpanel" class="tab-pane fade" id="attributes">
						@attributes($slackevent)
					</div>

				</div>

			</div>

		</div>

	</form>

</section>
@stop


