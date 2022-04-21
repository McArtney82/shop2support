<?php

declare(strict_types=1);

namespace App\Utils;

class affiliateLinks
{

    /**
     * @param $affiliate_manager
     * @param $affiliate_code
     * @return string
     */
    function get_link_suffix($affiliate_manager, $affiliate_code){
        switch($affiliate_manager){
            case 'Commission Factory':
                $link_suffix = "&UniqueId=".$affiliate_code;
                break;
            case 'Rakuten':
                $link_suffix = "&u1=".$affiliate_code;
                break;
            case 'Commission Junction':
                $link_suffix = "?sid=".$affiliate_code;
                break;
            case 'Hotels Combined':
                $link_suffix = "&label=".$affiliate_code;
                break;
            case 'AWIN':
                $link_suffix = '&clickref='.$affiliate_code;
                break;
            case 'ShareASale':
                $link_suffix = '&afftrack='.$affiliate_code;
                break;
        }
        return $link_suffix;
    }
}