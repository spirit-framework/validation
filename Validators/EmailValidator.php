<?php
/**
 * MIT License
 *
 * Copyright (c) 2022 Spirit Framework
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace Spirit\Validation\Validators;

use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\EmailValidation;
use Egulias\EmailValidator\Validation\MultipleValidationWithAnd;
use Spirit\Validation\Errors;

class EmailValidator implements Validator
{
    use Errors;

    /** @var string $msg The error message to return if the email is not valid. */
    private string $msg = "The current email provided is invalid.";

    /**
     * @param array<\Egulias\EmailValidator\Validation\EmailValidation> $emailValidations A list of email validations to preform.
     *
     * {@inheritDoc}
     */
    public function validate(mixed $object, array $emailValidations = []): bool
    {
        if (!is_string($object)) {
            return false;
        }
        $validator = new EmailValidator();
        if (count($emailValidations) !== 1) {
            $multipleValidations = new MultipleValidationWithAnd($emailValidations);
            return $validator->isValid($object, $multipleValidations);
        }
        return $validator->isValid($object, $emailValidations[0]);
    }

    /**
     * {@inheritDoc}
     */
    public function parseErrorMsg(): void
    {
        //
    }
}
