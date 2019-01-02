@extends('layouts.app')

@section('content')
<div class="container">

    <form method="post" action="{{ route('fetch.client.ips') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <button type="submit">
            Find my IP Addresses
        </button>
    </form>

    <div class="panel">
        <div class="panel-body">
            @if(session()->has('request'))
                Request: <pre>{{ session('request') }}</pre> <br />
                Headers: <pre>{{ session('header') }}</pre>
                Custom Function: <pre>{{ session('original_ip_address') }}</pre> <br />
                Using $request->ip(): <pre>{{ session('ip_address') }}</pre> <br />
                Using $request->getClientIps() : <pre>{{ session('ip_addresses') }}</pre> <br />
                Session ID: <pre>{{ session()->getId() }}</pre><br/>
            @endif
        </div>
    </div>
</div>
@endsection
