<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VisionMission;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class VisionMissionController extends Controller
{
    public function index(): View
    {
        return view('admin.vision-mission.index', [
            'visionMission' => VisionMission::query()->firstOrCreate(['id' => 1]),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $section = $request->validate(['section' => ['required', 'in:vision,mission']])['section'];
        $data = $request->validate([$section => ['required', 'string', 'min:20', 'max:5000']]);

        $visionMission = VisionMission::query()->firstOrCreate(['id' => 1]);
        $visionMission->update([$section => $data[$section], 'updated_by' => auth('admin')->id()]);

        return redirect()->route('admin.vision-mission.index')
            ->with('success', ucfirst($section).' updated successfully.');
    }
}
