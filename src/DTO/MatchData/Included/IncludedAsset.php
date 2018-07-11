<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\MatchData\Included;

use Lifeformwp\PHPPUBG\DTO\MatchData\Included\Asset\AssetAttributes;

/**
 * Class IncludedAsset
 *
 * @author  Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\MatchData\Included
 * @since   1.1.0
 */
class IncludedAsset
{
    /**
     * @var string
     */
    public $type;
    /**
     * @var string
     */
    public $id;
    /**
     * @var AssetAttributes
     */
    public $attributes;

    /**
     * IncludedAsset constructor.
     *
     * @param string          $type
     * @param string          $id
     * @param AssetAttributes $attributes
     */
    public function __construct(
        string $type,
        string $id,
        AssetAttributes $attributes
    ) {
        $this->type       = $type;
        $this->id         = $id;
        $this->attributes = $attributes;
    }

    /**
     * @param array $data
     *
     * @return IncludedAsset
     */
    public static function createFromResponse(array $data): self
    {
        return new self(
            $data['type'],
            $data['id'],
            $data['attributes']
        );
    }
}