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

use Countable;
use Spirit\Validation\Errors;

class MinValidator implements Validator
{
    use Errors;
    use Length;

    /** @var string $msg The error message to return if the object is not null. */
    private string $msg = "The current object is too short. The current length of the object is `{length}`.";

    /** @var int|double $object The object's length. */
    private int|double $currLength = 0;

    /**
     * @param int|double $length The min length for the object.
     *
     * {@inheritDoc}
     */
    public function validate(mixed $object, int|double $length): bool
    {
        if (!is_int($object) || !is_string($object) || !is_array($object) || !is_double($object)) {
            if (!($object instanceof Countable)) {
                return true;
            }
        }
        $this->currLength = $this->getLength($object);
        return !($this->currLength < $length);
    }

    /**
     * {@inheritDoc}
     */
    public function parseErrorMsg(): void
    {
        $this->msg = str_replace('{length}', $this->msg, strval($this->currLength));
    }
}
