<?php
namespace CsvPostCreator\Models;

class Blog
{
    const maxCategoriesCount = 3;

    private $title;
    private $content;
    private $categories;
    private $date;

    /**
     * @param string $title
     * @param string $content
     * @param array $categories
     * @param string $date
     * $return Blog
     */
    public function __construct($title, $content, $categories, $date)
    {
        if (!is_string($title) || empty($title)) {
            throw new \InvalidArgumentException('title');
        }

        if (!is_string($content) || empty($content)) {
            throw new \InvalidArgumentException('content');
        }

        if (!is_array($categories) || empty($categories) || count($categories) > self::maxCategoriesCount) {
            var_dump($categories);
            throw new \InvalidArgumentException('categories');
        }

        if (!is_string($date) || empty($date) || !strtotime($date)) {
            throw new \InvalidArgumentException('date');
        }

        $this->title = $title;
        $this->content = $content;
        $this->date = date("Y-m-d H:i:s", strtotime($date));

        foreach ($categories as $category) {
            $categoryId = get_cat_ID($category);
            if ($categoryId === 0) {
                throw new \InvalidArgumentException("$category");
            }
            $this->categories[] = $categoryId;
        }
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return array
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }
}
