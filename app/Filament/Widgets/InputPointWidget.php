<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\PointLogs\PointLogResource;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Colors\Color;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Route;

class InputPointWidget extends Widget implements HasActions, HasForms
{
    use InteractsWithActions;
        use InteractsWithForms;

    protected string $view = 'filament.widgets.input-point-widget';

    protected int | string | array $columnSpan = 'full';

    public ?string $pageClass = null;

    // 💡 Method Judul Dinamis dengan Pengecekan URL Asli (Referer)
        public function getWidgetTitle(): string
        {
            // 💡 Method ini mengambil URL asli yang sedang tertulis di browser user saat ini
               $urlAsliDiBrowser = url()->previous();

               // Cek apakah URL asli tersebut adalah halaman dashboard
               // (Jika URL-nya berakhir dengan kata '/admin' atau '/dashboard')
               if (str_ends_with($urlAsliDiBrowser, '/panel') || str_ends_with($urlAsliDiBrowser, '/dashboard') ) {
                   return 'Pintasan Input Poin';
               }

               // Jika URL asli di browser adalah halaman lain (seperti /admin/point-logs)
               return 'Pilih Metode Input Poin';
        }

    public function inputByStudent():Action{
        return Action::make('create_by_student')
                ->label('Input Berdasarkan Siswa')
                ->tooltip('Input beberapa aturan poin yang dilakukan oleh satu siswa')
                ->icon('tabler-user')
                ->color(Color::Indigo)
                ->url(PointLogResource::getUrl('create-by-student'))
        ;

    }

    public function inputByConduct():Action{
        return Action::make('create_by_conduct')
                ->label('Input Berdasarkan Siswa')
                ->tooltip('Input satu aturan poin yang dilakukan oleh beberapa siswa')
                ->icon('tabler-file-description')
                ->color(Color::Fuchsia)
                ->url(PointLogResource::getUrl('create-by-conduct'))
        ;

    }

    public function inputForAClass():Action{
        return Action::make('mas_input')
                ->label('Input Poin Satu Kelas')
                ->tooltip('input satu aturan poin yang dilakukan oleh satu kelas')
                ->icon('tabler-file-description')
                ->color(Color::Lime)
                ->url(PointLogResource::getUrl('mass-input'))
        ;

    }
}
