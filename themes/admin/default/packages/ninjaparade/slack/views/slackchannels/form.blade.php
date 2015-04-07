@extends('layouts/default')

{{-- Page title --}}
@section('title')
@parent
{{{ trans("action.{$mode}") }}} {{ trans('ninjaparade/slack::slackchannels/common.title') }}
@stop

{{-- Queue assets --}}
{{ Asset::queue('validate', 'platform/js/validate.js', 'jquery') }}
{{ Asset::queue('slugify', 'platform/js/slugify.js', 'jquery') }}

{{-- Inline scripts --}}
@section('scripts')
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
								<a class="tip" href="{{ route('admin.ninjaparade.slack.slackchannels.all') }}" data-toggle="tooltip" data-original-title="{{{ trans('action.cancel') }}}">
									<i class="fa fa-reply"></i> <span class="visible-xs-inline">{{{ trans('action.cancel') }}}</span>
								</a>
							</li>
						</ul>

						<span class="navbar-brand">{{{ trans("action.{$mode}") }}} <small>{{{ $slackchannel->exists ? $slackchannel->id : null }}}</small></span>
					</div>

					{{-- Form: Actions --}}
					<div class="collapse navbar-collapse" id="actions">

						<ul class="nav navbar-nav navbar-right">

							@if ($slackchannel->exists)
							<li>
								<a href="{{ route('admin.ninjaparade.slack.slackchannels.delete', $slackchannel->id) }}" class="tip" data-action-delete data-toggle="tooltip" data-original-title="{{{ trans('action.delete') }}}" type="delete">
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
					<li class="active" role="presentation"><a href="#general" aria-controls="general" role="tab" data-toggle="tab">{{{ trans('ninjaparade/slack::slackchannels/common.tabs.general') }}}</a></li>
					<li role="presentation"><a href="#attributes" aria-controls="attributes" role="tab" data-toggle="tab">{{{ trans('ninjaparade/slack::slackchannels/common.tabs.attributes') }}}</a></li>
				</ul>

				<div class="tab-content">

					{{-- Form: General --}}
					<div role="tabpanel" class="tab-pane fade in active" id="general">

						<fieldset>

							<div class="row">

								<div class="form-group{{ Alert::onForm('name', ' has-error') }}">

									<label for="name" class="control-label">
										<i class="fa fa-info-circle" data-toggle="popover" data-content="{{{ trans('ninjaparade/slack::slackchannels/model.general.name_help') }}}"></i>
										{{{ trans('ninjaparade/slack::slackchannels/model.general.name') }}}
									</label>
									<input type="text" class="form-control" name="name" id="name" data-slugify="#slug" placeholder="{{{ trans('ninjaparade/slack::slackchannels/model.general.name') }}}" value="{{{ input()->old('name', $slackchannel->name) }}}" required autofocus data-parsley-trigger="change">


									<span class="help-block">{{{ Alert::onForm('name') }}}</span>

								</div>

				<div class="form-group{{ Alert::onForm('slug', ' has-error') }}">

									<label for="slug" class="control-label">
										<i class="fa fa-info-circle" data-toggle="popover" data-content="{{{ trans('ninjaparade/slack::slackchannels/model.general.slug_help') }}}"></i>
										{{{ trans('ninjaparade/slack::slackchannels/model.general.slug') }}}
									</label>

									<input type="text" class="form-control" name="slug" id="slug" placeholder="{{{ trans('ninjaparade/slack::slackchannels/model.general.slug') }}}" value="{{{ input()->old('slug', $slackchannel->slug) }}}">

									<span class="help-block">{{{ Alert::onForm('slug') }}}</span>

								</div>

				<div class="form-group{{ Alert::onForm('webhook', ' has-error') }}">

									<label for="webhook" class="control-label">
										<i class="fa fa-info-circle" data-toggle="popover" data-content="{{{ trans('ninjaparade/slack::slackchannels/model.general.webhook_help') }}}"></i>
										{{{ trans('ninjaparade/slack::slackchannels/model.general.webhook') }}}
									</label>

									<textarea class="form-control" name="webhook" id="webhook" placeholder="{{{ trans('ninjaparade/slack::slackchannels/model.general.webhook') }}}">{{{ input()->old('webhook', $slackchannel->webhook) }}}</textarea>

									<span class="help-block">{{{ Alert::onForm('webhook') }}}</span>

								</div>

				<div class="form-group{{ Alert::onForm('send_as', ' has-error') }}">

									<label for="send_as" class="control-label">
										<i class="fa fa-info-circle" data-toggle="popover" data-content="{{{ trans('ninjaparade/slack::slackchannels/model.general.send_as_help') }}}"></i>
										{{{ trans('ninjaparade/slack::slackchannels/model.general.send_as') }}}
									</label>

									<input type="text" class="form-control" name="send_as" id="send_as" placeholder="{{{ trans('ninjaparade/slack::slackchannels/model.general.send_as') }}}" value="{{{ input()->old('send_as', $slackchannel->send_as) }}}">

									<span class="help-block">{{{ Alert::onForm('send_as') }}}</span>

								</div>

				<div class="form-group{{ Alert::onForm('default_icon', ' has-error') }}">

									<label for="send_as" class="control-label">
										<i class="fa fa-info-circle" data-toggle="popover" data-content="{{{ trans('ninjaparade/slack::slackchannels/model.general.default_icon_help') }}}"></i>
										{{{ trans('ninjaparade/slack::slackchannels/model.general.default_icon') }}}
									</label>

									<input type="text" class="form-control" name="default_icon" id="default_icon" placeholder="{{{ trans('ninjaparade/slack::slackchannels/model.general.default_icon') }}}" value="{{{ input()->old('default_icon', $slackchannel->default_icon) }}}">

									<span class="help-block">{{{ Alert::onForm('default_icon') }}}</span>

								</div>

				<div class="form-group{{ Alert::onForm('expand_media', ' has-error') }}">

									<label for="expand_media" class="control-label">
										<i class="fa fa-info-circle" data-toggle="popover" data-content="{{{ trans('ninjaparade/slack::slackchannels/model.general.expand_media_help') }}}"></i>
										{{{ trans('ninjaparade/slack::slackchannels/model.general.expand_media') }}}
									</label>

									<div class="checkbox">
										<label>
											<input type="hidden" name="expand_media" id="expand_media" value="0" checked>
											<input type="checkbox" name="expand_media" id="expand_media" @if($slackchannel->expand_media) }}}) checked @endif value="1"> {{ ucfirst('expand_media') }}
										</label>
									</div>

									<span class="help-block">{{{ Alert::onForm('expand_media') }}}</span>

								</div>

				<div class="form-group{{ Alert::onForm('expand_urls', ' has-error') }}">

									<label for="expand_media" class="control-label">
										<i class="fa fa-info-circle" data-toggle="popover" data-content="{{{ trans('ninjaparade/slack::slackchannels/model.general.expand_urls_help') }}}"></i>
										{{{ trans('ninjaparade/slack::slackchannels/model.general.expand_urls') }}}
									</label>

									<div class="checkbox">
										<label>
											<input type="hidden" name="expand_urls" id="expand_urls" value="0" checked>
											<input type="checkbox" name="expand_urls" id="expand_urls" @if($slackchannel->expand_urls) }}}) checked @endif value="1"> {{ ucfirst('expand_urls') }}
										</label>
									</div>

									<span class="help-block">{{{ Alert::onForm('expand_urls') }}}</span>

								</div>


				<div class="form-group{{ Alert::onForm('default', ' has-error') }}">

									<label for="default" class="control-label">
										<i class="fa fa-info-circle" data-toggle="popover" data-content="{{{ trans('ninjaparade/slack::slackchannels/model.general.default_help') }}}"></i>
										{{{ trans('ninjaparade/slack::slackchannels/model.general.default') }}}
									</label>

									<div class="checkbox">
										<label>
											<input type="hidden" name="default" id="default" value="0" checked>
											<input type="checkbox" name="default" id="default" @if($slackchannel->default) }}}) checked @endif value="1"> {{ ucfirst('default') }}
										</label>
									</div>

									<span class="help-block">{{{ Alert::onForm('default') }}}</span>

								</div>

				<div class="form-group{{ Alert::onForm('active', ' has-error') }}">

									<label for="active" class="control-label">
										<i class="fa fa-info-circle" data-toggle="popover" data-content="{{{ trans('ninjaparade/slack::slackchannels/model.general.active_help') }}}"></i>
										{{{ trans('ninjaparade/slack::slackchannels/model.general.active') }}}
									</label>

									<div class="checkbox">
										<label>
											<input type="hidden" name="active" id="active" value="0" checked>
											<input type="checkbox" name="active" id="active" @if($slackchannel->active) }}}) checked @endif value="1"> {{ ucfirst('active') }}
										</label>
									</div>

									<span class="help-block">{{{ Alert::onForm('active') }}}</span>

								</div>


							</div>

						</fieldset>

					</div>

					{{-- Form: Attributes --}}
					<div role="tabpanel" class="tab-pane fade" id="attributes">
						@attributes($slackchannel)
					</div>

				</div>

			</div>

		</div>

	</form>

</section>
@stop
