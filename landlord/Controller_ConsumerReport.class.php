<?php

// Renders the content of a page into a full HTML page via Smarty';

require_once($router->shared . '/Controller_with_tailored_rent.class.php');
class ConsumerReport extends Controller_with_tailored_rent
{
        public $html;

        public function __construct(){
        }

            public function criminal_report($xml)
            {
                $this->html = '';
                $MISMO = $xml->BackgroundReportPackage->Screenings->Screening->GatewayXml->MISMO;
                $this->html = "criminal report";


                $this->html .= '<tbody id="resultsRecords" style="">';
                $this->html .= '  <tr>';
                $this->html .= '    <td colspan="4">';
                                     foreach($xml->BackgroundReportPackage->Screenings->Screening->GatewayXml->ResponseData->Records->Record as $Record){
                $this->html .= '            <div>';
                $this->html .= empty($Record->Offender->FullName) ? '' : "<span class='data'>Full Name: </span><br><span class='data'>{$Record->Offender->FullName}</span><br>";
                $this->html .= empty($Record->Offender->DOB) ? '' : "<span class='data'>{$Record->Offender->DOB}</span><br>";
                                foreach($Record->Offender->OtherPersonalIdentifiers as $key => $value){
                $this->html .=                "<span class='data'>{$key} </span><br><span class='data'>{$value}</span><br>";
                               }
                                foreach($Record->Address as $key => $value){
                $this->html .=                "<span class='data'>{$key}: </span><br><span class='data'>{$value}</span><br>";
                               }
                $this->html .= empty($Record->AliasNames) ? '' : "<span class='data'>{$Record->AliasNames}</span><br>";
                $this->html .= '            </div>';
                $this->html .= empty($Record->Provider) ? '' : "<span class='data'>{$Record->Provider}</span><br>";
                $this->html .= empty($Record->Jurisdiction) ? '' : "<span class='data'>{$Record->Jurisdiction}</span><br>";
                $this->html .= empty($Record->StateAbbreviation) ? '' : "<span class='data'>{$Record->StateAbbreviation}</span><br>";
                                foreach($Record->Offenses->Offense as $Offense){
                $this->html .= '              <div>';
                $this->html .= empty($Offense->Jurisdiction) ? '' : "<span class='data'>{$Offense->Jurisdiction}</span><br>";
                $this->html .= empty($Offense->Description) ? '' : "<span class='data'>{$Offense->Description}</span><br>";
                $this->html .= empty($Offense->OffenseType) ? '' : "<span class='data'>{$Offense->OffenseType}</span><br>";
                $this->html .= empty($Offense->DispositionDate) ? '' : "<span class='data'>{$Offense->DispositionDate}</span><br>";
                $this->html .= '                <div>';
                $this->html .= '                  <div>';
                $this->html .=                    "<span class='data'>{$Offense->Disposition->Info->Label}</span><br>";
                $this->html .=                    "<span class='data'>{$Offense->Disposition->Info->Data}</span><br>";
                $this->html .= '                  </div>';
                $this->html .= '                </div>';
                $this->html .= empty($Offense->OffenseDate) ? '' : "<span class='data'>{$Offense->OffenseDate}</span><br>";
                $this->html .= '                <div>';
                $this->html .= '                  <div>';
                $this->html .=                    "<span class='data'>{$Offense->Sentence->Info->Label}</span><br>";
                $this->html .=                    "<span class='data'>{$Offense->Sentence->Info->Data}</span><br>";             
                $this->html .= '                  </div>';
                $this->html .= '                </div>';
                $this->html .= empty($Offense->Probation) ? '' : "<span class='data'>{$Offense->Probation}</span><br>";
                $this->html .= empty($Offense->Confinement) ? '' : "<span class='data'>{$Offense->Confinement}</span><br>";
                $this->html .= empty($Offense->ArrestingAgency) ? '' : "<span class='data'>{$Offense->ArrestingAgency}</span><br>";
                $this->html .= empty($Offense->OriginatingAgency) ? '' : "<span class='data'>{$Offense->OriginatingAgency}</span><br>";
                $this->html .= empty($Offense->StatuteNumber) ? '' : "<span class='data'>{$Offense->StatuteNumber}</span><br>";
                $this->html .= empty($Offense->Plea) ? '' : "<span class='data'>{$Offense->Plea}</span><br>";
                $this->html .= empty($Offense->CourtDecision) ? '' : "<span class='data'>{$Offense->CourtDecision}</span><br>";
                $this->html .= empty($Offense->CourtCosts) ? '' : "<span class='data'>{$Offense->CourtCosts}</span><br>";
                $this->html .= empty($Offense->Fine) ? '' : "<span class='data'>{$Offense->Fine}</span><br>";
                $this->html .= empty($Offense->ArrestDate) ? '' : "<span class='data'>{$Offense->ArrestDate}</span><br>";
                $this->html .= empty($Offense->SentenceDate) ? '' : "<span class='data'>{$Offense->SentenceDate}</span><br>";
                $this->html .= empty($Offense->FileDate) ? '' : "<span class='data'>{$Offense->FileDate}</span><br>";
                                              foreach($Offense->Details->Detail as $Detail){
                $this->html .= "                    <span class='data'>{$Detail->Origin}</span><br>";
                               foreach($Detail->Supplements->Supplement as $Supplement){
                $this->html .= '                      <div>';
                $this->html .=                        "<span class='data'>{$Supplement->DisplayTitle}</span><br>";
                $this->html .=                        "<span class='data'>{$Supplement->DisplayValue}</span><br>";
                $this->html .= '                      </div>';
                                  }
                                  }
                $this->html .= '              </div>';
                                }

                               }
                $this->html .= '    </td>';
                $this->html .= '  </tr>';
                $this->html .= '  <tr>';
                $this->html .= '    <td colspan="4">';
                $this->html .= '      &nbsp;';
                $this->html .= '    </td>';
                $this->html .= '  </tr>';
                $this->html .= '</tbody>                    ';
                $this->html .= '<tbody>';
                $this->html .= '  <tr>';
                $this->html .= '    <td colspan="4" style="text-align:center;padding-top:15px;padding-bottom:15px;">';
                $this->html .= '                                      From around the nation, data provided by CORE® is compiled from multiple public record data sources. Most records are returned by matching the Date of Birth, exact Last Name and the exact First Name. In some limited cases, the jurisdiction may not provide a Date of Birth, so a record may be returned on a name match only. All records that are returned (whether with a Date of Birth, or not) should be reviewed to see if they match your applicant. Reliable Background Screening (Reliable) acknowledges that the CORE® service provided here does not always substitute for an in person courthouse search of criminal records; however, if you need further research, Reliable can provide these additional investigative services. Reliable takes reasonable measures to update these records as available, but as in all public records, we rely on the completeness and accuracy of the information that is provided by each state, county or other jurisdiction.';
                $this->html .= '    </td>';
                $this->html .= '  </tr>';
                $this->html .= '</tbody>';

                return $this->html;
           }

