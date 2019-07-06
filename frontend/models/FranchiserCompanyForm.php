<?php

namespace frontend\models;

use yii\web\UploadedFile;
use common\models\Company;
use common\models\Franchiser;
use common\models\Image;


class FranchiserCompanyForm extends CompanyForm
{

    public $contactPerson;
    public $website;
    public $ABN;
    public $imageFile;
    public $image;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge([
            [['contactPerson', 'website', 'ABN'], 'string'],
            [['imageFile'], 'file', 'extensions' => 'jpg, jpeg, png, gif'],
            [['image'], 'safe'],
        ], parent::rules());
    }

    /**
     * Set data from franchiser company
     *
     * @param Franchiser $franchiser
     */
    public function setData( Franchiser $franchiser )
    {
        $company = $franchiser->company;
        if ( !$company ) {
            $company = new Company();
            $company->save();
            $franchiser->companyId = $company->id;
            $franchiser->save();
        }
        $this->setAttributes($company->getAttributes());
        $this->image = $company->image;
    }

    public function save()
    {
        $company = Company::findOne($this->id);
        $company->setAttributes($this->getAttributes());

        $image = new Image();
        $image->save();
        $image->imageFile = UploadedFile::getInstance($this, 'imageFile');
        if ( $image->imageFile ) {
            $image->saveFiles();
            $image->save();
            $company->imageId = $image->id;
        }

        $company->save();
        $this->image = $company->image;
    }

}
