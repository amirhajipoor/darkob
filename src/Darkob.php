<?php

namespace Amirhajipoor\Darkob;

use Amirhajipoor\Darkob\Drivers\Melipayamak;
use Amirhajipoor\Darkob\Exceptions\DarkobException;
use Carbon\Carbon;

class Darkob
{
    public $driver;

    public $pattern;

    public $params;

    public $text;

    public $from;

    public $time;

    public $to;

    public function __construct()
    {
        $this->driver = config('darkob.default');
    }

    public function driver(string $driver): Darkob
    {
        $this->driver = $driver;

        return $this;
    }

    public function text(string $text): Darkob
    {
        $this->text = $text;

        return $this;
    }

    public function from(string $from): Darkob
    {
        $this->from = $from;

        return $this;
    }

    public function params(mixed $params): Darkob
    {
        $this->params = $params;

        return $this;
    }

    public function to(string $phone_number): Darkob
    {
        $this->to = $phone_number;

        return $this;
    }

    public function sendByPattern(string|int $pattern): int
    {
        $this->pattern = $pattern;
        $regex = '/^09\\d{9}$/';

        if (empty($this->to)) {
            throw new DarkobException(__('darkob::messages.required', ['attribute' => 'phone_number']));
        }

        if (! preg_match($regex, $this->to)) {
            throw new DarkobException(__('darkob::messages.phone_number_invalid_format'));
        }

        if (($this->params === null)) {
            throw new DarkobException(__('darkob::messages.required', ['attribute' => 'parameters']));
        }

        if ($this->driver === 'melipayamak') {
            return (new Melipayamak())->sendByPattern($this->to, $this->pattern, $this->params);

        } elseif ($this->driver === 'farazsms') {
            // $this->sendFarazsms();
        }
    }

    public function send(): int
    {
        if (empty($this->to)) {
            throw new DarkobException(__('darkob::messages.required', ['attribute' => 'phone_number']));
        }

        if (empty($this->from)) {
            throw new DarkobException(__('darkob::messages.required', ['attribute' => 'from']));
        }

        if (empty($this->text)) {
            throw new DarkobException(__('darkob::messages.required', ['attribute' => 'text']));
        }

        if ($this->driver === 'melipayamak') {
            return (new Melipayamak())->sendNormal($this->from, $this->to, $this->text);

        } elseif ($this->driver === 'farazsms') {
            // $this->sendFarazsms();
        }
    }

    /**
     * Send on specific time
     */
    public function sendOn(Carbon $time): int
    {
        if (empty($this->to)) {
            throw new DarkobException(__('darkob::messages.required', ['attribute' => 'phone_number']));
        }

        if (empty($this->from)) {
            throw new DarkobException(__('darkob::messages.required', ['attribute' => 'from']));
        }

        if (empty($this->text)) {
            throw new DarkobException(__('darkob::messages.required', ['attribute' => 'text']));
        }

        if ($this->driver === 'melipayamak') {
            return (new Melipayamak())->sendScheduled($this->from, $this->to, $this->text, $time);

        } elseif ($this->driver === 'farazsms') {
            // $this->sendFarazsms();
        }
    }
}
