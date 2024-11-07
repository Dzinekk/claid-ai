<?php

namespace Dzinekk\ClaidAI\Enums;

enum Fit: string {
    case Crop = 'crop';
    case Bounds = 'bounds';
    case Cover = 'cover';
    case Canvas = 'canvas';
}
