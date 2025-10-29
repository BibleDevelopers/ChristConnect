<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Donation;
use App\Models\DonationOption;

class DonationController extends Controller
{
    public function index()
    {
        // If not logged in → redirect to login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $donations = Donation::with('options')->get();
        return view('donations.index', compact('donations'));
    }

    public function create()
    {
        // Create donation box (admin only)
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('donations.index')->with('error', 'Unauthorized');
        }

        return view('donations.create');
    }

    public function store(Request $request)
    {
        // Only admins may create donation boxes
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('donations.index')->with('error', 'Unauthorized');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'goal_amount' => 'required|numeric|min:1',
            'options' => 'nullable|string', // newline-separated label|amount or amount
        ]);

        DB::transaction(function () use ($request, &$donation) {
            $donation = Donation::create([
                'title' => $request->title,
                'description' => $request->description,
                'goal_amount' => $request->goal_amount,
                'collected_amount' => 0,
            ]);

            // parse options textarea (admin convenience)
            $optionsInput = $request->input('options', '');
            if (!empty($optionsInput)) {
                $lines = preg_split('/\r\n|\r|\n/', $optionsInput);
                foreach ($lines as $line) {
                    $line = trim($line);
                    if ($line === '') continue;

                    if (strpos($line, '|') !== false) {
                        [$label, $amount] = array_map('trim', explode('|', $line, 2));
                    } else {
                        $label = null;
                        $amount = $line;
                    }

                    $amount = preg_replace('/[^0-9.]/', '', $amount);
                    if ($amount === '') continue;

                    DonationOption::create([
                        'donation_id' => $donation->id,
                        'label' => $label,
                        'amount' => $amount,
                    ]);
                }
            }
        });

        return redirect()->route('donations.index')->with('success', 'Donation box created!');
    }

    public function edit(Donation $donation)
    {
        // Admin only
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('donations.index')->with('error', 'Unauthorized');
        }

        $donation->load('options');
        return view('donations.edit', compact('donation'));
    }


    public function donate(Request $request, Donation $donation)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        // WALLET CHECK DISINI -Jep
        $donation->collected_amount += $request->amount;
        $donation->save();

        return redirect()->route('donations.index')->with('success', 'Thank you for your donation!');
    }


    public function update(Request $request, Donation $donation)
    {
        // Admin only
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('donations.index')->with('error', 'Unauthorized');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'goal_amount' => 'required|numeric|min:1',
            'options' => 'nullable|array',
            'options.*.id' => 'nullable|integer|exists:donation_options,id',
            'options.*.label' => 'nullable|string|max:255',
            'options.*.amount' => 'required_with:options.*|numeric|min:0.01',
            'options.*._delete' => 'nullable|boolean',
        ]);

        DB::transaction(function () use ($request, $donation) {
            $donation->update([
                'title' => $request->title,
                'description' => $request->description,
                'goal_amount' => $request->goal_amount,
            ]);

            $options = $request->input('options', []);
            foreach ($options as $opt) {
                // delete existing
                if (!empty($opt['_delete']) && !empty($opt['id'])) {
                    DonationOption::where('id', $opt['id'])->where('donation_id', $donation->id)->delete();
                    continue;
                }

                // update existing
                if (!empty($opt['id'])) {
                    DonationOption::where('id', $opt['id'])->where('donation_id', $donation->id)
                        ->update([
                            'label' => $opt['label'] ?? null,
                            'amount' => $opt['amount'],
                        ]);
                    continue;
                }

                // create new
                if (empty($opt['_delete'])) {
                    if (!empty($opt['amount'])) {
                        DonationOption::create([
                            'donation_id' => $donation->id,
                            'label' => $opt['label'] ?? null,
                            'amount' => $opt['amount'],
                        ]);
                    }
                }
            }
        });

        return redirect()->route('donations.index')->with('success', 'Donation updated.');
    }
}
