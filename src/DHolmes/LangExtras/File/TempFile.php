<?php

namespace DHolmes\LangExtras\File;

class TempFile
{
    /**
     * @param string $extension
     * @param string $prefix
     * @return \SplFileInfo
     */
    public static function getWithExtension($extension = '', $prefix = '')
    {
        $info = null;

        $MAX_TRIES = 1000;
        for ($i = 0; $i < $MAX_TRIES; $i++)
        {
            $testName = uniqid($prefix);
            if (!empty($extension))
            {
                $testName .= '.' . $extension;
            }
            $testFilepath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $testName;

            if (!file_exists($testFilepath))
            {
                $info = new \SplFileInfo($testFilepath);
            }
        }

        if ($info === null)
        {
            throw new \RuntimeException(sprintf('Some error generating file, %d unsuccessful attemps', $MAX_TRIES));
        }

        return $info;
    }
}
