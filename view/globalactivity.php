<?php
/**
 * Created by PhpStorm.
 * User: luklas
 * Date: 8/1/16
 * Time: 10:11 AM
 */

date_default_timezone_set(date_default_timezone_get());

function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

echo '
<html>
<head>
    ';
include 'head.php';
echo '
</head>
<body>
';

if (isset($_SESSION['user']['logged_in']))
    include 'navbarloggedin.php';
else
    include 'navbar.php';

echo '
<div class="row">
        <h1 class="center-align" style="margin-bottom: 0;">Activity</h1>
        <h5 class="center-align">from all acounts</h5>
        <p class="center-align"><a href="index.php?action=activity">Switch to your friends activity</a></p>
</div>';

?>
    <div class="row">
        <div class="col l5 push-l1">

            <ul class="collection with-header">
                <li class="collection-header"><h5>Recent Submissions</h5></li>
                <?php foreach ($recent_submissions as $submission) { ?>

                    <li class="collection-item truncate">
                        <div>
                            <?php $time = ($submission['submission_time']); ?>
                                <span class="<?php if($submission['correct']) echo("green-text"); else echo("red-text"); ?>"><b><u><a class="<?php if($submission['correct']) echo("green-text"); else echo("red-text"); ?>" href="index.php?action=show_account&username=<?php echo(htmlspecialchars($submission['username']));?>"><?php echo(htmlspecialchars($submission['username'])); ?></a></u></b> <?php if($submission['correct']) echo("solved"); else echo("attempted"); ?>&nbsp<a class="<?php if($submission['correct']) echo("green-text"); else echo("red-text"); ?>"><b><u><a class="<?php if($submission['correct']) echo("green-text"); else echo("red-text"); ?>" href="index.php?action=find_problem_details&problem_id=<?php echo(htmlspecialchars($submission['problem_id'])); ?>"><?php echo(htmlspecialchars($submission['problem_name'])); ?></a></u></b>
                                </span>
                            <span class="secondary-content <?php if($submission['correct']) echo("green-text"); else echo("red-text"); ?>">
                                <?php echo time_elapsed_string($time); ?>
                             </span>
                        </div>
                    </li>

                <?php } ?>
            </ul>

        </div>

        <div class="col l5 push-l1">

                <ul class="collection with-header">
                    <li class="collection-header"><h5>Recent Comments</h5></li>
                    <?php foreach (get_recent_comments() as $comment) { ?>

                        <li class="collection-item truncate">
                            <div>
                                <?php $time = ($comment['submission_time']); ?>
                                <span><a class="black-text" style="text-decoration: underline;" href="index.php?action=show_account&username=<?php echo(htmlspecialchars($comment['username']));?>"><?php echo(htmlspecialchars($comment['username']));?></a> commented on <a class="black-text" style="text-decoration: underline;" href="index.php?action=find_problem_details&problem_id=<?php echo(htmlspecialchars($comment['pid'])); ?>"><?php echo(htmlspecialchars($comment['problem_name'])); ?></a> </span>
                                <span class="right"><?php echo(time_elapsed_string($comment['timestamp']));?>

                            </div>
                        </li>

                    <?php } ?>
                </ul>

            </div>
    </div>
    <div class="row">
        <div class="col l5 push-l1">

        <ul class="collection with-header">
            <li class="collection-header"><h5>Recent Problems Added</h5></li>
            <?php foreach ($recent_problems as $problem) { ?>

                <li class="collection-item truncate">
                    <div>
                        <?php $time = $problem['add_time']; ?>
                        <span class="black-text"><b><u><a class="black-text" href="index.php?action=show_account&username=<?php echo(htmlspecialchars($problem['username']));?>"><?php echo(htmlspecialchars($problem['username'])); ?></a></u>&nbsp</b>added<b><a class="black-text">&nbsp<u><a class="black-text" href="index.php?action=find_problem_details&problem_id=<?php echo(htmlspecialchars($problem['problem_id'])); ?>"><?php echo(htmlspecialchars($problem['problem_name'])); ?></a></u></b>
                                </span>
                        <span class="secondary-content black-text">
                                <?php echo time_elapsed_string($time); ?>
                             </span>
                    </div>
                </li>

            <?php } ?>
        </ul>
        </div>
    </div>
    <div class="row">
        <div class="center-align">
            <p class="grey-text grey-lighten-3">Have some costs to offset |: </p>
            <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <!-- gsfgdd -->
            <ins class="adsbygoogle"
                 style="display:inline-block;width:728px;height:90px"
                 data-ad-client="ca-pub-4379021343880694"
                 data-ad-slot="8106565564"></ins>
            <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </div>
    </div>
<?php

echo '
</body>
</html>
';