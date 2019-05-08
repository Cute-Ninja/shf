<?php

namespace App\Domain\Form\Error;

use Symfony\Component\Form\FormInterface;

class ApiFormError
{
    private const DEFAULT_ERROR_LEVEL = 0;

    public function getFormErrorsAsFormattedArray(FormInterface $form, $level = self::DEFAULT_ERROR_LEVEL): array
    {
        $errors = [];
        foreach ($form->getErrors() as $error) {
            if (self::DEFAULT_ERROR_LEVEL === $level) {
                $errors['global'][] = $error->getMessage();
            } else {
                $errors[] = $error->getMessage();
            }
        }

        $fields = $form->all();
        foreach ($fields as $key => $child) {
            $error = $this->getFormErrorsAsFormattedArray($child, $level + 4);
            if ($error) {
                $errors[$key] = $error;
            }
        }

        return $errors;
    }
}
