<?php 
    namespace App\Models\config;

    class HeaderToggleParams {
        public $local;
        public $icon;

        public function __construct($local, $icon) {
            $this->local = $local;
            $this->icon = $icon;
        }
    }
?>