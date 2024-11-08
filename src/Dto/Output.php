<?php
declare(strict_types=1);

namespace Dzinekk\ClaidAI\Dto;

use Dzinekk\ClaidAI\Enums\FormatType;

class Output {
     public function __construct(
        public FormatType|OutputFormat $format,
        public ?string $destination = null,
        public ?OutputMetadata $metadata = null,
    ) {}
}