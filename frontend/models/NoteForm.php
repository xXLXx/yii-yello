<?php

namespace frontend\models;

use common\models\Note;
use yii\base\Model;
use common\models\Shift;

/**
 * Company form
 *
 * @author markov
 */
class NoteForm extends Model
{
    public $id;
    public $note;
    public $driverId;
    public $storeId;
    public $createdAt;
    public $updatedAt;
    public $isArchived;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [ ['note', 'driverId'], 'required']
        ];
    }

    public function save(){
        $note = new Note();
        $attrib = $this->getAttributes();

        $user = \Yii::$app->user->identity;
        $storeId = $user->storeOwner->storeCurrent->id;

        $note = $note->findOneOrCreate(['driverId' => $attrib['driverId'], 'storeId' => $storeId]);
        $note->setAttributes($attrib);



        //$note->driverId = $this->driverId;
        //$note->storeId = $storeId;
        //$note->note = $this->note;
        $note->save();
    }

    function getCurrentNote(){


        $user = \Yii::$app->user->identity;
        $storeId = $user->storeOwner->storeCurrent->id;
        $driverId = \Yii::$app->request->get('driverId');

        $note = Note::findOne(['driverId' => $driverId, 'storeId' => $storeId]);


        return $note['note'];
    }
}



