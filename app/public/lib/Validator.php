<?php

class Validator
{
    private $errors = [];

    public function validateEmail($email)
    {
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = "Invalid email format.";
        }
        return filter_var($this, FILTER_SANITIZE_EMAIL);
    }

    public function validateUsername($username, $minLength = 3)
    {
        if (empty($username) || strlen($username) < $minLength) {
            $this->errors['username'] = "Username must be at least $minLength characters long.";
        }
        return filter_var($this, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    public function validatePassword($password, $minLength = 6)
    {
        if (empty($password)) {
            $this->errors['password'] = "Password cannot be empty.";
        } elseif (strlen($password) < $minLength) {
            $this->errors['password'] = "Password must be at least $minLength characters long.";
        }
        return filter_var($this, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    public function validatePhoneNumber($phoneNumber)
    {
        if (!empty($phoneNumber) && !preg_match('/^[0-9]+$/', $phoneNumber)) {
            $this->errors['phone_number'] = "Phone number must contain only digits.";
        }
        return filter_var($this, FILTER_SANITIZE_NUMBER_INT);
    }

    public function validateRequired($field, $value, $label)
    {
        if (empty($value)) {
            $this->errors[$field] = "$label is required.";
        }
        return $this;
    }

    public function validateMaxLength($field, $value, $maxLength, $label)
    {
        if (!empty($value) && strlen($value) > $maxLength) {
            $this->errors[$field] = "$label must not exceed $maxLength characters.";
        }
        return $this;
    }

    public function validateUrl($field, $url, $label = "URL")
    {
        if (!empty($url) && !filter_var($url, FILTER_VALIDATE_URL)) {
            $this->errors[$field] = "$label must be a valid URL.";
        }
        return filter_var($this, FILTER_SANITIZE_URL);
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function hasErrors()
    {
        return !empty($this->errors);
    }
}