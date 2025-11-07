<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\URL;
use App\Models\Car;

class SitemapController extends Controller
{
    public function index()
    {
        $urls = [];

        // === Homepage ===
        $urls[] = [
            'loc' => URL::to('/'),
            'priority' => '1.0',
            'changefreq' => 'weekly',
        ];

        // === Inventario ===
        $urls[] = [
            'loc' => URL::to('/inventory'),
            'priority' => '0.9',
            'changefreq' => 'weekly',
        ];

        // === Contatti ===
        $urls[] = [
            'loc' => URL::to('/contact'),
            'priority' => '0.5',
            'changefreq' => 'monthly',
        ];

        // === Auto dinamiche ===
        $cars = Car::with(['images', 'brand'])->get();

        foreach ($cars as $car) {
            $url = URL::to('/cars/' . $car->id);

            $xml = "
        <url>
            <loc>{$url}</loc>
            <lastmod>" . optional($car->updated_at)->toAtomString() . "</lastmod>
            <changefreq>monthly</changefreq>
            <priority>0.8</priority>";

            // immagini per Google Images
            if ($car->images->count()) {
                foreach ($car->images as $image) {
                    $imageUrl = URL::to('storage/' . $image->image_path);
                    $imageTitle = htmlspecialchars($car->brand->name . ' ' . $car->model, ENT_XML1);
                    $xml .= "
            <image:image>
                <image:loc>{$imageUrl}</image:loc>
                <image:title>{$imageTitle}</image:title>
                <image:caption>{$imageTitle} in vendita presso AMC-SRLS Auto Showroom</image:caption>
            </image:image>";
                }
            }

            $xml .= "\n        </url>";

            $urls[] = $xml;
        }

        // === Costruzione XML finale ===
        $header = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $header .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" ';
        $header .= 'xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">' . "\n";

        // parti statiche
        foreach (array_slice($urls, 0, 3) as $u) {
            $header .= "    <url>\n";
            $header .= "        <loc>{$u['loc']}</loc>\n";
            if (isset($u['lastmod'])) $header .= "        <lastmod>{$u['lastmod']}</lastmod>\n";
            $header .= "        <changefreq>{$u['changefreq']}</changefreq>\n";
            $header .= "        <priority>{$u['priority']}</priority>\n";
            $header .= "    </url>\n";
        }

        // parti dinamiche
        $carsXml = implode("\n", array_slice($urls, 3));

        $footer = "\n</urlset>";

        $xmlContent = $header . $carsXml . $footer;

        return response($xmlContent, 200)
            ->header('Content-Type', 'application/xml');
    }
}
