<?php

namespace Slashworks\ContaoTrackingManagerBundle\Cron;

use Contao\Date;
use Contao\Email;
use Contao\Environment;
use Contao\FrontendTemplate;
use Contao\Idna;
use Contao\StringUtil;
use Contao\System;
use Slashworks\ContaoTrackingManagerBundle\Model\UnknownCookie;
use Symfony\Component\VarDumper\VarDumper;

/**
 * Class UnknownCookieNotification
 *
 * @package Slashworks\ContaoTrackingManagerBundle\Cron
 */
class UnknownCookieNotification
{

    public function run()
    {
        $unknownCookies = UnknownCookie::findAllUnsent();
        if ($unknownCookies === null) {
            return false;
        }

        $email = new Email();

        $recipients = array($GLOBALS['TL_ADMIN_EMAIL']);

        $email->subject = 'Unbekannte Cookies auf ' . Idna::decode(Environment::get('host'));

        // Set the admin e-mail as "from" address
        $email->from = $GLOBALS['TL_ADMIN_EMAIL'];
        $email->fromName = $GLOBALS['TL_ADMIN_NAME'];

        $tokens = array();
        $tokens['domain'] = Idna::decode(Environment::get('host'));
        $cookies = array();
        /** @var UnknownCookie $unknownCookie */
        foreach ($unknownCookies as $unknownCookie) {
            $cookies[] = 'Name: ' . $unknownCookie->name . ' | Last Access: ' . Date::parse($GLOBALS['TL_CONFIG']['datimFormat'], $unknownCookie->tstamp);
        }
        $tokens['cookies'] = implode("\r\n", $cookies);

        $template = new FrontendTemplate('mail_unknown_cookies');
        $message = StringUtil::parseSimpleTokens($template->parse(), $tokens);

        $email->text = StringUtil::decodeEntities(trim($message));

        // Send the e-mail
        try {
            $email->sendTo($recipients);

            foreach ($unknownCookies as $unknownCookie) {
                $unknownCookie->notificationSent = true;
                $unknownCookie->save();
            }
        } catch (\Exception $e) {
            System::log('Email with unknown cookies could not be sent to ' . implode(',', $recipients) . '. Reason: ' . $e->getMessage(), __METHOD__, TL_ERROR);
        }
    }

}
