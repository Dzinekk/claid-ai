<?php
declare(strict_types=1);

namespace Dzinekk\ClaidAI;


use App;
use Dzinekk\ClaidAI\Dto\ImageEditHeaders;
use Dzinekk\ClaidAI\Dto\ImageEditInput;
use Dzinekk\ClaidAI\Dto\ImageEditOutput;
use Dzinekk\ClaidAI\Dto\ImageEditResponse;
use Dzinekk\ClaidAI\Enums\Crop;
use Dzinekk\ClaidAI\Enums\DecompressType;
use Dzinekk\ClaidAI\Enums\Fit;
use Dzinekk\ClaidAI\Enums\UpscaleType;
use LiteMS;

class ImageEdit {
    /**
     * @var array<string, mixed>
     */
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
            'width' => $width ?? 'auto',
            'height' => $height ?? 'auto',
        ];
        
        if ($fit === Fit::Crop) {
            $this->data['operations']['resizing']['fit'] = ['crop' => $crop->value];
        }else {
            $this->data['operations']['resizing']['fit'] = $fit->value;
        }
        
        return $this;
    }
    
    /** The decompress operation allows you to remove distortion and artifacts caused by image compression.
     * It can be used in conjunction with the upscale operation to prepare an image for upscaling.
     * @param DecompressType $type
     * @return $this
     */
    public function decompress(DecompressType $type = DecompressType::Auto): ImageEdit {
        $this->data['operations']['restorations']['decompress'] = $type->value;
        
        return $this;
    }
    
    /** The upscale operation allows you to improve the overall quality of an image by rendering out new pixels.
     * The upscale operation works along with Resizing through numeric or percentage values for upscaling.
     * @param UpscaleType $type
     * @return $this
     */
    public function upscale(UpscaleType $type): ImageEdit {
        $this->data['operations']['restorations']['upscale'] = $type->value;
        
        return $this;
    }
    
    /** The polish operation allows you to redraw image parts making them sharper, yet keeping the original structure.
     * It can be used individually, or in conjunction with the Upscale (we recommend Smart Enhance upscale) operation to make the image look even sharper and more realistic.
     * @return $this
     */
    public function polish(): ImageEdit {
        $this->data['operations']['restorations']['polish'] = true;
        
        return $this;
    }
    
    /**
     * @return ImageEditResponse body of the response
     * @throws ClaidException
     */
    public function request(): ImageEditResponse {
        $data = $this->client->request('POST', 'image/edit', $this->data);
        
        return new ImageEditResponse(
            headers: new ImageEditHeaders(
                requestId: $data['data']['headers']['x-request-id'],
                rateLimit: $data['data']['headers']['ratelimit-limit'],
                rateLimitRemaining: (int)$data['data']['headers']['ratelimit-remaining'],
                rateLimitReset: (int)$data['data']['headers']['ratelimit-reset'],
            ),
            input: new ImageEditInput(
                ext: $data['data']['input']['ext'],
                mps: (float)$data['data']['input']['mps'],
                mime: $data['data']['input']['mime'],
                width: (int)$data['data']['input']['width'],
                height: (int)$data['data']['input']['height'],
                format: $data['data']['input']['format'],
            ),
            output: new ImageEditOutput(
                ext: $data['data']['output']['ext'],
                mps: (float)$data['data']['output']['mps'],
                mime: $data['data']['output']['mime'],
                width: (int)$data['data']['output']['width'],
                height: (int)$data['data']['output']['height'],
                format: $data['data']['output']['format'],
                tmp_url: $data['data']['output']['tmp_url'],
            ),
        );
    }
}