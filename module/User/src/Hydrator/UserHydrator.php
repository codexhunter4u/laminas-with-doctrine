<?php

declare(strict_types=1);

namespace User\Hydrator;

use Laminas\Hydrator\ClassMethodsHydrator;

class UserHydrator extends ClassMethodsHydrator
{
    /**
     * @param array $data
     * @param object $object
     * @return object|void
     */
    public function hydrate(array $data, object $object)
    {
        $data['profilePhoto'] = $this->getFiles($data['profilePhoto'], $data['uploadedFile']);
        $data['status'] = 3;  // Default user status is Active
        
        return parent::hydrate($data, $object);
    }

    /**
     * @param object $object
     * @return array
     */
    public function extract(object $object) : array
    {
        return [
            'id' => $object->getId(),
            'firstName' => $object->getFirstName(),
            'lastName' => $object->getLastName(),
            'email' => $object->getEmail(),
            'contact' => $object->getContact(),
            'gender' => $object->getGender(),
            'profilephoto' => $object->getProfilePhoto(),
        ];
    }

    /**
     * @param array $file
     * @param string|null $file
     * @return string
     */
    private function getFiles(array $file, ?string $oldFile = null): string
    {
        $temp = explode('/', $file['tmp_name']);

        return $file['size'] === 0 ? $oldFile : $temp[2];
    }
}
