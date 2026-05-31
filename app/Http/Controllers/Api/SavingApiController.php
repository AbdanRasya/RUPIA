<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SavingApiController extends Controller
{
    public function index() { return response()->json(['message' => 'Not implemented'], 501); }
    public function store(Request $request) { return response()->json(['message' => 'Not implemented'], 501); }
    public function show($id) { return response()->json(['message' => 'Not implemented'], 501); }
    public function update(Request $request, $id) { return response()->json(['message' => 'Not implemented'], 501); }
    public function destroy($id) { return response()->json(['message' => 'Not implemented'], 501); }
}
