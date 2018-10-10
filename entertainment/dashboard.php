<?php
$user = new User('users');
if(!$user->isUserLoggedIn()) {
    Core::redirect($siteName);
    exit();
}
if(!$user->hasRole('sales_groupshopper'))
	include_once ('view/errors/no-access.php');
	
//employee_to_locations->id 	employee 	location
//groupshopper_contract_locations->id,contract,location,type	
//print_r($_SESSION);

$user_id = $_SESSION['u_userid'];
$client = $_SESSION['u_client_id'];
$client_name = $_SESSION['u_client_name'];

$groupshopper = new GroupShopper();
//groupshopper_get_locations_active 315
$res_contract = $groupshopper->groupshopper_get_active_contracts_by_client($client);
$count_contract = Ado::count($res_contract);
$show_data = true;
if($count_contract==0)
	$show_data = false;
	

$row_contract = Ado::fetch($res_contract);
$end_date  = $row_contract['expires'];
$show_renew_groupshopper = false;
if(!empty($end_date))
{
	$days_remaining = dateCalculate(date('Y-m-d'),$end_date);
	if(intval($days_remaining)<91)
		$show_renew_groupshopper = true;
}

if($_SESSION['u_type']=='corp_owner') {
	$res_coach_dashboard = $groupshopper->groupshopper_client_dashboard_corp_owner($client);
} else
	$res_coach_dashboard = $groupshopper->groupshopper_client_dashboard($client,$user_id);
?>
<script type="text/javascript" charset="utf-8">
jQuery.extend( jQuery.fn.dataTableExt.oSort, {
   "datetime-us-pre": function ( a ) {
       var b = a.match(/(\d{1,2})\-(\d{1,2})\-(\d{2,4}) (\d{1,2}):(\d{1,2}):(\d{1,2}) (am|pm|AM|PM|Am|Pm)/),
           month = b[1],
           day = b[2],
           year = b[3],
           hour = b[4],
           min = b[5],
		   sec = b[6],
           ap = b[7];
 
       if(hour == '12') hour = '0';
       if(ap == 'pm') hour = parseInt(hour, 10)+12;
 
       if(year.length == 2){
           if(parseInt(year, 10)<70) year = '20'+year;
           else year = '19'+year;
       }
       if(month.length == 1) month = '0'+month;
       if(day.length == 1) day = '0'+day;
       if(hour.length == 1) hour = '0'+hour;
       if(min.length == 1) min = '0'+min;
	   if(sec.length == 1) sec = '0'+sec;
 
       var tt = year+month+day+hour+min;
       return  tt;
   },
   "datetime-us-asc": function ( a, b ) {
       return a - b;
   },
 
   "datetime-us-desc": function ( a, b ) {
       return b - a;
   }
});
 
jQuery.fn.dataTableExt.aTypes.unshift(
   function ( sData )
   {
       if (sData !== null && sData.match(/\d{1,2}\/\d{1,2}\/\d{2,4} \d{1,2}:\d{1,2} (am|pm|AM|PM|Am|Pm)/))
       {
 
           return 'datetime-us';
       }
       return null;
   }
);

$(document).ready(function() {
	$('#example').dataTable( {
	"aaSorting": [],
	"aoColumns": [null, null, null, {"sType": "datetime-us" }],
	"aoColumnDefs": [{ 'bSortable': false, 'aTargets': [ ] }],
	"iDisplayLength": 25,
	"aLengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]]
	});
} );

</script>

<div class="container-narrow for_content">
  <div id="content">
    <div id="box">
      <?php if($show_data) { ?>
      <h3 class="dashtitle"><span>Dashboard</span></h3>
      <?php if(!empty($end_date) and ($show_renew_groupshopper)) { ?>
      <div>Your subscription expires in <?php echo $days_remaining;?>. Talk with TrainerTainment about our Sales groupshopper program.</div>
      <?php } ?>
      <div>
        <table width="100%" cellpadding="0" cellspacing="0" border="0" class="display margintable table table-striped theme_table with_tfoot" id="example">
          <thead>
            <tr>
              <th>Location</th>
              <th>Average</th>
              <th>Failed Attempt</th>
              <th>Last Call</th>
            </tr>
          </thead>
          <tbody>
            <?php while($row_coach_dashboard = Ado::fetch($res_coach_dashboard)) { ?>
            <tr>
              <td><a href="<?php echo getUserLink('groupshopper', 'open-location',$row_coach_dashboard['location']);?>"><?php echo unclean($row_coach_dashboard['name']);?></a> </td>
              <td><?php echo $row_coach_dashboard['avg'];?></td>
              <td><?php echo $row_coach_dashboard['failed_attempts'];?></td>
              <td><?php echo !empty($row_coach_dashboard['last_call'])?dateTimeFormat($row_coach_dashboard['last_call']):'';?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
      <?php } else { ?>
      <?php if($_SESSION['u_type']=='corp_owner' or $_SESSION['u_type']=='owner') { ?>
      <div style="height:300px;"><strong>Do you want to increase your sales more? </strong> <br />
          Talk with TrainerTainment about our Sales groupshopper program. <br />
          <br />
          Our Sales groupshopper program will help you identify ways to increase your birthday and group sales, and our coaching program will take your sales to the next level.</div>
      <?php } else { ?>
      <div style="height:300px;">You are not associated with a location that has an active contract.</div>
      <?php } ?>
      <?php } ?>
    </div>
  </div>
</div>
<br/>
