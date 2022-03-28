<?php

/**
 * error code 门面
 *
 * @date    2018-10-31 17:52:04
 * @version $Id$
 */

namespace App\Common\Libs\ErrorCode;

use App\Common\Libs\ErrorCode\ErrorCodeProvider;
use Illuminate\Support\Facades\Facade;

class ErrorCodeFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ErrorCodeProvider::$abstract;
    }
}
