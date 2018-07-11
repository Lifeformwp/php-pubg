<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\MatchData\Links;

/**
 * Class Links
 *
 * @author  Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\MatchData\Links
 * @since   1.1.0
 */
class Links
{
    /**
     * @var null|string
     */
    public $self;

    /**
     * Links constructor.
     *
     * @param null|string $self
     */
    public function __construct(?string $self)
    {
        $this->self = $self;
    }

    /**
     * @param array $data
     *
     * @return Links
     */
    public static function createFromResponse(array $data): self
    {
        return new self(
            $data['self']
        );
    }
}