<?php
declare(strict_types=1);

namespace Dzinekk\ClaidAI\Dto;


class OutputMetadata {
    public function __construct(
        public ?int $dpi = null
    ) {}
}