<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\SamplesData\Sample;

use Lifeformwp\PHPPUBG\DTO\SamplesData\Sample\Relationships\Matches;

/**
 * Class SampleRelationships
 *
 * @author Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\SamplesData\Sample
 * @since 1.3.0
 */
class SampleRelationships
{
    /**
     * @var Matches|null
     */
    public $matches;

    /**
     * SampleRelationships constructor.
     *
     * @param Matches|null     $matches
     */
    public function __construct(
        ?Matches $matches
    ) {
        $this->matches = $matches;
    }

    /**
     * @param array $data
     *
     * @return SampleRelationships
     */
    public static function createFromResponse(array $data): self
    {
        return new self(
            $data['matches']
        );
    }
}