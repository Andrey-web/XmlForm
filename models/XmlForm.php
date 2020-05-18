<?php

namespace app\models;

use Exception;
use SimpleXMLElement;
use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class XmlForm extends Model
{
    public $file;
    public $dirname = 'uploads/xml';

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['file', 'file', 'mimeTypes' => ['application/xml', 'text/xml']],
        ];
    }

    public function renameFile($name)
    {
        $timestamp = time();
        $oldName = explode('.', $name);
        return $oldName[0].$timestamp.'.xml';
    }

    public function saveFile($name)
    {
        if (file_exists($this->dirname. '/' . $name)) {
            $newName = $this->renameFile($name);
            $fileName = $this->dirname. '/' . $newName;
            $this->file->saveAs($fileName);
            return $fileName;
        } else {
            $fileName = $this->dirname. '/' . $name;
            $this->file->saveAs($fileName);
            return $fileName;
        }
    }

    public function upload()
    {
        if ($this->validate()) {

            $filename = $this->saveFile($this->file->name);

            try {

                $xml = simplexml_load_file($filename);

                $components = [];
                foreach ($xml->ResultList->Result as $one) {
                    foreach ($one->ComponentList->Component as $component) {

                        if ($component["Id"] != "030-032-000-000") continue;
                        if ($component->Value != "") continue;
                        if ($component->Limit != "") continue;
                        if ($component->Error != "ERROR") continue;

                        if (isset($component->Value) && isset($component->Limit) && isset($component->Error)) {
                            $components[] = $component;
                        }
                    }
                }
                if (!empty($components)) {
                    return $components;
                } else {
                    $this->deleteFile($this->file->name);
                    return false;
                }

            } catch (Exception $e) {
                Yii::$app->session->setFlash('StructureError');
                $this->deleteFile($this->file->name);
                return false;
            }

        } else {
            return false;
        }
    }

    public function deleteFile($name)
    {
        $a = $this->dirname. '/' . $name;
        if (file_exists($a)) {
            return unlink($a);
        }
    }

}
