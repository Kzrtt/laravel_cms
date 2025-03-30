<?php 
    namespace App;

    class CMSFunctions {
        public function getStatusBadge($status) {
            $html = "";

            if($status) {
                $html.= '<span class="inline-flex items-center justify-center mt-2 px-3 py-1 rounded-lg bg-success-200/50 bg-opacity-50 text-success-700 font-semibold">';
                    $html.= '<i class="fad fa-check-circle mr-2"></i>Ativo';
                $html.= '</span>';
            } else {
                $html.= '<span class="inline-flex items-center mt-2 px-3 py-1 rounded-full bg-danger-200/50 bg-opacity-50 text-danger-700 font-semibold">';
                    $html.= '<i class="fad fa-times-circle mr-2"></i>Inativo';
                $html.= '</span>';
            }

            return $html;
        }

        public function getDate($date) {
            return $date->format('d/m/Y');
        }
    }
?>