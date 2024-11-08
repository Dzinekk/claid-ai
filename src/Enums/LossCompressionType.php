<?php
declare(strict_types=1);

namespace Dzinekk\ClaidAI\Enums;

enum LossCompressionType: string {
    case Lossless = 'lossless';
    case Lossy = 'lossy';
}
