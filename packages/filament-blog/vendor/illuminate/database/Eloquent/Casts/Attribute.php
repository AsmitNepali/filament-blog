<?php

namespace Illuminate\Database\Eloquent\Casts;

class Attribute
{
    /**
     * The attribute accessor.
     *
     * @var callable
     */
    public $get;

    /**
     * The attribute mutator.
     *
     * @var callable
     */
    public $set;

    /**
     * Indicates if caching is enabled for this attribute.
     *
     * @var bool
     */
    public $withCaching = false;

    /**
     * Indicates if caching of objects is enabled for this attribute.
     *
     * @var bool
     */
    public $withObjectCaching = true;

    /**
     * Create a new attribute accessor / mutator.
     *
     * @return void
     */
    public function __construct(?callable $get = null, ?callable $set = null)
    {
        $this->get = $get;
        $this->set = $set;
    }

    /**
     * Create a new attribute accessor / mutator.
     */
    public static function make(?callable $get = null, ?callable $set = null): static
    {
        return new static($get, $set);
    }

    /**
     * Create a new attribute accessor.
     *
     * @return static
     */
    public static function get(callable $get)
    {
        return new static($get);
    }

    /**
     * Create a new attribute mutator.
     *
     * @return static
     */
    public static function set(callable $set)
    {
        return new static(null, $set);
    }

    /**
     * Disable object caching for the attribute.
     *
     * @return static
     */
    public function withoutObjectCaching()
    {
        $this->withObjectCaching = false;

        return $this;
    }

    /**
     * Enable caching for the attribute.
     *
     * @return static
     */
    public function shouldCache()
    {
        $this->withCaching = true;

        return $this;
    }
}
