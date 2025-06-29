<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response as FacadeResponse;
use Imagick;

class SecureImageController extends Controller
{
    public function show(string $category, string $filename)
    {
        if (! app()->isProduction()) {
            putenv('PATH='.getenv('PATH').':/opt/homebrew/bin');
        }

        $allowedCategories = [
            'accounting/receipts',
            'shared-images/thumbs',
            'shared-images/originals',
        ];

        if (! in_array($category, $allowedCategories, true)) {
            \Log::error("Zugriff verweigert: Kategorie {$category} nicht erlaubt.");
            abort(403, 'Zugriff verweigert.');
        }

        $path = storage_path('app/private/'.$category.'/'.$filename);

        if (! file_exists($path)) {
            \Log::error("Datei nicht gefunden: {$path}");
            abort(404, 'Datei nicht gefunden.');
        }

        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        $mimeType = mime_content_type($path);
        //        \Log::info("Datei: {$path}, Extension: {$extension}, MIME-Typ: {$mimeType}");

        if (in_array($extension, ['jpg', 'jpeg', 'png', 'webp'], true)) {
            return response()->file($path, [
                'Content-Type' => $mimeType,
            ]);
        }

        if ($extension === 'pdf') {
            try {
                $imagick = new Imagick;
                Imagick::setResourceLimit(Imagick::RESOURCETYPE_MEMORY, 512); // 512 MB
                $imagick->setOption('density', '99');
                $imagick->setOption('antialias', 'true');
                $imagick->setOption('pdf:use-cropbox', 'true');
                $imagick->setResolution(96, 96);
                $imagick->readImage($path.'[0]');
                $imagick->setImageFormat('png'); // Changed to PNG
                $imagick->stripImage();

                return response($imagick->getImageBlob(), 200, [
                    'Content-Type' => 'image/png',
                ]);
            } catch (\Exception $e) {
                //                report($e);
                Log::error('Fehler beim Generieren der Vorschau für ', [
                    'filename' => $filename,
                    'path' => $path,
                    'Fehler' => $e->getMessage(),
                ]);

                return response('Fehler beim Generieren der Vorschau.', 500);
            }
        }

        return response('Nicht unterstütztes Format.', 415);
    }

    public function download(string $filename)
    {
        $path = storage_path('app/private/accounting/receipts/'.$filename);

        if (! file_exists($path)) {
            abort(404, 'Datei nicht gefunden.');
        }

        return FacadeResponse::download($path);
    }
}
