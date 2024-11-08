<?php
declare(strict_types=1);

namespace Dzinekk\ClaidAI\Dto;

use Dzinekk\ClaidAI\Enums\LossCompressionType;

class OutputCompressionDetails {
    public function __construct(
        public LossCompressionType $type,
        public int $quality
    ) {}
}
