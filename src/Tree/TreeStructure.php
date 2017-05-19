<?php

namespace Tree;


class TreeStructure
{
    public function buildTreeView ($parent, $category) {
        $html = "";
        if (isset($category['parent_cats'][$parent])) {
            $html .= "<ul class='tree'>";
            foreach ($category['parent_cats'][$parent] as $cat_id) {
                if (!isset($category['parent_cats'][$cat_id])) {
                    $html .= "<li><label>". $category['categories'][$cat_id]['label'] . "<a class='btn btn-xs btn-default' href='details.php?id=" .$category['categories'][$cat_id]['id']."'> <span class='glyphicon glyphicon-cog' aria-hidden='true'></span></a></label> <input type='checkbox'/></li>";
                }
                if (isset($category['parent_cats'][$cat_id])) {
                    $html .= "<li><label>". $category['categories'][$cat_id]['label'] . "<a class='btn btn-xs btn-default' href='details.php?id=" .$category['categories'][$cat_id]['id']."'><span class='glyphicon glyphicon-cog' aria-hidden='true'></span></a></label> <input type='checkbox'/>";
                    $html .= $this->showChildren ($cat_id, $category);
                    $html .= "</li>";
                }
            }
            $html .= "</ul>";
        }
        return $html;
    }

    public function showChildren ($parent, $category) {
        $html = "";
        if (isset($category['parent_cats'][$parent])) {
            $html .= "<ul class='tree'>";
            foreach ($category['parent_cats'][$parent] as $cat_id) {
                if (!isset($category['parent_cats'][$cat_id])) {
                    $html .= "<li class='child'><label>". $category['categories'][$cat_id]['label'] . "</label> <input type='checkbox'/></li>";
                }
                if (isset($category['parent_cats'][$cat_id])) {
                    $html .= "<li class='child2'><label>". $category['categories'][$cat_id]['label'] . "</label> <input type='checkbox'/>";
                    $html .= $this->showChildren($cat_id, $category);
                    $html .= "</li>";
                }
            }
            $html .= "</ul>";
        }
        return $html;
    }
}