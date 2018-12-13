<?php
namespace CsvPostCreator\Models;

require_once(CSV_POST_CREATOR_PLUGIN_DIR . 'models/Blog.php');

class Converter
{
    /**
     * @param array $data
     * @return array[Blog]
     */
    public static function convertArrayToBlogs($data)
    {
        $blogs = [];
        foreach ($data as $currentData) {
            $blogs[] = self::convertArrayToBlog($currentData);
        }
        return $blogs;
    }

    /**
     * @param array $data
     * @return Blog
     */
    private static function convertArrayToBlog($data)
    {
        if (!is_array($data) || count($data) !== 4 || array_keys($data) !== range(0, 3)) {
            var_dump($data);
            throw new \InvalidArgumentException('data');
        }

        $categories = json_decode(stripslashes($data[2]));

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \ErrorException(json_last_error_msg());
        }

        return new Blog($data[0], $data[1], $categories, $data[3]);
    }
}
