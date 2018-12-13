<?php
namespace CsvPostCreator\Controllers;

require_once(CSV_POST_CREATOR_PLUGIN_DIR . 'models/FileParser.php');
require_once(CSV_POST_CREATOR_PLUGIN_DIR . 'models/Converter.php');

use CsvPostCreator\Models\Converter;
use CsvPostCreator\Models\FileParser;

class CsvPostCreator
{
    const maxFileSize = 5242880; //5 Mb

    /**
     * @return void
     */
    public static function activate()
    {
        flush_rewrite_rules();
    }

    /**
     * @return void
     */
    public static function deactivate()
    {
        flush_rewrite_rules();
    }

    /**
     * @return void
     */
    public static function addMenuPage()
    {
        if (is_admin()) {
            add_menu_page(
                'Csv Post Creator',
                'Csv Post Creator',
                'manage_options',
                CSV_POST_CREATOR_PLUGIN_DIR . 'views/main.php'
            );
        }
    }

    /**
     * $param string $filename
     * @return bool
     */
    public static function createCsvPosts($filename)
    {
        $data = FileParser::parseCsvFile($filename);
        $blogs = Converter::convertArrayToBlogs($data);

        foreach ($blogs as $blog) {
            if (get_page_by_title($blog->getTitle(), OBJECT, ['post']) === null
                || (get_page_by_title($blog->getTitle(), OBJECT, ['post']))->post_status === 'trash') {
                wp_insert_post(
                    [
                        'post_author'	=> get_current_user_id(),
                        'post_title'	=> $blog->getTitle(),
                        'post_content'  => $blog->getContent(),
                        'post_status'	=> 'publish',
                        'post_type'		=> 'post',
                        'post_date'		=> $blog->getDate(),
                        'post_category' => $blog->getCategories(),
                    ]
                );
            } else {
                return false;
            }
        }

        return true;
    }
}
