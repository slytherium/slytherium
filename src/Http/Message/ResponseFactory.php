<?php

namespace Zapheus\Http\Message;

class ResponseFactory extends MessageFactory
{
    /**
     * @var integer
     */
    protected $code = 200;

    public function __construct(ResponseInterface $response = null)
    {
        parent::__construct($response);

        if ($response === null)
        {
            return;
        }

        $this->code = $response->code();
    }

    public function code($code)
    {
        $this->code = $code;

        return $this;
    }

    public function make()
    {
        return new Response($this->code, $this->headers, $this->stream, $this->version);
    }
}
