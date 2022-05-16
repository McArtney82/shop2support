<?php

declare(strict_types=1);

namespace App\Utils;

class affiliateLinks
{

    /**
     * @param string $affiliate_manager
     * @param string $affiliate_code
     * @return string
     */
    public function get_link_suffix(string $affiliate_manager, string $affiliate_code): string
    {
        $link_suffix = "";
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
            case 'Impact':
                $link_suffix = '&subId1='.$affiliate_code;
                break;
        }
        return $link_suffix;
    }
}