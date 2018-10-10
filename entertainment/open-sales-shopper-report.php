<?php
$user = new User('users');
if(!$user->isUserLoggedIn()) {
    Core::redirect($siteName);
    exit();
}
if(!$user->hasRole('sales_shopper'))
	include_once ('view/errors/no-access.php');

$report_id = $_GET['id'];
$shopper = new Shopper();

$res_report = $shopper->shopper_birthday_report($report_id);
$row_report = Ado::fetch($res_report);

$location_id = $row_report['location'];

$res_location = $shopper->shopper_location_call_info($location_id);
$row_location = Ado::fetch($res_location);

$queue = $row_report['queue'];
$res_fail_attempt_report = $shopper->shopper_get_birthday_call_failed_attempt($report_id);


?>

<div class="container-narrow for_content">
  <div id="content">
    <div id="box">
      <h6 class="dashtitle"><a href="<?php echo getUserLink('shopper', 'dashboard'); ?>">Dashboard</a> &rarr; <a href="<?php echo getUserLink('shopper', 'open-location',$location_id); ?>"><?php echo unclean($row_location['name']);?></a> &rarr; Report On: <?php echo dateTimeFormat($row_report['taken_on']);?></h6>
      <div>
        <h4 class="dashtitle withbg">Call Info</h4>
        <div>
          <h6  class="minisec_title"><?php echo unclean($row_report['first_name']).' '.unclean($row_report['last_name']);?></h6>
          <div class="tablelikecont">Call Made On: <?php echo dateTimeFormat($row_report['taken_on']);?> <br>
            Score: <?php echo $row_report['average'];?> </div>
        </div>
      </div>
      <div>
        <h4 class="dashtitle withbg">Location Information</h4>
        <div>
          <h6  class="minisec_title"><?php echo unclean($row_report['location_name']);?></h6>
          <div class="tablelikecont"> <a target="_blank" href="<?php echo unclean($row_location['website']);?>"> <?php echo unclean($row_location['website']);?> </a><br>
            <?php echo unclean($row_report['address']);?> <br>
            <?php echo unclean($row_report['city']).', '.unclean($row_report['state']).' '.$row_report['zip'];?></div>
        </div>
      </div>
      <div>
        <h4 class="dashtitle withbg">Failed Attempts</h4>
        <div>
          <?php while($row_fail_attempt_report = Ado::fetch($res_fail_attempt_report)) { ?>
          <div>
            <h6  class="minisec_title"><?php echo unclean($row_fail_attempt_report['first_name']).' '.unclean($row_fail_attempt_report['last_name']);?>: <?php echo dateTimeFormat($row_fail_attempt_report['created_on']);?> </h6>
            <div class="tablelikecont"> <?php echo unclean($row_fail_attempt_report['comments']);?> </div>
          </div>
          <?php } ?>
        </div>
      </div>
      <div>
        <h4 class="dashtitle withbg">Call Questions</h4>
        <div class="user_tables">
          <table class="table table-striped theme_table">
            <tbody>
              <tr>
                <td><?php echo $row_report['question_1'];?> Sales representative identify themselves?(3 points possible)Who answered? <?php echo unclean($row_report['answer_1']);?> </td>
              </tr>
              <tr>
                <td><?php echo $row_report['question_2'];?> The representative inquired about the child first?(5 points possible) </td>
              </tr>
              <tr>
                <td><?php echo $row_report['question_3'];?> Boy/Girl?(3 points possible) </td>
              </tr>
              <tr>
                <td><?php echo $row_report['question_3_b'];?> Child/Adult?(3 points possible) </td>
              </tr>
              <tr>
                <td><?php echo $row_report['question_4'];?> Age?(3 points possible) </td>
              </tr>
              <tr>
                <td><?php echo $row_report['question_5'];?> Name?(5 points possible) </td>
              </tr>
              <tr>
                <td><?php echo $row_report['question_7'];?> The representative seemed enthusiastic with the details?(10 points possible) </td>
              </tr>
              <tr>
                <td><?php echo $row_report['question_8'];?> The representative mentioned the price at the end?(10 points possible) If no when was price mentioned? <?php echo $row_report['answer_8'];?> </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div>
        <h4 class="dashtitle withbg">Closing Questions</h4>
        <div class="user_tables">
          <table class="table table-striped theme_table">
            <tbody>
              <tr>
                <td><?php echo $row_report['question_17'];?> The representative ask, “of these parties, which do you think your child would enjoy the most”?(5 points possible) </td>
              </tr>
              <tr>
                <td><?php echo $row_report['question_9'];?> The representative gave the option to have the party during the week?(5 points possible) </td>
              </tr>
              <tr>
                <td><?php echo $row_report['question_11'];?> The representative asked to place a deposit?(5 points possible) How much was the deposit? <?php echo $row_report['answer_11'];?> </td>
              </tr>
              <tr>
                <td><?php echo $row_report['question_12'];?> The representative asked to have a party?(15 points possible) </td>
              </tr>
              <tr>
                <td><?php echo $row_report['question_13'];?> The representative seemed knowledgeable?(10 points possible) </td>
              </tr>
              <tr>
                <td><?php echo $row_report['question_14'];?> The representative used the birthday king/queens name at least 1 time during the call?(10 points possible) </td>
              </tr>
              <tr>
                <td><?php echo $row_report['question_15'];?> The representative friendliness rating(10 points possible) </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div>
        <h4 class="dashtitle withbg">Bonus Questions</h4>
        <div class="user_tables">
          <table class="table table-striped theme_table">
            <tbody>
              <tr>
                <td><?php echo $row_report['question_16'];?> The representative used the birthday king/queen's name more than one time?(5 points possible) </td>
              </tr>
              <tr>
                <td><?php echo $row_report['question_18'];?> The representative try to sell additional items or upsell the birthday?(5 points possible) </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <?php if($row_report['receives_recording']=='1' and !empty($row_report['recording'])) { ?>
      <div>
        <h4 class="dashtitle withbg">Recording</h4>
        <div class="tablelikecont"> <a target="_blank" href="<?php echo unclean($row_report['recording']);?>">Download Recording</a> </div>
      </div>
      <?php } ?>
      <div>
        <h4 class="dashtitle withbg">Comments</h4>
        <div class="tablelikecont"><?php echo unclean($row_report['comments']);?></div>
      </div>
    </div>
  </div>
</div>
<br/>
