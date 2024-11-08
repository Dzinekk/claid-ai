<?php
declare(strict_types=1);

namespace Dzinekk\ClaidAI\Enums;


enum PngCompressionType: string {
    case Fast = 'fast';
    case Optimal = 'optimal';
    case Best = 'best';
    
}