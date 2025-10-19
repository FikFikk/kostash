<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Visit;
use Illuminate\Http\Request;

class VisitController extends Controller
{
    /**
     * Display a paginated listing of visits for admin.
     */
    public function index(Request $request)
    {
        $perPage = (int) $request->get('per_page', 20);

        $query = Visit::query()->orderBy('date', 'desc');

        // Simple search by ip or url
        if ($q = $request->get('q')) {
            $query->where(function ($sub) use ($q) {
                $sub->where('ip', 'like', "%{$q}%")
                    ->orWhere('url', 'like', "%{$q}%")
                    ->orWhere('user_agent', 'like', "%{$q}%");
            });
        }

        $visits = $query->paginate($perPage)->withQueryString();

        // Heuristic: mark suspicious when accept_language is missing or ip repeated several times in short list
        $ipCounts = [];
        foreach ($visits as $v) {
            $ipCounts[$v->ip] = ($ipCounts[$v->ip] ?? 0) + 1;
        }

        // Build a label map for UI: small heuristic labels + badge classes
        $labels = [];
        $languages = [];

        // simple map of language codes to Indonesian-friendly names
        $langMap = [
            'id' => 'Bahasa Indonesia',
            'en' => 'Inggris',
            'fr' => 'Perancis',
            'zh' => 'Mandarin',
            'ja' => 'Jepang',
            'de' => 'Jerman',
            'es' => 'Spanyol',
        ];

        foreach ($visits as $v) {
            $labelText = null;
            $labelClass = 'badge bg-secondary';

            $ua = $v->user_agent ?? '';
            $ipCount = $ipCounts[$v->ip] ?? 0;

            if (empty($v->accept_language)) {
                $labelText = 'Bahasa tidak diketahui';
                $labelClass = 'badge bg-warning text-dark';
            } elseif (preg_match('/bot|spider|crawl|curl|wget|python-requests/i', $ua)) {
                $labelText = 'Robot / Bot';
                $labelClass = 'badge bg-danger';
            } elseif ($ipCount > 5) {
                $labelText = 'Sering dikunjungi';
                $labelClass = 'badge bg-info text-dark';
            }

            // friendly language display
            $friendly = null;
            if (!empty($v->accept_language)) {
                // take the first language token like 'en-US' => 'en'
                $parts = preg_split('/[,;\-]/', $v->accept_language);
                if (!empty($parts[0])) {
                    $code = strtolower(substr(trim($parts[0]), 0, 2));
                    $friendly = $langMap[$code] ?? strtoupper($code);
                }
            }

            $labels[$v->id] = ['text' => $labelText, 'class' => $labelClass];
            $languages[$v->id] = $friendly ? "$friendly ({$v->accept_language})" : ($v->accept_language ?: null);
        }

        return view('dashboard.admin.visits.index', compact('visits', 'ipCounts', 'labels', 'languages'));
    }

    /**
     * Show a single visit detail.
     */
    public function show(Visit $visit)
    {
        return view('dashboard.admin.visits.show', compact('visit'));
    }

    /**
     * Remove the specified visit.
     */
    public function destroy(Visit $visit)
    {
        $visit->delete();
        return redirect()->route('dashboard.visits.index')->with('success', 'Visit removed');
    }
}
