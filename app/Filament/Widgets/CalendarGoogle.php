<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

use Illuminate\Database\Eloquent\Model;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Saade\FilamentFullCalendar\Actions;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Toggle;

use App\Models\Task;
use Carbon\Carbon;

 
class CalendarGoogle extends FullCalendarWidget
{
    public static string $view = 'filament.widgets.calendar-google';
    //public static string $view = 'caminho/para/a/view';

    public Model | string | null $model = Task::class;
 
    public function fetchEvents(array $fetchInfo): array
    {
        dd($fetchInfo);
        return Task::where('start', '>=', $fetchInfo['start'])
            ->where('end', '<=', $fetchInfo['end'])
            ->get()
            ->map(function (Task $task) {
                return [
                    'id'    => $task->id,
                    'title' => $task->title + $task->description ,
                    'start' => $task->start,
                    'end'   => $task->end,
                ];
            })
            ->toArray();
    }
 
    public static function canView(): bool
    {
        return false;
    }
   

}
