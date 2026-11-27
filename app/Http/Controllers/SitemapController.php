<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Announcement;
use App\Models\Division;
use App\Models\Period;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $period = Period::current();

        $urls = collect([
            ['loc' => route('home'), 'lastmod' => now()->toAtomString(), 'priority' => '1.0'],
            ['loc' => route('about'), 'lastmod' => now()->toAtomString(), 'priority' => '0.8'],
            ['loc' => route('struktur'), 'lastmod' => now()->toAtomString(), 'priority' => '0.8'],
            ['loc' => route('divisi.index'), 'lastmod' => now()->toAtomString(), 'priority' => '0.8'],
            ['loc' => route('proker.index'), 'lastmod' => now()->toAtomString(), 'priority' => '0.8'],
            ['loc' => route('kegiatan.index'), 'lastmod' => now()->toAtomString(), 'priority' => '0.9'],
            ['loc' => route('pengumuman.index'), 'lastmod' => now()->toAtomString(), 'priority' => '0.9'],
            ['loc' => route('kontak'), 'lastmod' => now()->toAtomString(), 'priority' => '0.7'],
        ]);

        if ($period) {
            Division::query()->where('period_id', $period->id)->get()->each(function (Division $div) use ($urls): void {
                $urls->push([
                    'loc' => route('divisi.show', $div->slug),
                    'lastmod' => ($div->updated_at ?? now())->toAtomString(),
                    'priority' => '0.7',
                ]);
            });
        }

        Activity::query()->published()->latest('event_date')->get()->each(function (Activity $activity) use ($urls): void {
            $urls->push([
                'loc' => route('kegiatan.show', $activity->slug),
                'lastmod' => ($activity->updated_at ?? now())->toAtomString(),
                'priority' => '0.7',
            ]);
        });

        Announcement::query()->published()->latest('published_at')->get()->each(function (Announcement $announcement) use ($urls): void {
            $urls->push([
                'loc' => route('pengumuman.show', $announcement->slug),
                'lastmod' => ($announcement->updated_at ?? now())->toAtomString(),
                'priority' => '0.7',
            ]);
        });

        $xml = view('sitemap', ['urls' => $urls])->render();

        return response($xml, 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
    }
}
