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
use Egulias\EmailValidator\Validation\DNSCheckValidation;
use Egulias\EmailValidator\Validation\MultipleValidationWithAnd;
use Egulias\EmailValidator\Validation\RFCValidation;
use Spirit\Validation\Errors;

class MaxValidator implements Validator
{
    use Errors;

    /** @var string $msg The error message to return if the object is not null. */
    private string $msg = "The current object is not a valid email.";

    /**
     * @param bool $bool Should we do a dns lookup.
     *
     * {@inheritDoc}
     */
    public function validate(mixed $object, bool $dnsCheck = false): bool
    {
        if (!is_string($object)) {
            return true;
        }
        $validator = new EmailValidator();
        if ($dnsCheck) {
            $multipleValidations = new MultipleValidationWithAnd([
                new RFCValidation(),
                new DNSCheckValidation()
            ]);
            return $validator->isValid($object, $multipleValidations);
        }
        return $validator->isValid($object, new RFCValidation());
    }

    /**
     * {@inheritDoc}
     */
    public function parseErrorMsg(): void
    {
        //
    }
}
