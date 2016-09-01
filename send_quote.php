<?php

require 'application/Common.php';
require 'vendor/autoload.php';

$sendEmail = new Email();

//Form post data
$full_name = e($_POST['fullName']);
$user_email = e($_POST['emailAddress']);
$price_list = $_POST['reportData'];
$price_list = str_replace('[object HTMLInputElement]','',$price_list);
$price_list = str_replace('<br >','',$price_list);

if ($user_email != '') {
    //Add lead to database
    $sendEmail->addLead($full_name, $user_email, $price_list);

    $total_sent = 0;
    $track_url = SCRIPT_URL . 'link.php';
    $start_time = date('Y-m-d H:i:s');
    $server = e($_GET['server']);
    if (empty($server)) {
        $server = DEFAULT_SERVER;
    }

    # Instantiate the Sendgrid SDK with API credentials.
    $sendgrid = new SendGrid(SENDGRID_KEY);
    $sg_email = new SendGrid\Email();

    //Get email template for quote email
    $email_type = 'estimate';
    $emailTemplates = $sendEmail->getTemplates($email_type);

    foreach ($emailTemplates as $templates):
        $tid = $templates['unique_id'];
        $email_subject = e($templates['email_subject']);
        $html_body = $templates['html_body'];
        $text_body = e($templates['text_body']);
        $from_name = e($templates['from_name']);
        $from_email = e($templates['from_email']);
        $bounce_email = e($templates['bounce_email']);
    endforeach;

    //Find all links in the html template and replace them with tracking urls
    $find_href = 'href="';
    $replace_href = 'href="' . $track_url . '?type=link&uid={uid}&tid={tid}&url=';
    $html_email = str_replace($find_href, $replace_href, $html_body);

    //Open tracking image that uses mod_rewrite in .htaccess to reroute to link.php for recording the open
    $open_bug = '<img src="' . SCRIPT_URL . $user_id . '_' . $tid . '_open.gif">';

    //Replace tags in template
    $html_email = str_replace('{estimate}', $price_list, $html_email);
    $html_email = str_replace('{full_name}', ucfirst($full_name), $html_email);
    $html_email = str_replace('{uid}', $user_email, $html_email);
    $html_email = str_replace('{tid}', $tid, $html_email);
    $html_email = str_replace('{open_bug}', $open_bug, $html_email);

    $text_email = str_replace('{estimate}', $price_list, $text_email);
    $text_email = str_replace('{full_name}', ucfirst($full_name), $text_body);
    $text_email = str_replace('{uid}', $user_email, $text_email);
    $text_email = str_replace('{tid}', tid, $text_email);

    //If user email is NOT valid this sets send email info to admin so they can clean it from list
    if (!filter_var($user_email, FILTER_VALIDATE_EMAIL) === true) {
        $html_email = 'Invalid user email ' . $user_email . ' [' . $user_id . ']. Please fix or archive this from your list';
        $text_email = 'Invalid user email ' . $user_email . ' [' . $user_id . ']. Please fix or archive this from your list';
        $first_name = ADMIN_EMAIL_NAME;
        $member_email = ADMIN_EMAIL;
    }

    //Compose and send message to sendgrid api
    if ($server == "sendgrid") {
        $sg_email
            ->setFromName($from_name)
            ->setFrom($from_email)
            ->addTo($user_email)
            ->setSubject($email_subject)
            ->setText($text_email)
            ->setHtml($html_email);

        try {
            $sendgrid->send($sg_email);
        } catch (\SendGrid\Exception $e) {
            echo $e->getCode();
            foreach ($e->getErrors() as $er) {
                echo $er;
            }
        }
    }
}
