<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\SamplesData\Sample\Relationships\Type;

/**
 * Class MatchType
 *
 * @author  Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\SamplesData\Sample\Relationships\Type
 * @since   1.3.0
 */
class MatchType
{
    /**
     * @var null|string
     */
    public $type;
    /**
     * @var null|string
     */
    public $id;

    /**
     * MatchType constructor.
     *
     * @param null|string $type
     * @param null|string $id
     */
    public function __construct(?string $type, ?string $id)
    {
        $this->type = $type;
        $this->id   = $id;
    }

    /**
     * @param array $data
     *
     * @return MatchType
     */
    public static function createFromResponse(array $data): self
    {
        return new self(
            $data['type'],
            $data['id']
        );
    }
}