<?php

namespace Amirhajipoor\Darkob\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Amirhajipoor\Darkob\Darkob driver(string $driver)
 * @method static \Amirhajipoor\Darkob\Darkob text(string $text)
 * @method static \Amirhajipoor\Darkob\Darkob from(string $from)
 * @method static \Amirhajipoor\Darkob\Darkob params(array $params)
 * @method static \Amirhajipoor\Darkob\Darkob to(string $phone_number)
 * @method static int sendByPattern(string $pattern)
 * @method static int send()
 * @method static int sendOn(\Carbon\Carbon $time)
 *
 * @see Amirhajipoor\Darkob\Darkob
 */
class Darkob extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'darkob';
    }
}
