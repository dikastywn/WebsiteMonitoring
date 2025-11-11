<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sensor;

class SensorController extends Controller
{
    // Menampilkan dashboard utama
    public function index()
    {
        $sensor = Sensor::latest()->first();
        return view('dashboard', compact('sensor'));
    }

    // API untuk ambil data terbaru
    public function getLatestData()
    {
        return response()->json(Sensor::latest()->first());
    }

    // API untuk ambil data grafik
    public function getChartData()
    {
        $data = Sensor::orderBy('created_at', 'desc')->take(20)->get()->reverse()->values();
        return response()->json($data);
    }
}
