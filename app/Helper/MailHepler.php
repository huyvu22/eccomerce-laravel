<?php
namespace App\Helper;

use App\Models\EmailConfig;

class MailHepler
{
    public static function setMailConfig()
    {
		$emailConfig = EmailConfig::first();
        $config = [
            'transport' => 'smtp',
            'host' => $emailConfig->host,
            'port' => $emailConfig->port,
            'encryption' => $emailConfig->encryption,
            'username' => $emailConfig->username,
            'password' => $emailConfig->password,
            'timeout' => null,
            'local_domain' => env('MAIL_EHLO_DOMAIN'),
        ];

        config(['mail.mailers.smtp' => $config]);
        config(['mail.from.address' => $emailConfig->email]);
    }
}
