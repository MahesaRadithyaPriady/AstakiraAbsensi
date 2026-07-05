<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class ScanMachineController extends Controller
{
    private string $cameraIp;
    private string $cameraPort;

    public function __construct()
    {
        $this->cameraIp = config('camera.ip', '192.168.1.7');
        $this->cameraPort = config('camera.port', '8080');
    }

    public function index(): View
    {
        return view('scan.index', [
            'cameraIp' => $this->cameraIp,
            'cameraPort' => $this->cameraPort,
        ]);
    }

    public function snapshot()
    {
        try {
            $response = Http::timeout(5)->get("http://{$this->cameraIp}:{$this->cameraPort}/shot.jpg");

            if ($response->successful()) {
                return response($response->body(), 200, [
                    'Content-Type' => 'image/jpeg',
                    'Cache-Control' => 'no-cache, no-store, must-revalidate',
                    'Access-Control-Allow-Origin' => '*',
                ]);
            }

            return response()->json(['error' => 'Camera unavailable'], 502);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Cannot connect to camera: ' . $e->getMessage()], 502);
        }
    }
}
