<?php

namespace Dzinekk\ClaidAI\Enums;

enum DecompressType: string {
    /** Removes JPEG artifacts from the image. */
    case Moderate = 'moderate';
    
    /** Removes JPEG artifacts more aggressively than moderate. */
    case Strong = 'strong';
    
    /** Automatically detects and removes JPEG artifacts if needed. */
    case Auto = 'auto';
}
