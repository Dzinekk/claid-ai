<?php
declare(strict_types=1);

namespace Dzinekk\ClaidAI;


use App;
use Dzinekk\ClaidAI\Enums\Crop;
use Dzinekk\ClaidAI\Enums\Fit;
use LiteMS;

class ImageEdit {
    private array $data = [];
    
    public function __construct(
        private readonly Client $client,
        string $input,
    ) {
        $this->data['input'] = $input;
    }
    
    /** Use AI to resize image without losing quality
     * @param string|int|null $width
     * @param string|int|null $height
     * @param string|Fit $fit
     * @param string|Crop|null $crop
     * @return ImageEdit
     * @throws ClaidException
     */
    public function resize(
        string|int|null $width,
        string|int|null $height,
        string|Fit $fit,
        string|Crop|null $crop = null,
    ): ImageEdit {
        if ($width === null && $height === null) {
            throw new ClaidException('Width or height must be set.');
        }
    
        if (is_string($fit)) {
            $fitCase = Fit::tryFrom($fit);
            if ($fitCase === null) {
                throw new ClaidException('Invalid fit type.');
            }
            $fit = $fitCase;
        }
        
        if (is_string($crop)) {
            $cropCase = Crop::tryFrom($crop);
            if ($cropCase === null) {
                throw new ClaidException('Invalid crop type.');
            }
            $crop = $cropCase;
        }
        
        if ($fit === Fit::Crop && $crop === null) {
            throw new ClaidException('Crop type must be set when fit is crop.');
        }
        
        $this->data['operations']['resizing'] = [
            'width' => $width,
            'height' => $height,
        ];
        
        if ($fit === Fit::Crop) {
            $this->data['operations']['resizing']['fit'] = ['crop' => $crop->value];
        }else {
            $this->data['operations']['resizing']['fit'] = $fit->value;
        }
        
        return $this;
    }
    
    /**
     * @return array body of the response
     * @throws ClaidException
     */
    public function request(): array {
        return $this->client->request('POST', 'image/edit', $this->data);
    }
}