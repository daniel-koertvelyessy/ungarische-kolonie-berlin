<?php

declare(strict_types=1);

namespace App\Livewire\Event\PosterGenerator;

use App\Enums\Locale;
use App\Models\Event\Event;
use App\Services\QrCodeService;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Livewire\Component;
use Spatie\Browsershot\Browsershot;
use Spatie\Browsershot\Exceptions\CouldNotTakeBrowsershot;

class Create extends Component
{
    public $event;

    protected $posterPath;

    protected $fullPath;

    public $imagePath;

    public function mount(?Event $event): void
    {
        $this->event = $event;
        $this->imagePath = '';
    }

    /**
     * @throws \Throwable
     * @throws CouldNotTakeBrowsershot
     */
    public function generateJpeg(): void
    {

        foreach (Locale::toArray() as $value) {

            $htmlContent = view('event_posters.main_jpeg', ['event' => $this->event, 'imagePath' => $this->imagePath, 'locale' => $value])->render();

            $this->setImagePath('jpg', $value);

            $this->makeImage($htmlContent)->windowSize(1280, 960)
                ->format('jpeg')
                ->save($this->fullPath);

            session()->flash('message', 'JPG files generated successfully!');

        }
    }

    public function generatePdf(): void
    {
        foreach (Locale::toArray() as $value) {

            $qrService = new QrCodeService;

            $qrcode = $qrService->generateSvg(config('app.url').'/'.$this->event->slug[$value], 120);

            $htmlContent = view('event_posters.main_pdf', ['event' => $this->event, 'imagePath' => $this->imagePath, 'locale' => $value, 'qrcode' => $qrcode, 'dpi' => 96])->render();

            $this->setImagePath('pdf', $value);

            $this->makeImage($htmlContent)
                ->format('A4')
                ->fullPage()
                ->save($this->fullPath);

            session()->flash('message', 'PDF generated successfully!');
        }
    }

    protected function makeImage(string $htmlContent): Browsershot
    {

        $nodeBinary = app()->isProduction()
            ? '/usr/bin/node'
            : '/Users/daniel.kortvelyessy/Library/Application\ Support/Herd/config/nvm/versions/node/v22.14.0/bin/node';

        $npmBinary = app()->isProduction()
            ? '/usr/bin/npm'
            : '/Users/daniel.kortvelyessy/Library/Application\ Support/Herd/config/nvm/versions/node/v22.14.0/bin/npm';

        $includePath = app()->isProduction()
            ? '/usr/bin'
            : '/Users/daniel.kortvelyessy/Library/Application\ Support/Herd/config/nvm/versions/node/v22.14.0/bin';

        $browserShot = Browsershot::html($htmlContent)
            ->setNodeBinary($nodeBinary)
            ->setNpmBinary($npmBinary)
            ->setIncludePath($includePath)
            ->noSandbox()
            ->setOption('args', [
                '--no-sandbox',
                '--disable-setuid-sandbox',
                '--disable-dev-shm-usage',
                '--disable-gpu',
                '--no-zygote',
                '--single-process',
                '--disable-crash-reporter',
                '--no-crash-upload',
            ])
            ->setOption('env', []);

        if (app()->isProduction()) {
            $chromePath = '/srv/kolonia/node_modules/puppeteer/.local-chromium/linux-136.0.7103.92/chrome-linux64/chrome';
            \Log::info('Using Chrome path: '.$chromePath);
            \Log::info('BrowserShot args: '.json_encode([
                'nodeBinary' => $nodeBinary,
                'npmBinary' => $npmBinary,
                'includePath' => $includePath,
                'chromePath' => $chromePath,
                'args' => [
                    '--no-sandbox',
                    '--disable-setuid-sandbox',
                    '--disable-dev-shm-usage',
                    '--disable-gpu',
                    '--no-zygote',
                    '--single-process',
                    '--disable-crash-reporter',
                    '--no-crash-upload',
                ],
            ]));

            return $browserShot->setChromePath($chromePath);
        } else {
            \Log::info('Using default Chrome path (non-production)');

            return $browserShot;
        }
    }

    protected function setImagePath(string $type = 'jpg', $locale = 'de'): void
    {

        $this->posterPath = 'images/posters/'.$this->event->getFilename($locale).'.'.$type;

        // Ensure the directory exists
        Storage::disk('public')
            ->makeDirectory('images/posters');

        // Full path for Browsershot
        $this->fullPath = Storage::disk('public')
            ->path($this->posterPath);

        $this->imagePath = Storage::disk('public')
            ->get($this->fullPath);
    }

    public function render(): View
    {
        return view('livewire.event.poster-generator.create');
    }
}
