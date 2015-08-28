<?php
/**
 * @author: jovani@bywave.com.au
 */

namespace common\components\storage;

/**
 * A component to Store File into local storage/path.
 * Just add this component to your configuration providing this class,
 * baseUrl and basePath.
 *
 * - baseUrl will be the publicly accessible url where these files are stored.
 * - basePath will be the root folder to save these files for storage.
 *
 * Webserver should be configured to access those files inside the `basePath` thru
 * the `baseUrl`.
 *
 * ~~~
 * 'components' => [
 *     'storage' => [
 *          'class' => '\common\components\storage\Local',
 *          'baseUrl' => 'website.com/uploads',
 *          'basePath' => 'full_path_on_webserver_for_local_storage',
 *     ],
 * ],
 * ~~~
 *
 * You can then start using this component as:
 *
 * ```php
 * $storage = \Yii::$app->storage;
 * $url = $storage->uploadFile('/path/to/file', 'unique_file_name');
 * ```
 */
class Local extends \yii\base\Component implements StorageInterface
{
    public $baseUrl;
    public $basePath;

    public function init()
    {
        parent::init();

        if (empty($this->baseUrl)) {
            $this->baseUrl = $_SERVER['HTTP_HOST'];
        }
    }

    /**
     * Uploads a file into local storage.
     *
     * @param $sourceFilePath
     * @param $destinationFilename
     * @return string full destination path or publicly accessible url.
     */
    public function uploadFile($sourceFilePath, $destinationFilename)
    {
        try {
            // ensure directory
            $destinationFullPath = \Yii::getAlias($this->basePath) . DIRECTORY_SEPARATOR . $destinationFilename;
            $destinationFolder = dirname($destinationFullPath);
            if (!is_dir($destinationFolder)) {
                mkdir($destinationFolder, 0755, true);
            }

            if (!copy($sourceFilePath, $destinationFullPath)) {
                throw new \Exception('Something went wrong copying the file.');
            }
        } catch (\Exception $e) {
            return false;
        }

        return $this->baseUrl . '/' . $destinationFilename;
    }
}
