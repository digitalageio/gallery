<?php
$date = 'NOW()';
echo "<!-- edit call -->";

if (isset($_POST['btn_submit_edit']) && !empty($_POST['btn_submit_edit']))
{
	if($_POST['type'] == 2){
        $groupshopper = new GroupShopper('groupshopper_shoppers');
        $table = 'groupshopper_shoppers';
        echo "<!-- new groupshopper -->";
        $user = $_SESSION['a_userid'];
                  $question_1 = isset($_POST['question_1'])?5:0;
                  $question_2 = isset($_POST['question_2'])?10:0;
                  $question_3_a = isset($_POST['question_3_a'])?5:0;
                  $question_3_b = isset($_POST['question_3_b'])?5:0;
                  $question_3_c = isset($_POST['question_3_c'])?5:0;
                  $question_4 = isset($_POST['question_4'])?5:0;
                  $question_5 = isset($_POST['question_5'])?5:0;
                  $question_6 = isset($_POST['question_6'])?5:0;
                  $question_7 = isset($_POST['question_7'])?5:0;
                  $question_8 = isset($_POST['question_8'])?10:0;
                  $question_9 = isset($_POST['question_9'])?10:0;
                  $question_10 = isset($_POST['question_10'])?15:0;
                  $question_10_a = isset($_POST['question_10_a'])?5:0;
                  $question_10_b = isset($_POST['question_10_b'])?5:0;
                  $question_10_c = isset($_POST['question_10_c'])?5:0;
                  $question_11 = isset($_POST['question_11'])?10:0;
        $total = $question_1+$question_2+$question_3_a+$question_3_b+$question_3_c+$question_4+$question_5+$question_6+$question_7+$question_8+$question_9+$question_10+$question_10_a+$question_10_b+$question_10_c+$question_11;
        $max_points = 110;
        echo "<!-- $max_points -->";
        echo "<!-- $total -->";

       $array_content = array(
                'question_1'=>$question_1,
                'question_2'=>$question_2,
                'question_3_a'=>$question_3_a,
                'question_3_b'=>$question_3_b,
                'question_3_c'=>$question_3_c,
                'question_4'=>$question_4,
                'question_5'=>$question_5,
                'question_6'=>$question_6,
                'question_7'=>$question_7,
                'question_8'=>$question_8,
                'question_9'=>$question_9,
                'question_10'=>$question_10,
                'question_10_a'=>$question_10_a,
                'question_10_b'=>$question_10_b,
                'question_10_c'=>$question_10_c,
                'question_11'=>$question_11,
                'answer_1'=>clean($_POST['answer_1']),
                'answer_2'=>clean($_POST['answer_2']),
                'answer_8'=>clean($_POST['answer_8']),
                'comments'=>clean($_POST['comments']),
                'total'=>$total,
                'max_points'=>$max_points,
                'last_modified'=>$date
        );
	} else {
        echo "<!-- take call btn_submit_edit-->";
        $groupshopper = new GroupShopper('groupshopper_shoppers');
                $table = 'groupshopper_shoppers';
        echo "<!-- new groupshopper -->";
        $user = $_SESSION['a_userid'];
                  $question_1 = isset($_POST['question_1'])?3:0;
                  $question_2 = isset($_POST['question_2'])?5:0;
                  $question_3 = isset($_POST['question_3'])?3:0;
                  $question_3_b = isset($_POST['question_3_b'])?3:0;
                  $question_4 = isset($_POST['question_4'])?3:0;
                  $question_5 = isset($_POST['question_5'])?5:0;
                  $question_7 = $_POST['question_7'];
                  $question_8 = isset($_POST['question_8'])?10:0;
                  $question_9 = isset($_POST['question_9'])?5:0;
                  $question_11 = isset($_POST['question_11'])?5:0;
                  $question_12 = $_POST['question_12'];
                  $question_13 = $_POST['question_13'];
                  $question_14 = isset($_POST['question_14'])?10:0;
                  $question_15 = $_POST['question_15'];
                  $question_16 = isset($_POST['question_16'])?5:0;
                  $question_17 = isset($_POST['question_17'])?5:0;
                  $question_18 = isset($_POST['question_18'])?5:0;
                  $question_12 = $question_17+$question_9+$question_11;
        $total = $question_1+$question_2+$question_3+$question_3_b+$question_4+$question_5+$question_7+$question_8+$question_9+$question_11+$question_12+$question_13+$question_14+$question_15+$question_16+$question_17+$question_18;
        $max_points = 112;
        echo "<!-- $max_points -->";
        echo "<!-- $total -->";

       $array_content = array(
                'question_1'=>$question_1,
                'question_2'=>$question_2,
                'question_3'=>$question_3,
                'question_3_b'=>$question_3_b,
                'question_4'=>$question_4,
                'question_5'=>$question_5,
                'question_7'=>$question_7,
                'question_8'=>$question_8,
                'question_9'=>$question_9,
                'question_11'=>$question_11,
                'question_12'=>$question_12,
                'question_13'=>$question_13,
                'question_14'=>$question_14,
                'question_15'=>$question_15,
                'question_16'=>$question_16,
                'question_17'=>$question_17,
                'question_18'=>$question_18,
                'answer_1'=>clean($_POST['answer_1']),
                'answer_8'=>clean($_POST['answer_8']),
                'answer_11'=>clean($_POST['answer_11']),
                'comments'=>clean($_POST['comments']),
                'total'=>$total,
                'max_points'=>$max_points,
                'last_modified'=>$date
        );

	}

        echo "<!-- array set -->";
        $edited_id = $groupshopper->edit($array_content,$table,$_POST['groupshopper_report_id']);
        $queue_id= $_POST['queue_id'];
        //$queue_id = $_POST['queue_id'];       
        if($edited_id)
        {
                //update groupshopper_queues with sales_groupshopper, last_modified
                $groupshopper = new GroupShopper('groupshopper_queues');
                $update_array = array('last_modified'=>$date);
                $where_array = array('id'=>$queue_id);
                $groupshopper->update($update_array,$where_array);
                //Email Report
                echo "<!-- emailreport called 2 -->";
                $groupshopper->sendGroupShopperEmailReport($edited_id);

                Core::setMessage("Report edited sucessfully", 1);
        }
        else
                Core::setMessage("Please try again.", -1);
    Core::redirect(getAdminLink('groupshopper', 'dashboard'));

}

echo "<!-- edit call fin -->";
?>
