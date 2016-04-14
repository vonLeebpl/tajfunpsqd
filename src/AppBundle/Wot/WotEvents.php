<?php
/**
 * Created by PhpStorm.
 * User: JPa
 * Date: 2016-04-11
 * Time: 20:31
 */

namespace AppBundle\Wot;


class WotEvents extends WotModel
{
    /**
     * Loads the display data from given request.
     */
    public function load()
    {
        parent::load();

        switch($this->_apiCall) {
            case 'search':
                $this->_data = $this->getEvent(
                    'search',
                    '',
                    WotConfig::$wotApiFields['events']['search']
                );
                break;

            case 'accountinfo':
                $this->_data = $this->getEvent(
                    'accountinfo',
                    $this->_requestData[$this->_apiCall],
                    WotConfig::$wotApiFields['events']['accountinfo']
                );
                break;

            default:
                $this->_data['error'] = 1;
                $this->_data['error_msg'] = 'Unknown Request invoked. "'.$this->_apiCall.'"';
        }
    }
}