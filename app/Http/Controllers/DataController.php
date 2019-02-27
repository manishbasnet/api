<?php

namespace App\Http\Controllers;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Excel;

class DataController extends Controller
{
    // Create json data from file
    public function createJSONData()
    {
        // Read data from file
        $data = [];
        if(Storage::disk('public')->exists('Codetest.xlsx')) {
            $path = storage_path('app/public/Codetest.xlsx');
        } else {
            $path = resource_path() . '/assets/Codetest.xlsx';
        }
        if ($path) {
            $getExcelData = Excel::load($path, function($reader) {
            })->get();
            if(!empty($getExcelData) && $getExcelData->count()){
                $jsonData = [];
                foreach ($getExcelData as $key => $value) {
                    if($value->id != null) {
                        $jsonData[] = [
                            "id" => $value->id,
                            "category" => $value->category,
                            "risk_profile" => $value->risk_profile,
                            "name" => $value->name,
                            "naics_code" => $value->naics_code,
                            "iso_gl_code" => $value->iso_gl_code,
                            "wc_codes" => $value->wc_codes,
                            "min_coverage" => $value->min_coverage,
                            "other_coverage" => $value->other_coverage

                        ];
                    }
                }
                $data['status'] = 'success';
                $data['data'] = $jsonData;
            }
        }else {
            $data['status'] = 'fail';
            $data['msg'] = 'File missing';
        }
        $response = json_encode($data);
        return $response;

    }

    public function getJSONData($profileId)
    {
        // Fetch data for profileId
        $getJSONData = $this->createJSONData();
        $data = json_decode($getJSONData);

        $getProfile = [];
        //dd($getProfile);
        if(isset($data->data) && !empty($data->data)) {
            foreach ($data->data as $row) {
                if((string)$row->id == $profileId) {
                    $getProfile = $row;
                }
            }
        }
        return $getProfile;
    }

    // Get Profile
    public function getProfile(Request $request)
    {
        if(!isset($request['id'])){
            $data['status'] ='fail';
            $data['msg'] = 'Id is required to view profile';

            $response = new JsonResponse($data);
            return $response;
        }
        $profileId = $request['id'];
        $profileData = $this->getJSONData($profileId);

        // Check if profileId exists in JSON Data
        if(empty($profileData)) {
            $data['status'] ='fail';
            $data['msg'] = 'Id does not exist';

            $response = new JsonResponse($data);
            return $response;
        }

        // Get data
        $result = [
            "category" => $profileData->category,
            "risk_profile" => $profileData->risk_profile,
            "name" => $profileData->name,
            "naics_code" => $profileData->naics_code,
            "iso_gl_code" => $profileData->iso_gl_code,
            "wc_codes" => $profileData->wc_codes,
            "min_coverage" => $profileData->min_coverage,
            "other_coverage" => $profileData->other_coverage
        ];

        $data['id'] = $profileData->id;
        $data['result'] = [$result];

        $response = new JsonResponse($data);
        return $response;
    }

}
