<?php
declare(strict_types=1);

namespace Dzinekk\ClaidAI\Dto;

class ImageEditHeaders {
    /**
     * @param string $requestId allows to track your request during image edit processing, so we are able to help you with troubleshooting and profiling your request if needed.
     * @param string $rateLimit indicates the request-quota associated with the user in the current time window (format example: 'ratelimit-limit: 120, 120;w=60, 4;w=1')
     * @param int $rateLimitRemaining  indicates the remaining requests that you can issue in the current time window
     * @param int $rateLimitReset  is the number of seconds until the quota resets
     */
    public function __construct(
        public string $requestId,
        public string $rateLimit,
        public int $rateLimitRemaining,
        public int $rateLimitReset,
    ) {}
}