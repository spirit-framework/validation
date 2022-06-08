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

use Spirit\Validation\Errors;

class IsNullValidator implements Validator
{
    use Errors;

    /** @var string $msg The error message to return if the object is not null. */
    private string $msg = "The current object has a `{type}` data type.";

    /** @var mixed $object The object passed. */
    private mixed $object = null;

    /**
     * {@inheritDoc}
     */
    public function validate(mixed $object): bool
    {
        $this->object = $object;
        return is_null($object);
    }

    /**
     * {@inheritDoc}
     */
    public function parseErrorMsg(): void
    {
        $this->msg = str_replace('{type}', $this->msg, gettype($this->object));
    }
}
