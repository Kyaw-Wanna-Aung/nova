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
        
        // admins ဇယားနှင့် updated_by ကို ဖြုတ်လိုက်ပြီဖြစ်၍ ဤနေရာမှ updated_by ကို ဖယ်ရှားလိုက်ပါပြီ
        $visionMission->update([
            $section => $data[$section]
        ]);

        return redirect()->route('admin.vision-mission.index')
            ->with('success', ucfirst($section).' updated successfully.');
    }
}