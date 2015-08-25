<?php

/**
 * @author: jovani@bywave.com.au
 */

namespace common\components\storage;

interface StorageInterface
{
    /**
     * @param string $sourceFilePath
     * @param string $destinationFilename
     *
     * @return string full destination path or publicly accessible url.
     */
    public function uploadFile($sourceFilePath, $destinationFilename);
}
