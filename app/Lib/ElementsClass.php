<?php

namespace App\Lib;
use App\Http\Traits\DzMeSettings;
use Illuminate\Http\Request;

class ElementsClass{
	use DzMeSettings;
    
    public $theme_elements;
    public $widget_elements;

    public function __construct() {
        $this->initializeSettings();
        $this->setThemeElements();
        $this->setWidgetElements();
    }

    public function __init() {
        $this->mergeThemesElements($this->theme_elements);
        $this->mergeWidgetsElements($this->widget_elements);
    }

    public function setThemeElements() {

        
    }

    public function setWidgetElements() {
        
    }

}