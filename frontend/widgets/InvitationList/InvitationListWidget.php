<?php
/**
 * Created by PhpStorm.
 * User: KustovVA
 * Date: 26.06.2015
 * Time: 14:01
 */

namespace frontend\widgets\InvitationList;


use common\models\Invitation;
use frontend\widgets\BaseGridView;

class InvitationListWidget extends BaseGridView
{
    public $layout = "{items}\n{pager}";
    public $pager = [
        'class' => 'frontend\widgets\InvitationList\InvitationLinkPager'
    ];

    public function init()
    {
        $this->columns = [
            [
                'label' => \Yii::t('app', 'Company/Owner Name'),
                'format' => 'html',
                'value' => function (Invitation $invitation) {
                    return $this->render('blocks/name', [
                        'invitation' => $invitation
                    ]);
                },
//                'headerOptions' => ['style'=>'font-weight: 600'],
            ],
            [
                'label' => \Yii::t('app', 'Email'),
                'value' => function (Invitation $invitation) {
                    return $invitation->email;
                },
//                'headerOptions' => ['style'=>'font-weight: 600']
            ],
            [
                'label' => \Yii::t('app', 'Status'),
                'format' => 'html',
                'value' => function (Invitation $invitation) {
                    return $this->render('blocks/status', [
                        'status' => $invitation->status
                    ]);
                },
//                'headerOptions' => ['style'=>'font-weight: 600']
            ],
            [
                'label' => false,
                'format' => 'html',
                'value' => function (Invitation $invitation) {
                    return $this->render('blocks/actions', [
                        'invitation' => $invitation
                    ]);
                },
//                'headerOptions' => ['style'=>'font-weight: 600']
            ],
        ];
        parent::init();
    }
}