<?php

namespace DHolmes\LangExtras;

class EnumerationValueDescription
{
    /** @var mixed */
    private $key;
    /** @var string */
    private $description;
    /** @var array */
    private $otherArgs;

    /**
     * @param string $key
     * @param string $description
     * @param array $otherArgs
     */
    public function __construct($key, $description, array $otherArgs = array())
    {
        $this->key = $key;
        $this->description = $description;
        $this->otherArgs = $otherArgs;
    }

    /** @return string */
    public function getDescription()
    {
        return $this->description;
    }

    /** @return mixed */
    public function getKey()
    {
        return $this->key;
    }

    /** @return array */
    public function getOtherArgs()
    {
        return $this->otherArgs;
    }
}
