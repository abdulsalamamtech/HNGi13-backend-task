<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FactController extends Controller
{
    public function index()
    {

        $fact = $this->getCatFact();
        $user = $this->getUserInfo();
        $timestamp = now();

        
        // Field specifications:
        // status — Must always be the string "success"
        // user.email — Your personal email address
        // user.name — Your full name
        // user.stack — Your backend technology stack (e.g., "Node.js/Express", "Python/Django", "Go/Gin")
        // timestamp — Current UTC time in ISO 8601 format (e.g., "2025-10-15T12:34:56.789Z")
        // fact — A random cat fact fetched from the Cat Facts API
        // return json response with header

        return response()->json([
            'status' => 'success',
            'user' => $user,
            'timestamp' => $timestamp,
            'fact' => $fact
        ], 200, [
            'Content-Type' => 'application/json'
        ]);

    }

    private function getCatFact()
    {
        // using laravel http client with timeout of 5 seconds, and handling failure
        $response = Http::timeout(5)->get('https://catfact.ninja/fact');
        if ($response->failed()) {
            return 'Could not fetch cat fact at this time.';
        }

        $response = $response->json();

        if (!isset($response['fact'])) {
            return 'Could not fetch cat fact at this time.';
        }
        
        // return the fact from the response
        return $response['fact'];
    }

    private function getUserInfo()
    {
        return [
            'email' => 'abdulsalamamtech@gmail.com',
            'name' => 'Abdulsalam Abdulrahman',
            'stack' => 'PHP/Laravel'
        ];
    }


}
