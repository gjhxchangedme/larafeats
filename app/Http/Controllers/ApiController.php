<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
	/**
	 * Show page for testing api
	 *
	 * @return mixed
	 */
    public function index()
	{
		return response()
			->json([
				'status' => 'success',
				'message' => 'Hello! This is a data from the api',
			]);
	}

	/**
	 * Authenticate user
	 *
	 * @return mixed
	 */
	public function login(Request $request)
	{
		$status = 'fail';
		$message = 'Invalid user';

		if ($request->username == 'user' && $request->password == 'user') {
			return response()->json([
				'status' => 'success',
				'message' => 'Successfully authenticated user.',
				'payload' => [
					'authkey' => 'thisisanexampleauthenticationkey',
				],
			]);
		}

		return response()->json([
			'status' => 'fail',
			'message' => 'Invalid user.',
			'guide' => 'This api accepts 2 parameters; username and password. Username must be user and password must be user'
		]);
	}


	/**
	 * Logged out
	 *
	 * @return mixed
	 */
	public function logout(Request $request)
	{
		$authKey = str_replace('Bearer ', '', $request->header('Authorization'));
		if ($authKey == 'thisisanexampleauthenticationkey') {
			return response()->json([
				'status' => 'success',
				'message' => 'Successfully logged out.',
			]);
		}

		return response()->json([
			'status' => 'fail',
			'message' => 'Invalid user.',
			'guide' => 'This api needs authorization token. Please pass thisisanexampleauthenticationkey as authorization token.'
		]);
	}

	/**
	 * Fetch content from dashboard
	 *
	 * @param Request $request
	 * @return mixed
	 */
	public function dashboard(Request $request)
	{
		$authKey = str_replace('Bearer ', '', $request->header('Authorization'));
		if ($authKey == 'thisisanexampleauthenticationkey') {
			return response()->json([
				'status' => 'success',
				'message' => 'Successfully authenticated user.',
				'data' => [
					'rate' => 10.23,
				],
			]);
		}

		return response()->json([
			'status' => 'fail',
			'message' => 'Invalid user.',
			'guide' => 'This api needs authorization token. Please pass thisisanexampleauthenticationkey as authorization token.'
		]);
	}
}
