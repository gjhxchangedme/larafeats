<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DummyRequest;

class TestController extends Controller
{
    public function index(DummyRequest $request)
    {
        return json_encode([
            'message' => 'Successfully parsed request',
            'code' => 200,
            'status' => 'success',
            'payload' => []
        ]);
    }
}
