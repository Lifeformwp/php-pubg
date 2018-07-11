<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\PlayerData\Player;

use Lifeformwp\PHPPUBG\DTO\PlayerData\Player\Relationships\Assets;
use Lifeformwp\PHPPUBG\DTO\PlayerData\Player\Relationships\Matches;

/**
 * Class PlayerRelationships
 *
 * @author  Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\PlayerData\Player
 * @since   1.1.0
 */
class PlayerRelationships
{
    /**
     * @var Assets|null
     */
    public $assets;
    /**
     * @var Matches|null
     */
    public $matches;

    /**
     * PlayerRelationships constructor.
     *
     * @param Assets|null  $assets
     * @param Matches|null $matches
     */
    public function __construct(
        ?Assets $assets,
        ?Matches $matches
    ) {
        $this->assets  = $assets;
        $this->matches = $matches;
    }

    /**
     * @param array $data
     *
     * @return PlayerRelationships
     */
    public static function createFromResponse(array $data): self
    {
        return new self(
            $data['assets'],
            $data['matches']
        );
    }
}