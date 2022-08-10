<?php

namespace App\Exceptions;

use Exception;

class InvalidCredentialException extends Exception
{
    public function report()
    {
        //
    }
 
    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        return "Credential zipfuye" ;
    }
}
