<?php
/**
 * @package   Gantry5
 * @author    RocketTheme http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2016 RocketTheme, LLC
 * @license   GNU/GPLv2 and later
 *
 * http://www.gnu.org/licenses/gpl-2.0.html
 */

namespace Gantry\Joomla\Category;

use Gantry\Joomla\Object\Object;

class Category extends Object
{
    static protected $instances = [];

    static protected $table = 'Category';
    static protected $order = 'lft';

    protected function initialize()
    {
        $this->params = json_decode($this->params);
        $this->metadata = json_decode($this->metadata);
    }

    public function parent()
    {
        if ($this->alias != $this->path)
        {
            $parent = Category::getInstance($this->parent_id);
        }

        return isset($parent) && $parent->extension == $this->extension ? $parent : null;
    }

    public function parents()
    {
        $parent = $this->parent();

        return $parent ? array_merge([$parent], $parent->parents()) : [];
    }

    public function route()
    {
        require_once JPATH_SITE . '/components/com_content/helpers/route.php';

        return \JRoute::_(\ContentHelperRoute::getCategoryRoute($this->id . '-' . $this->alias), false);
    }
}
