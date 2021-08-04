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
			->with('server', json_encode($_SERVER))
			->with('request', json_encode($request))
			->with('header', json_encode($request->header()))
			->with('original_ip_address', $this->getOriginalClientIp($request))
			->with('ip_address', $request->ip())
			->with('HTTP_CLIENT_IP', getenv('HTTP_CLIENT_IP'))
			->with('HTTP_X_FORWARDED_FOR', getenv('HTTP_X_FORWARDED_FOR'))
			->with('HTTP_X_FORWARDED', getenv('HTTP_X_FORWARDED'))
			->with('HTTP_FORWARDED_FOR', getenv('HTTP_FORWARDED_FOR'))
			->with('HTTP_FORWARDED', getenv('HTTP_FORWARDED'))
			->with('REMOTE_ADDR', getenv('REMOTE_ADDR'))
			->with('http_true_client_ip', $_SERVER['HTTP_TRUE_CLIENT_IP'] ?? '<Not Set>')
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
			return 'Not found';
		} else {
			$ips = is_array($xForwardedFor) ? $xForwardedFor : explode(', ', $xForwardedFor);
			$ip = $ips[0];
		}
		return $ip;
	}
}
