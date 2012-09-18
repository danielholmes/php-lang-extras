<?php

namespace DHolmes\LangExtras\File;

class TempFile
{
    /** @return string */
    public static function getRandomPath()
    {
        return static::getPathWithExtension('');
    }

    /**
     * @param string $extension
     * @return string
     */
    public static function getPathWithExtension($extension)
    {
        $filepath = null;

        $MAX_TRIES = 1000;
        for ($i = 0; $i < $MAX_TRIES && $filepath === null; $i++)
        {
            $testName = uniqid();
            if (!empty($extension))
            {
                $testName .= '.' . $extension;
            }
            $testFilepath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $testName;

            if (!file_exists($testFilepath))
            {
                $filepath = $testFilepath;
            }
        }

        if ($info === null)
        {
            throw new \RuntimeException(sprintf('Some error generating file, %d unsuccessful attemps', $MAX_TRIES));
        }

        return $filepath;
    }
}
