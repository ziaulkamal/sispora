<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Kemendagri\Districts;
use App\Models\Kemendagri\Provinces;
use App\Models\Kemendagri\Regencies;
use App\Models\Kemendagri\Villages;
use Illuminate\Http\Request;

class MendagriController extends Controller
{
    public function getProvinces()
    {
        $provinces = Provinces::all();
        return response()->json($provinces->pluck('id', 'name'));
    }

    /**
     * Get regencies for a specific province.
     */
    public function getRegencies($provinceId)
    {
        // dd($provinceId);
        $regencies = Regencies::where('province_id', $provinceId)->get();
        return response()->json($regencies->pluck('id', 'name'));
    }

    /**
     * Get districts for a specific regency.
     */
    public function getDistricts($regencyId)
    {
        $districts = Districts::where('regency_id', $regencyId)->get();
        // dd($districts);
        return response()->json($districts->pluck('id', 'name'));
    }

    /**
     * Get villages for a specific district.
     */
    public function getVillages($districtId)
    {
        $district = Villages::where('district_id', $districtId)->get();
        return response()->json($district->pluck('id', 'name'));
    }

    public function getKontingens()
    {
        $regencies = Regencies::where('province_id', '11')->get();
        return response()->json($regencies->pluck('id', 'name'));
    }
}
