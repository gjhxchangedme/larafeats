@extends('layouts.app')

@section('styles')
	<style>
		pre {outline: 1px solid #ccc; padding: 5px; margin: 5px; }
		.string { color: green; }
		.number { color: darkorange; }
		.boolean { color: blue; }
		.null { color: magenta; }
		.key { color: red; }
	</style>
@endsection

@section('content')
<div class="container">

	<form
		method="post" action="{{ route('fetch.client.ips') }}"
		id="fetch-ip-form"
		data-server="{{ session('server') }}"
		data-request="{{ session('request') }}"
		data-header="{{ session('header') }}"
		data-original-ip-address="{{ session('original_ip_address') }}"
		data-ip-address="{{ session('ip_address') }}"
		data-id="{{ session('id') }}">
		<input type="hidden" name="_token" value="{{ csrf_token() }}" />
		<button
			type="submit"
			class="btn btn-md btn-primary my-5">
			Find my IP Addresses
		</button>
	</form>

	<div class="panel">
		<div class="panel-body">
			@if(session()->has('request'))
				<ul class="list-unstyled">
					<li>
						<h3>Server</h3>
						<h5>Code Used:</h5>
						<pre> $_SERVER </pre>
						<h5>Result</h5>
						<p id="server-content"></p>
					</li>

					<li>
						<h3>Request</h3>
						<h5>Code Used:</h5>
						<pre> $request </pre>
						<h5>Result</h5>
						<p id="request-content"></p>
					</li>

					<li>
						<h3 class="list-header">Headers</h3>
						<h5>Code Used:</h5>
						<pre>$request->header()</pre>
						<h5>Result</h5>
						<p id="header-content"></p>
					</li>

					<li>
						<h3>Custom Functions</h3>
						<h5>Code Used:</h5>
						<pre>
							/**
							* Returns the original ip address of the
							* user
							*
							* @param Request $request
							* @return string
							*/
							function getOriginalClientIp(Request $request = null) : string
							{
								$request = $request ?? request();
								$xForwardedFor = $request->header('x-forwarded-for');
								if (empty($xForwardedFor)) {
									return 'Not found';
								} else {
									$ips = is_array($xForwardedFor) ? $xForwardedFor : explode(', ', $xForwardedFor);
									$ip = $ips[0];
								}
								return $ip;
							}
						</pre>
						<h5>Result</h5>
						<p id="original-ip-address-content"></p>
					</li>

					<li>
						<h3>Using $request->ip()</h3>
						<h5>Code Used:</h5>
						<pre>$request->ip()</pre>
						<h5>Result</h5>
						<p id="ip-address-content"></p>
					</li>

					<li>
						<h3>Using HTTP_TRUE_CLIENT_IP</h3>
						<h5>Code Used:</h5>
						<pre>$_SERVER['HTTP_TRUE_CLIENT_IP']</pre>
						<h5>Result</h5>
						<p>{{ session('http_true_client_ip') }}</p>
					</li>

					<li>
						<h3>Using $request->getClientIps()</h3>
						<h5>Code Used:</h5>
						<pre>$request->getClientIps()</pre>
						<h5>Result</h5>
						<p>{{ session('ip_addresses') }}</p>
					</li>

					<li>
						<h3>Session ID</h3>
						<h5>Code Used:</h5>
						<pre>session()->getId()</pre>
						<h5>Result</h5>
						<p id="id-content"></p>
					</li>
				</ul>
			@endif
		</div>
	</div>
</div>
@endsection

@section('scripts')
	<script type="text/javascript">
		function output(inp, form) {
			$(form).html('<pre>' + inp + '</pre>');
		}

		function syntaxHighlight(json) {
			if (json && json.length > 0) {

				json = json.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
				return json.replace(/("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g, function (match) {
					var cls = 'number';
					if (/^"/.test(match)) {
						if (/:$/.test(match)) {
							cls = 'key';
						} else {
							cls = 'string';
						}
					} else if (/true|false/.test(match)) {
						cls = 'boolean';
					} else if (/null/.test(match)) {
						cls = 'null';
					}
					return '<span class="' + cls + '">' + match + '</span>';
				});
			}

			return;
		}

		output(syntaxHighlight(JSON.stringify($('#fetch-ip-form').data('server'), undefined, 4)), '#server-content');
		output(syntaxHighlight(JSON.stringify($('#fetch-ip-form').data('request'), undefined, 4)), '#request-content');
		output(syntaxHighlight(JSON.stringify($('#fetch-ip-form').data('original-ip-address'), undefined, 4)), '#original-ip-address-content');
		output(syntaxHighlight(JSON.stringify($('#fetch-ip-form').data('header'), undefined, 4)), '#header-content');
		output(syntaxHighlight(JSON.stringify($('#fetch-ip-form').data('ip-address'), undefined, 4)), '#ip-address-content');
		output(syntaxHighlight(JSON.stringify($('#fetch-ip-form').data('id'), undefined, 4)), '#id-content');

	</script>
@endsection
