<?php
/*
 * Copyright (c) 2012-2016 Veridu Ltd <https://veridu.com>
 * All rights reserved.
 */
declare(strict_types = 1);

namespace Cli\Utils;

/**
 * Util class for TraceSmart.
 */
class TraceSmart {
    private $wsdl;
    private $user;
    private $pass;
    private $equifax;

    public function __construct(array $settings, $clientId = null) {
        $this->wsdl = $settings['wsdl'];
        $credentials = $settings['auth']['veridu'];

        $this->user = $credentials['user'];
        $this->pass = $credentials['pass'];
        $this->equifax = $credentials['equifax'];
        $this->setup = $settings['fields'];
    }

    /**
     * Build the parameters used in the TraceSmart request.
     *
     * @param array  $fields
     * @param array  $param
     *
     * @return array
     */
    private function buildParams(array $fields, array $param) {
        $params = new \stdClass;

        $params->IDU = new \stdClass;
        // Reference is optional but recommended for tracking
        $params->IDU->Reference = (empty($param[2]) ? '' : $param[2]);
        // ID and IKey should be passed to continue a previous search
        $params->IDU->ID = (empty($param[0]) ? '' : $param[0]);
        $params->IDU->IKey = (empty($param[1]) ? '' : $param[1]);
        $params->IDU->Scorecard = 'IDU Default';
        $params->IDU->equifaxUsername = $this->equifax;

        $params->Person = new \stdClass;
        // Subject details
        $params->Person->forename = (empty($fields['firstname']) ? '' : $fields['firstname']);
        $params->Person->middle = (empty($fields['middlename']) ? '' : $fields['middlename']);
        $params->Person->surname = (empty($fields['lastname']) ? '' : $fields['lastname']);
        $params->Person->gender = (empty($fields['gender']) ? '' : strtoupper($fields['gender'][0]));
        if ((empty($fields['birthyear'])) || (empty($fields['birthmonth'])) || (empty($fields['birthday']))) {
            $params->Person->dob = '';
        } else {
            $params->Person->dob = "{$fields['birthyear']}-{$fields['birthmonth']}-{$fields['birthday']}";
        }

        // Subject address details
        foreach (array('address1', 'address2', 'address3', 'address4', 'address5', 'address6', 'postcode') as $item) {
            if (empty($fields[$item])) {
                $params->Person->{$item} = '';
            } else {
                $params->Person->{$item} = $fields[$item];
            }
        }

        // Passport
        if (empty($fields['passport2'])) {
            foreach (array('passport1', 'passport2', 'passport3', 'passport4', 'passport5', 'passport6', 'passport7', 'passport8') as $item) {
                $params->Person->{$item} = '';
            }
        } else {
            $params->Person->passport1 = substr($fields['passport2'], 0, 9);
            $params->Person->passport2 = substr($fields['passport2'], 9, 1);
            $params->Person->passport3 = substr($fields['passport2'], 10, 3);
            $params->Person->passport4 = substr($fields['passport2'], 13, 7);
            $params->Person->passport5 = substr($fields['passport2'], 20, 1);
            $params->Person->passport6 = substr($fields['passport2'], 21, 7);
            $params->Person->passport7 = substr($fields['passport2'], 28, 14);
            $params->Person->passport8 = substr($fields['passport2'], 42, 2);
        }

        // Travel Visa
        foreach (array('travelvisa1', 'travelvisa2', 'travelvisa3', 'travelvisa4', 'travelvisa5', 'travelvisa6', 'travelvisa7', 'travelvisa8', 'travelvisa9') as $item) {
            if (empty($fields[$item])) {
                $params->Person->{$item} = '';
            } else {
                $params->Person->{$item} = $fields[$item];
            }
        }

        // ID Card
        foreach (array('idcard1', 'idcard2', 'idcard3', 'idcard4', 'idcard5', 'idcard6', 'idcard7', 'idcard8', 'idcard9', 'idcard10') as $item) {
            if (empty($fields[$item])) {
                $params->Person->{$item} = '';
            } else {
                $params->Person->{$item} = $fields[$item];
            }
        }

        // Driving Licence
        if (empty($fields['drivinglicence'])) {
            foreach (array('drivinglicence1', 'drivinglicence2', 'drivinglicence3') as $item) {
                $params->Person->{$item} = '';
            }
        } else {
            $params->Person->drivinglicence1 = substr($fields['drivinglicence'], 0, 5);
            $params->Person->drivinglicence2 = substr($fields['drivinglicence'], 5, 6);
            $params->Person->drivinglicence3 = substr($fields['drivinglicence'], 11, 5);
        }

        foreach (array('drivingpostcode', 'drivingmailsort') as $item) {
            if (empty($fields[$item])) {
                $params->Person->{$item} = '';
            } else {
                $params->Person->{$item} = $fields[$item];
            }
        }

        // Card Number
        foreach (array('cardnumber', 'cardtype') as $item) {
            if (empty($fields[$item])) {
                $params->Person->{$item} = '';
            } else {
                $params->Person->{$item} = $fields[$item];
            }
        }

        $params->Person->cardavs = new \stdClass;
        // Card AVS
        $params->Person->cardavs->CardType = (empty($fields['card-type']) ? '' : $fields['card-type']);
        $params->Person->cardavs->CardHolder = (empty($fields['card-holdername']) ? '' : $fields['card-holdername']);
        $params->Person->cardavs->CardNumber = (empty($fields['card-number']) ? '' : $fields['card-number']);
        $params->Person->cardavs->CardStart = (empty($fields['card-startdate']) ? '' : $fields['card-startdate']);
        $params->Person->cardavs->CardExpire = (empty($fields['card-expiredate']) ? '' : $fields['card-expiredate']);
        $params->Person->cardavs->CV2 = (empty($fields['card-cv2']) ? '' : $fields['card-cv2']);
        $params->Person->cardavs->IssueNumber = (empty($fields['card-issuenumber']) ? '' : $fields['card-issuenumber']);
        $params->Person->cardavs->CardAddress = new \stdClass;
        $params->Person->cardavs->CardAddress->Address1 = (empty($fields['card-address1']) ? '' : $fields['card-address1']);
        $params->Person->cardavs->CardAddress->Address2 = (empty($fields['card-address2']) ? '' : $fields['card-address2']);
        $params->Person->cardavs->CardAddress->Address3 = (empty($fields['card-address3']) ? '' : $fields['card-address3']);
        $params->Person->cardavs->CardAddress->Address4 = (empty($fields['card-address4']) ? '' : $fields['card-address4']);
        $params->Person->cardavs->CardAddress->Address5 = (empty($fields['card-address5']) ? '' : $fields['card-address5']);
        $params->Person->cardavs->CardAddress->Postcode = (empty($fields['card-postcode']) ? '' : $fields['card-postcode']);
        $params->Person->cardavs->CardAddress->DPS = (empty($fields['card-dps']) ? '' : $fields['card-dps']);

        // NI
        $params->Person->ni = (empty($fields['ni']) ? '' : $fields['ni']);

        // NHS
        $params->Person->nhs = (empty($fields['nhs']) ? '' : $fields['nhs']);

        // Telephone Number
        foreach (array('telephone', 'telephone2') as $item) {
            if (empty($fields[$item])) {
                $params->Person->{$item} = '';
            } else {
                $params->Person->{$item} = $fields[$item];
            }
        }

        // Mobile number
        foreach (array('mobile', 'mobile2') as $item) {
            if (empty($fields[$item])) {
                $params->Person->{$item} = '';
            } else {
                $params->Person->{$item} = $fields[$item];
            }
        }

        if (!empty($fields['phone'])) {
            if (empty($params->Person->mobile)) {
                $params->Person->mobile = $fields['phone'];
            } else if (empty($params->Person->mobile2)) {
                $params->Person->mobile2 = $fields['phone'];
            }
        }

        // Phoneverify
        $params->Person->phoneverifyTelephone1 = '';
        $params->Person->phoneverifyTelephone2 = '';
        $params->Person->phoneverifyMobile1    = '';
        $params->Person->phoneverifyMobile2    = '';

        // Birth Details
        $params->Person->bforename = (empty($fields['birthfname']) ? '' : $fields['birthfname']);
        $params->Person->bmiddle = (empty($fields['birthmname']) ? '' : $fields['birthmname']);
        $params->Person->bsurname = (empty($fields['birthlname']) ? '' : $fields['birthlname']);
        $params->Person->maiden = (empty($fields['mothermname']) ? '' : $fields['mothermname']);

        // Electricity Bill
        foreach (array('mpannumber1', 'mpannumber2', 'mpannumber3', 'mpannumber4') as $item) {
            if (empty($fields[$item])) {
                $params->Person->{$item} = '';
            } else {
                $params->Person->{$item} = $fields[$item];
            }
        }

        // Bank Account
        foreach (array('sortcode', 'accountnumber') as $item) {
            if (empty($fields[$item])) {
                $params->Person->{$item} = '';
            } else {
                $params->Person->{$item} = $fields[$item];
            }
        }

        return $params;
    }

    /**
     * Additional tweaks for the parameters sent to the TraceSmart request.
     *
     * @param mixed  $params
     * @param array  $setup
     *
     * @return array
     */
    private function setup(&$params, array $setup) {
        $params->Services = new \stdClass;
        foreach (array_keys($this->setup) as $item) {
            if (in_array($item, array('ccj-dob', 'ccj-address'))) {
                $name = 'ccj';
            } else {
                $name = str_replace('-', '', $item);
            }

            $params->Services->{$name} = in_array($item, $setup);
        }
    }

    /**
     * Send the TraceSmart request and return the response.
     *
     * @param mixed  $setup
     * @param mixed  $fields
     * @param mixed  $param
     *
     * @return array
     */
    public function execute($setup, $fields, $param) {
        if (!is_array($setup)) {
            $setup = explode(',', $setup);
        }

        if (!is_array($param)) {
            $param = explode(',', $param);
        }

        $params = $this->buildParams($fields, $param);
        $this->setup($params, $setup);

        $params->Login = new \stdClass;
        $params->Login->username = $this->user;
        $params->Login->password = $this->pass;

        $soap = new \SoapClient($this->wsdl);
        return (array) $soap->IDUProcess($params);
    }
}