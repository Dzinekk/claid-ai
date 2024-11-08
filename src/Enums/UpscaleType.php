<?php

namespace Dzinekk\ClaidAI\Enums;

enum UpscaleType: string {
    /** Used on small low quality product, real estate and food images. */
    case SmartEnhance = 'smart_enhance';
    
    /** Used on high-quality images and photos with barely readable text. */
    case SmartResize = 'smart_resize';
    
    /** Used on drawings, illustrations, paintings, cartoons, anime, etc. */
    case DigitalArt = 'digital_art';
    
    /** Used on images containing people */
    case Faces = 'faces';
    
    /** Used on photos of people, nature, architecture, etc. taken with phones or digital cameras. */
    case Photo = 'photo';
}
