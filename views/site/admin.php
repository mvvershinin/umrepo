<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Администрирование';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4 col-md-4">
                <a href="/services-section/index">
                    <button class="btn btn-lg btn-info btn-block">
                        Специализации  &raquo;
                    </button>    
                </a>
                <a href="/service/index">
                    <button class="btn btn-lg btn-info btn-block">
                        Разделы  &raquo;
                    </button>    
                </a>
                <a href="/service-spec/index">
                    <button class="btn btn-lg btn-info btn-block">
                        Категории  &raquo;
                    </button>    
                </a>
            </div>

            <div class="col-lg-4 col-md-4">
                <a href="/rbac/role">
                    <button class="btn btn-lg btn-info btn-block">
                        Менеджер ролей  &raquo;
                    </button>    
                </a>
                <a href="/rbac/assignment">
                    <button class="btn btn-lg btn-info btn-block">
                        Соответсвия пользователя  &raquo;
                    </button>    
                </a>
                <a href="/rbac/permission">
                    <button class="btn btn-lg btn-info btn-block">
                        Менеджер разрешений  &raquo;
                    </button>    
                </a>
                <a href="/rbac/rule">
                    <button class="btn btn-lg btn-info btn-block">
                        Менеджер правил  &raquo;
                    </button>    
                </a>
            </div>
        </div>

    </div>
    
</div>
