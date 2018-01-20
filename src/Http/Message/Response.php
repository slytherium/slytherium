<?php

namespace Zapheus\Http\Message;

/**
 * Response
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class Response extends Message implements ResponseInterface
{
    /**
     * @var integer
     */
    protected $code = 200;

    /**
     * @var array
     */
    protected $reasons = array(
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        207 => 'Multi Status',
        208 => 'Already Reported',
        226 => 'Im Used',
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        306 => 'Reserved',
        307 => 'Temporary Redirect',
        308 => 'Permanent Redirect',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Payload Too Large',
        414 => 'Uri Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Range Not Satisfiable',
        417 => 'Expectation Failed',
        418 => 'Im A Teapot',
        421 => 'Misdirected Request',
        422 => 'Unprocessable Entity',
        423 => 'Locked',
        424 => 'Failed Dependency',
        426 => 'Upgrade Required',
        428 => 'Precondition Required',
        429 => 'Too Many Requests',
        431 => 'Request Header Fields Too Large',
        451 => 'Unavailable For Legal Reasons',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'Version Not Supported',
        506 => 'Variant Also Negotiates',
        507 => 'Insufficient Storage',
        508 => 'Loop Detected',
        510 => 'Not Extended',
        511 => 'Network Authentication Required',
    );

    /**
     * @var string
     */
    protected $reason = 'OK';

    /**
     * Initializes the response instance.
     *
     * @param integer $code
     * @param array   $headers
     */
    public function __construct($code = 200, array $headers = array())
    {
        parent::__construct($headers);

        $this->code = $code;

        $this->reason = $this->reasons[$code];
    }

    /**
     * Returns the response status code.
     *
     * @return integer
     */
    public function code()
    {
        return $this->code;

        // getStatusCode
        // withStatus
    }

    /**
     * Returns the response reason phrase associated with the status code.
     *
     * @return string
     */
    public function reason()
    {
        return $this->reason;

        // getReasonPhrase
        // // withStatus
    }

    /**
     * Sets a value to a specified property.
     *
     * @param  string  $name
     * @param  mixed   $value
     * @param  boolean $mutable
     * @return self
     */
    public function set($name, $value, $mutable = false)
    {
        $result = parent::set($name, $value, $mutable);

        if ($name === 'code') {
            $reason = $result->reasons[$value];

            $result->reason = (string) $reason;
        }

        return $result;
    }
}
