<?php

namespace App\Http\Controllers;

use App\Models\Template;
use App\Models\Website;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function __invoke(): View
    {
        $websites = Website::with('template')->latest()->get();
        $templates = Template::withCount('websites')->get();
        $totalVisits = $websites->sum('visit_count');
        $totalWebsites = $websites->count();

        $templateUsage = $templates->map(function (Template $template) use ($totalWebsites): array {
            return [
                'name' => $template->nama_template,
                'count' => $template->websites_count,
                'percentage' => $totalWebsites > 0 ? round(($template->websites_count / $totalWebsites) * 100) : 0,
            ];
        });

        return view('admin', [
            'websites' => $websites,
            'templates' => $templates,
            'templateUsage' => $templateUsage,
            'totalVisits' => $totalVisits,
            'totalWebsites' => $totalWebsites,
        ]);
    }
}
