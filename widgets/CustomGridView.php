<?php

namespace app\widgets;

use Yii;
use yii\grid\GridView;
use \yii\bootstrap5\LinkPager;

/**
 * 
 */
class CustomGridView extends GridView
{
    /**
     * Renders the pager.
     * @return string the rendering result
     */
    public function renderPager()
    {
        $pagination = $this->dataProvider->getPagination();
        if ($pagination === false || $this->dataProvider->getCount() <= 0) {
            return '';
        }
        /* @var $class LinkPager */
        $pager = $this->pager;
        $class = LinkPager::class;
        $pager['pagination'] = $pagination;
        $pager['view'] = $this->getView();


        return $class::widget($pager);
    }

}
