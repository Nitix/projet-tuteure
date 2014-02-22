<?php

/**
 * Description of mainView
 *
 */
abstract class MainView {

    private $title;

    protected function __construct($title = "Site web pédagogique") {
        $this->title = $title;
    }

    abstract function displayPage();

    public function header() {
        
    }

    public function HTMLheader() {
        
    }

    public function footer() {
        
    }

    public function menu() {
        
    }

    public function css() {
        
    }

    public function javascript(){
        
    } 
}
