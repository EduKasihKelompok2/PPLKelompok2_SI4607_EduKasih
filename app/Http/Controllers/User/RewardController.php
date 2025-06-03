<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Reward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RewardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $rewards = Reward::with(['badge'])
            ->when($request->get('search'), function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        
        $userHighestBadgeId = $user->badges()->max('badge_id') ?? 0;

        
        $claimedRewards = $user->claimedRewards()->pluck('reward_id')->toArray();

        return view('user.rewards', compact('rewards', 'userHighestBadgeId', 'claimedRewards'));
    }

    public function claim($rewardId)
    {
        $user = auth()->user();
        $reward = Reward::with('badge')->findOrFail($rewardId);

        
        if ($user->hasClaimedReward($rewardId)) {
            return redirect()->back()->with('error', 'You have already claimed this reward.');
        }

        
        if (!$user->canClaimReward($reward)) {
            $badgeName = $reward->badge ? $reward->badge->name : 'Unknown';
            return redirect()->back()->with('error', "You need the '{$badgeName}' badge to claim this reward.");
        }

        
        DB::table('claimed_rewards')->insert([
            'user_id' => $user->id,
            'reward_id' => $reward->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Reward claimed successfully!');
    }

    public function download($rewardId)
    {
        $user = auth()->user();
        $reward = Reward::findOrFail($rewardId);

        
        if (!$user->hasClaimedReward($rewardId)) {
            return redirect()->back()->with('error', 'You must claim this reward before downloading.');
        }

        
        if (!$reward->file_path || !Storage::disk('public')->exists($reward->file_path)) {
            return redirect()->back()->with('error', 'File not found.');
        }

        $filePath = storage_path('app/public/' . $reward->file_path);
        $fileName = basename($reward->file_path);

        return response()->download($filePath, $fileName);
    }
}