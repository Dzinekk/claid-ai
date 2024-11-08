<?php
declare(strict_types=1);

namespace Dzinekk\ClaidAI\Dto;

use Dzinekk\ClaidAI\Enums\FormatType;
use Dzinekk\ClaidAI\Enums\PngCompressionType;

class OutputFormat {
    public function __construct(
        public FormatType $type,
        public ?int $quality = null,
        public ?bool $progressive = null,
        public OutputCompressionDetails|PngCompressionType|null $compression = null,
    ) {
    }
}
