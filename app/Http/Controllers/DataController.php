<?php

namespace App\Http\Controllers;
use Illuminate\Http\JsonResponse;

use Illuminate\Http\Request;

class DataController extends Controller
{
    // Create json data from file
    public function createJSONData()
    {
        // Read data from file

        // Prepare JSON Format Data

    }

    public function getJSONData($profileId)
    {
        // Fetch data for profileId
    }

    // Get Profile
    public function getProfile($profileId)
    {
        // Check if profileId exists in JSON Data


        // Get data

        $result = [
            "category" => "cat1",
            "risk_profile" => "risk",
            "name" => "John",
            "naics_code" => "abc",
            "iso_gl_code" => "abc123",
            "wc_codes" => "wc123",
            "min_coverage" => "min cov",
            "other_coverage" => "other cov"
        ];

        $data['id'] = $profileId;
        $data['result'] = [$result];

        $response = new JsonResponse($data);
        return $response;
    }

}
