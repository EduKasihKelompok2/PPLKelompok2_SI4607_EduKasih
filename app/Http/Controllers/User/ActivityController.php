<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index()
    {
        $activities = Activity::where('user_id', auth()->id())
            ->filter(request()->all())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.activity', compact('activities'));
    }

    public function destroy($id)
    {
        $activity = Activity::findOrFail($id);
        $activity->delete();

        return redirect()->back()->with('success', 'Activity deleted successfully.');
    }
}
