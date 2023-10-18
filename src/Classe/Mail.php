<?php
namespace App\Classe;

use Mailjet\Client;
use Mailjet\Resources;
class Mail{
    private $api_key = '72cb02a8742ef7949dee8c11933073fb';
    private $api_key_secret = 'f1a48f19b8336a20c8ba5dbf8780cdf4';

    public function send($to_email, $to_name, $subject, $content, $title){

        $mj = new Client($this->api_key, $this->api_key_secret, true,['version' => 'v3.1']);
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "amalesieux@gmail.com",
                        'Name' => "Gestionnaire d'association de Magland"
                    ],
                    'To' => [
                        [
                            'Email' => $to_email,
                            'Name' => $to_name
                        ]
                    ],
                    'TemplateID' => 5188035,
                    'TemplateLanguage' => true,
                    'Subject' => $subject,
                    'Variables' => [
                        'title' => $title,
                        'content' => $content
                    ]
                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success();
    }
}