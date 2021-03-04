<?php

namespace MingJSHK\NewebPay\Concerns;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use MingJSHK\NewebPay\Contracts\Http;
use MingJSHK\NewebPay\Contracts\Sender;
use MingJSHK\NewebPay\Sender\Async;
use MingJSHK\NewebPay\Sender\Sync;

trait HasSender
{
    /**
     * The sender instance.
     *
     * @var \MingJSHK\NewebPay\Contracts\Sender
     */
    protected $sender;

    /**
     * Set the sender instance.
     *
     * @param  \MingJSHK\NewebPay\Contracts\Sender  $sender
     * @return self
     */
    public function setSender(Sender $sender)
    {
        $this->sender = $sender;

        return $this;
    }

    /**
     * Get the sender instance.
     *
     * @return \MingJSHK\NewebPay\Contracts\Sender
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * Set sync sender.
     *
     * @return self
     */
    public function setSyncSender()
    {
        $this->setSender(new Sync());

        return $this;
    }

    /**
     * Set async sender.
     *
     * @return self
     */
    public function setAsyncSender()
    {
        $this->setSender(new Async($this->createHttp()));

        return $this;
    }

    /**
     * Set mock http instance.
     *
     * @param  \GuzzleHttp\Handler\MockHandler|array  $mockHandler
     * @return self
     */
    public function setMockHttp($mockResponse)
    {
        if ($this->sender instanceof Http) {
            if (!$mockResponse instanceof MockHandler) {
                $mockHandler = new MockHandler($mockResponse);
            }

            $this->sender->setHttp($this->createHttp($mockHandler));
        }

        return $this;
    }

    /**
     * Create http instance.
     *
     * @param  \GuzzleHttp\Handler\MockHandler|null  $mockHttpHandler
     * @return \GuzzleHttp\Client
     */
    protected function createHttp($mockHttpHandler = null)
    {
        $attributes = [
            'handler' => $mockHttpHandler ? HandlerStack::create($mockHttpHandler) : null,
        ];

        $attributes = array_filter($attributes, function ($value) {
            return $value !== null;
        });

        return new Client($attributes);
    }
}
