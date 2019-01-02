@extends('layouts.app')

@section('content')
<div class="container">

    <form method="post" action="{{ route('fetch.client.ips') }}">
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
                        <h3>Request</h3>
                        <h5>Code Used:</h5>
                        <pre> $request </pre>
                        <h5>Result</h5>
                        <pre>{{ session('request') }}</pre>
                    </li>

                    <li>
                        <h3 class="list-header">Headers</h3>
                        <h5>Code Used:</h5>
                        <pre>$request->header()</pre>
                        <h5>Result</h5>
                        <p class="pre-scrollable">{{ session('header') }}</p>
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
                                    // $ip = $request->ip();
                                    return 'Not found';
                                } else {
                                    $ips = is_array($xForwardedFor) ? $xForwardedFor : explode(', ', $xForwardedFor);
                                    $ip = $ips[0];
                                }
                                return $ip;
                            }
                        </pre>
                        <h5>Result</h5>
                        <pre>{{ session('original_ip_address') }}</pre>
                    </li>

                    <li>
                        <h3>Using $request->ip()</h3>
                        <h5>Code Used:</h5>
                        <pre>$request->ip()</pre>
                        <h5>Result</h5>
                        <pre>{{ session('ip_address') }}</pre>
                    </li>

                    <li>
                        <h3>Using $request->getClientIps()</h3>
                        <h5>Code Used:</h5>
                        <pre>$request->getClientIps()</pre>
                        <h5>Result</h5>
                        <pre>{{ session('ip_addresses') }}</pre>
                    </li>

                    <li>
                        <h3>Session ID</h3>
                        <h5>Code Used:</h5>
                        <pre>session()->getId()</pre>
                        <h5>Result</h5>
                        <pre>{{ session()->getId() }}</pre>
                    </li>
                </ul>
            @endif
        </div>
    </div>
</div>
@endsection
