<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Event;

class Calendar extends Component
{
    public $events = '';

    public function getevent()
    {
        $events = Event::select('id', 'title', 'start')->get();

        return  json_encode($events);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function addevent($event)
    {
        $event = Event::create([
            'title' => $event['title'],
            'start' => $event['start']
        ]);

        $this->emit('eventAdded', ['id' => $event->id, 'title' => $event->title, 'start' => $event->start]);
    }

    public function removeevent($event)
    {
        $eventdata = Event::find($event['id']);
        $eventdata->delete();

        $this->emit('eventRemoved', ['id' => $event['id']]);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function eventDrop($event, $oldEvent)
    {
        $eventdata = Event::find($event['id']);
        $eventdata->start = $event['start'];
        $eventdata->save();
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function render()
    {
        $events = Event::select('id', 'title', 'start')->get();
        $this->events = json_encode($events);
        return view('livewire.calendar');
    }
}
