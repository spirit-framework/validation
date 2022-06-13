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

use Spirit\Validation\Chain;
use Spirit\Validation\Errors;

class ChainValidator implements Validator, Chain
{
    use Errors;

    /** @var string $msg The error message to return if the object is invalid. */
    private string $msg = ""; // Set to nothing since this validator is based off other validators.

    /** @var array $validators A list of validators to chain together. */
    private array $validators = [];

    /** @var \Spirit\Validation\Validators\Validator|null $errorValidator The validator causing the error. */
    private Validator|null $errorValidator = null;

    /**
     * {@inheritDoc}
     */
    public function validate(mixed $object): bool
    {
        foreach ($this->validators as $validator) {
            if (!$validator->validate($object)) {
                $this->errorValidator = $validator;
                return false;
            }
        }
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function parseErrorMsg(): void
    {
        if (!is_null($this->errorValidator)) {
            $this->errorValidator->parseErrorMsg();
        }
    }

    /**
     * {@inheritDoc}
     */
    public function add(Validator|array $validators): void
    {
        if (is_array($validators)) {
            foreach ($validators as $validator) {
                if ($validator instanceof Validator) {
                    $this->validators[] = $validator;
                }
            }
        } else {
            $this->validators[] = $validators;
        }
    }
}
