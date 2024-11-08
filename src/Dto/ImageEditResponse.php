<?php
declare(strict_types=1);

namespace Dzinekk\ClaidAI\Dto;

class ImageEditResponse {
    public function __construct(
        public ImageEditHeaders $headers,
        public ImageEditInput $input,
        public ImageEditOutput $output,
    ) {}
}