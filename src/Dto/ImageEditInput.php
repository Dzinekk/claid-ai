<?php
declare(strict_types=1);

namespace Dzinekk\ClaidAI\Dto;


class ImageEditInput {
    /**
     * @param string $ext File extension. Can have values: jpg, png, webp, av1
     * @param float $mps Megapixel count
     * @param string $mime MIME type (also known as ‘media type’)
     * @param int $width Image width in pixels
     * @param int $height Image height in pixels
     * @param string $format File format. Can have values: jpeg, png, webp, avif
     */
    public function __construct(
        public string $ext,
        public float $mps,
        public string $mime,
        public int $width,
        public int $height,
        public string $format,
    ) {}
}