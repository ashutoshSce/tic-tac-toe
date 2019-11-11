<?php

namespace App\Listeners;

class GameEventListener
{
    /**
     * Handle game draw events.
     *
     * @param $event
     */
    public function onGameDraw($event)
    {
        $this->clearPlayerPointers($event);
    }

    /**
     * Handle game expired events.
     *
     * @param $event
     */
    public function onGameExpired($event)
    {
        $this->clearPlayerPointers($event);
    }

    /**
     * Handle game won events.
     *
     * @param $event
     */
    public function onGameWon($event)
    {
        $this->clearPlayerPointers($event);
    }

    /**
     * Handle player give-up events.
     *
     * @param $event
     */
    public function onPlayerGiveUp($event)
    {
        $this->clearPlayerPointers($event);
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(\App\Events\GameDraw::class, 'App\Listeners\GameEventListener@onGameDraw');

        $events->listen(\App\Events\GameExpired::class, 'App\Listeners\GameEventListener@onGameExpired');

        $events->listen(\App\Events\GameWon::class, 'App\Listeners\GameEventListener@onGameWon');

        $events->listen(\App\Events\PlayerGiveUp::class, 'App\Listeners\GameEventListener@onPlayerGiveUp');
    }

    private function clearPlayerPointers($event)
    {
        $event->board->records->player1_pointer = [];
        $event->board->records->player2_pointer = [];
        $event->board->records->save();
    }
}
