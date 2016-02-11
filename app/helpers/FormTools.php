<?php
namespace UploadHelpers;
use Nette\Forms\Controls\UploadControl;

class FormTools extends \Nette\Object
{

        static function fileUploaded(UploadControl $control)
        {
                $file = $control->value;
                return ($file instanceof HttpUploadedFile && $file->error !== UPLOAD_ERR_NO_FILE);
        }



        static function uploadTest(UploadControl $control, $maxFileSize) //IFormControl //UploadControl
        {
                $file = $control->value;

                if (!$file instanceof HttpUploadedFile) {
                        $control->addError('Přílohu se nepodařilo nahrát.');
                        return FALSE;

                } elseif ($file->isOk()) {
                        return TRUE;

                } else {
                        switch ($file->error) {
                                case UPLOAD_ERR_INI_SIZE:
                                        $control->addError('Velikost přílohy může být MAXIMÁLNĚ ' . FormTools::bytes($maxFileSize) . '.');
                                        break;

                                case UPLOAD_ERR_NO_FILE:
                                        $control->addError('Nevybrali jste žádný soubor.');
                                        break;

                                default:
                                        $control->addError('Přílohu se nepodařilo nahrát.');
                                        break;
                        }

                        return FALSE;
                }

        }


        static public function bytes($val)
        {
                $val = trim($val);
                $last = strtolower($val[strlen($val)-1]);
                switch($last) {
                        // The 'G' modifier is available since PHP 5.1.0
                        case 'g':
                                $val *= 1024;
                        case 'm':
                                $val *= 1024;
                        case 'k':
                                $val *= 1024;
                }

                return $val;
        }

}