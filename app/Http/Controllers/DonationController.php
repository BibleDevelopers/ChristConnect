<?php

namespace App\Http\Controllers;

use App\Services\BadgeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Donation;

use App\Models\User;
use App\Models\Badge;
use App\Models\Transaction;

class DonationController extends Controller
{
    private BadgeService $badgeService;

    public function __construct(BadgeService $badgeService)
    {
        $this->badgeService = $badgeService;
    }

    public function index()
    {
        
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $donations = Donation::all();
        return view('donations.index', compact('donations'));
    }

    public function create()
    {
        
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('donations.index')->with('error', 'Unauthorized');
        }

        return view('donations.create');
    }

    public function store(Request $request)
    {
        
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('donations.index')->with('error', 'Unauthorized');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'goal_amount' => 'required|numeric|min:1',
        ]);

        $donation = Donation::create([
            'title' => $request->title,
            'description' => $request->description,
            'goal_amount' => $request->goal_amount,
            'collected_amount' => 0,
        ]);

        return redirect()->route('donations.index')->with('success', 'Donation box created!');
    }

    public function edit(Donation $donation)
    {
        
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('donations.index')->with('error', 'Unauthorized');
        }

        return view('donations.edit', compact('donation'));
    }

    public function detail(Donation $donation)
    {
        
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('donations.index')->with('error', 'Unauthorized');
        }

        
        $transactions = Transaction::where('donation_id', $donation->id)
            ->where('type', 'donation')
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('donations.detail', compact('donation', 'transactions'));
    }

    public function donate(Request $request, Donation $donation)
    {
        $request->validate([
            'amount' => 'required|integer|min:1000|max:1000000000',
        ]);

        $user = Auth::user();
        $amount = (int) $request->input('amount');
        if ($amount <= 0) {
            return back()->with('error', 'Jumlah donasi tidak valid.');
        }

        try {
            DB::transaction(function () use ($user, $amount, $donation) {
                
                
                $wallet = $user->wallet()->lockForUpdate()->first();

                
                if ($wallet->balance < $amount) {
                    
                    throw new \Exception('Saldo dompet Anda tidak mencukupi.');
                }

                
                $wallet->decrement('balance', $amount);

                
                $user->transactions()->create([
                    'donation_id' => $donation->id,
                    'type' => 'donation',
                    'amount' => -$amount, 
                    'description' => 'Donasi untuk: ' . $donation->title
                ]);

                
                
                $donation->increment('collected_amount', $amount);

            }); 

        } catch (\Exception $e) {
            
            
            return redirect()->back()->with('error', $e->getMessage());
        }

        $user = $request->user();

        if ($user && $amount > 0) {
            $user->increment('total_donated', $amount);
            $user->refresh(); 
            $this->badgeService->syncDonationBadges($user);
        }

        
        return redirect()->route('donations.index')->with('success', 'Thank you for your donation!');
    }


    public function update(Request $request, Donation $donation)
    {
        
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('donations.index')->with('error', 'Unauthorized');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'goal_amount' => 'required|numeric|min:1',
        ]);

        $donation->update([
            'title' => $request->title,
            'description' => $request->description,
            'goal_amount' => $request->goal_amount,
        ]);

        return redirect()->route('donations.index')->with('success', 'Donation updated.');
    }
    
    public function destroy(Donation $donation)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('donations.index')->with('error', 'Unauthorized');
        }

        $donation->delete();

        return redirect()->route('donations.index')->with('success', 'Donation box deleted.');
    }
     
    private function checkAndAwardBadges(User $user)
    {
        
        $totalDonation = abs($user->transactions()->where('type', 'donation')->sum('amount'));

        
        $currentBadgeIds = $user->badges()->pluck('badges.id');

        
        $newBadges = Badge::where('min_donation', '<=', $totalDonation) 
                            ->whereNotIn('id', $currentBadgeIds)        
                            ->get();

        
        if ($newBadges->isNotEmpty()) {
            $user->badges()->attach($newBadges->pluck('id'));
            
            
            
        }
    }
}