		function eviction_report($xml){
			$this->html = '';
			
$this->html .= '<tbody id="resultsRecords" style="">';
$this->html .= '<tr>';
$this->html .= '<td colspan="4">';
      $record_keys = array("CaseNumber","CaseType","CaseDisposition","CaseComments","CourtLocation","ReferenceId","InDispute","Statement","ClaimAmount","JudgmentAmount","FiledDate","DisposedDate","Defendant","FullName","SSN","Address","AddressLine","City","State","ZipCode","Book","Page","OtherCaseNunber","Plaintiff","PlaintiffPhone","CaseConsumerStatement","Message");

      foreach($xml->BackgroundReportPackage->Screenings->Screening->GatewayXml->ResponseData->Records->Record as $Record){
        foreach($record_keys as $key_name){
		$result = $Record->xpath($key_name);
		foreach($result as $element){
          		$this->html .= empty($element) ? '' : "<span class='reportlabel'>{$key_name}: </span><span>{$element}</span><br>";
        	}
	}
	$this->html .= '<br>';
      }
$this->html .= '</td>';
$this->html .= '</tr>';
$this->html .= '<tr>';
$this->html .= '<td colspan="4">';
$this->html .= '<div id="sediv-$status.expression" contenteditable="false" class="reportBodyPreviewDiv" unselectable="on" usepredefremarks="true"></div>';
$this->html .= '</td>';
$this->html .= '</tr>';
$this->html .= '</tbody>';

			return $this->html;
		}
}
