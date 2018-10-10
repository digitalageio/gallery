<?php

// Renders the content of a page into a full HTML page via Smarty

require_once($router->shared . '/Controller_with_tailored_rent.class.php');
class ConsumerReport extends Controller_with_tailored_rent
{
        public function __construct($renter_id)
        {

	}

	public function get_report($renter_id)
	{
	$reservation = $this->_tables->get('reservations')->get_by_renter($renter_id);

                        $application = $this->_tables->get('applications')->get_by_renter($renter_id);

                        $crim_cred_logs = $this->_tables->get('renters')->get_crim_cred_logs($renter_id);

                        $crim_cred = $this->_tables->get('crim_cred')->get(array(
                            'where' => array('application_id = ?', $application[0]['id'])
                        ))->table;

                        $tailored_rent = $this->_get_tailored_rent($this->_user['id'],$reservation[0]['listing_id']);

                        $xml = new SimpleXMLElement($crim_cred_logs[0]["xml"]);
                        $credit_response = $xml->BackgroundReportPackage->Screenings->Screening->GatewayXml->MISMO->RESPONSE->RESPONSE_DATA->CREDIT_RESPONSE;

			$xml_array = unserialize(serialize(json_decode(json_encode($xml), 1)));

                        if($application[0]['employment_wgpbtad'] > 0){
                            $consumer_report["RENTAILOR_CALC"]["RENT_TO_INCOME"] = ($tailored_rent/4)/$application[0]['employment_wgpbtad'];
                        }
                        else{
                            $consumer_report["RENTAILOR_CALC"]["RENT_TO_INCOME"] = "No income";
                        }

			return $consumer_report;

	}

}

