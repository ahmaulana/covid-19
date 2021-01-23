<?php

namespace Rubix\ML\Specifications;

use Rubix\ML\Datasets\Dataset;
use InvalidArgumentException;

/**
 * @internal
 */
class DatasetIsNotEmpty extends Specification
{
    /**
     * The dataset.
     *
     * @var \Rubix\ML\Datasets\Dataset
     */
    protected $dataset;

    /**
     * Build a specification object with the given arguments.
     *
     * @param \Rubix\ML\Datasets\Dataset $dataset
     * @return self
     */
    public static function with(Dataset $dataset) : self
    {
        return new self($dataset);
    }

    /**
     * @param \Rubix\ML\Datasets\Dataset $dataset
     */
    public function __construct(Dataset $dataset)
    {
        $this->dataset = $dataset;
    }

    /**
     * Perform a check of the specification and throw an exception if invalid.
     *
     * @throws \InvalidArgumentException
     */
    public function check() : void
    {
        if ($this->dataset->empty()) {
            throw new InvalidArgumentException('Dataset must contain at least one record.');
        }
    }
}
