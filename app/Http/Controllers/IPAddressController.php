<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IPAddressController extends Controller
{
    /**
     * Shows the form for displaying the client
     * ip address
     *
     * @return Response
     */
    public function index()
    {
        return view('get_client_ips.index');
    }

    /**
     * Returns the request data with the ip address
     *
     * @return Response
     */
    public function store(Request $request)
    {
        return redirect()->route('client.ips')
        ->with('has_result' , true)
            ->with('request', json_encode($request))
            ->with('original_ip_address', $this->getOriginalClientIp($request))
            ->with('ip_address', $request->ip())
            ->with('ip_addresses', json_encode($request->getClientIps()));
    }

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
            return null;
        } else {
            $ips = is_array($xForwardedFor) ? $xForwardedFor : explode(', ', $xForwardedFor);
            $ip = $ips[0];
        }
        return $ip;
    }
}
