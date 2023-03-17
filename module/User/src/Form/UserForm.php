<?php

declare(strict_types=1);

namespace User\Form;

use Laminas\Form\Form;
use Laminas\Filter\ToInt;
use Laminas\Form\Element;
use Laminas\Filter\StripTags;
use Laminas\Filter\StringTrim;
use Laminas\Form\Element\File;
use Laminas\InputFilter\FileInput;
use Laminas\Validator\GreaterThan;
use Laminas\Validator\StringLength;
use Laminas\InputFilter\InputFilter;

class UserForm extends Form
{
    public function __construct()
    {
        parent::__construct('user-form');

        $this->setAttribute('method', 'post');

        $this->addElements();
        $this->addInputFilter();
    }

    /**
     * @return void
     */
    protected function addElements(): void
    {
        $this->add([
            'name' => 'id',
            'type' => 'hidden',
        ]);

        $this->add([
            'type' => 'text',
            'name' => 'firstName',
            'attributes' => [
                'id' => 'firstName',
            ],
            'options' => [
                'label' => 'First name',
            ],
        ]);

        $this->add([
            'type' => 'text',
            'name' => 'lastName',
            'attributes' => [
                'id' => 'lastName',
            ],
            'options' => [
                'label' => 'Last name',
            ],
        ]);

        $this->add([
            'type' => 'email',
            'name' => 'email',
            'attributes' => [
                'id' => 'email',
            ],
            'options' => [
                'label' => 'Email',
            ],
        ]);

        $this->add([
            'type' => 'text',
            'name' => 'contact',
            'attributes' => [
                'id' => 'contact',
            ],
            'options' => [
                'label' => 'Contact No',
            ],
        ]);

        $this->add([
            'type'  => 'select',
            'name' => 'gender',
            'attributes' => [
                'id' => 'gender',
            ],
            'options' => [
                'label' => 'Gender',
                'empty_option' => 'Select Gender',
                'value_options' => [
                    1 => 'Male',
                    2 => 'Female',
                ]
            ],
        ]);

        $this->add([
            'type' => 'hidden',
            'name' => 'uploadedFile',
            'attributes' => [
                'id' => 'uploadedFile',
            ],
        ]);

        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Save',
                'id'    => 'submitbutton',
            ],
        ]);

        $file = $this->addFileElements();

        $this->add($file);
    }

    /**
     * @return File
     */
    private function addFileElements(): File
    {
        $file = new File('profilePhoto');
        $file->setLabel('Upload Profile Photo');
        $file->setAttribute('id', 'profilePhoto');
        $file->setAttribute('multiple', false);

        return $file;
    }

    /**
     * @return void
     */
    private function addInputFilter(): void
    {
        $inputFilter = new InputFilter();
        $this->setInputFilter($inputFilter);

        $inputFilter->add([
            'name' => 'id',
            'required' => true,
            'filters' => [
                ['name' => ToInt::class],
            ],
        ]);

        $inputFilter->add([
            'name' => 'firstName',
            'required' => true,
            'filters' => [
                ['name' => StringTrim::class],
                ['name' => StripTags::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 3,
                        'max' => 15,
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'lastName',
            'required' => true,
            'filters' => [
                ['name' => StringTrim::class],
                ['name' => StripTags::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 3,
                        'max' => 15,
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'contact',
            'required' => true,
            'filters' => [
                ['name' => ToInt::class],
            ],
        ]);

        $inputFilter->add([
            'name' => 'email',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'contact',
            'required' => true,
            'filters' => [
                ['name' => ToInt::class],
            ],
            'validators' => [
                [
                    'name'    => GreaterThan::class,
                    'options' => [
                        'min' => 0,
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'gender',
            'required' => true,
             'filters'  => [
                 ['name' => ToInt::class],
             ],
            'validators' => [
                [
                    'name' => 'InArray',
                    'options'=> [
                        'haystack' => [1, 2],
                    ],
                ],
            ],
        ]);
        
        $fileInput = $this->addFileInputFilter();

        $inputFilter->add($fileInput);
    }

    /**
     * @return FileInput
     */
    private function addFileInputFilter(): FileInput
    {
        $fileInput = new FileInput('profilePhoto');
        $fileInput->setRequired(false);
        $fileInput->getValidatorChain()
            ->attachByName('filesize',      ['max' => 204800])
            ->attachByName('filemimetype',  ['mimeType' => 'image/png, image/jpeg, image/jpg'])
            ->attachByName('fileimagesize', ['maxWidth' => 1000, 'maxHeight' => 800]);
        $fileInput->getFilterChain()->attachByName(
            'filerenameupload', [
                'target'    => 'public/img/user.png',
                'randomize' => true,
            ],
        );

        return $fileInput;
    }
}
