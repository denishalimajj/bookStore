<?php

return [
    'User already exists' => [
        'code' => 42201,
        'message' => 'User already exists',
        'description' => 'A user with this email has already been created. You cannot create duplicates.',
    ],
    'Username cannot be empty' => [
        'code' => 42202,
        'message' => 'Username cannot be empty',
        'description' => 'Username cannot be empty, please write a username.',
    ],
    'Username must be a string' => [
        'code' => 42203,
        'message' => 'Username must be a string',
        'description' => 'Username must be a string.',
    ],
    'Email is required' => [
        'code' => 42204,
        'message' => 'Email is required',
        'description' => 'Email is required.',
    ],
    'Invalid email format' => [
        'code' => 42205,
        'message' => 'Invalid email format',
        'description' => 'Invalid email format.',
    ],
    'The password field is required.' => [
        'code' => 42206,
        'message' => 'Password is required',
        'description' => 'The password field is required.',
    ],
    'The password must be at least 8 characters.' => [
        'code' => 42207,
        'message' => 'Password is short',
        'description' => 'The password field must be at least 8 characters.',
    ],
    'The password confirmation does not match.' => [
        'code' => 42208,
        'message' => 'Password not identical',
        'description' => 'The password field does not match.',
    ],
    'The title field is required.' => [
        'code' => 42209,
        'message' => 'Title is required',
        'description' => 'The title field cannot be empty.',
    ],
    'The title may not be greater than 255 characters.' => [
        'code' => 42210,
        'message' => 'Title too long',
        'description' => 'The title may not be greater than 255 characters.',
    ],
    'The title has already been taken.' => [
        'code' => 42211,
        'message' => 'Title must be unique',
        'description' => 'A book with this title already exists.',
    ],
    'The author field is required.' => [
        'code' => 42212,
        'message' => 'Author is required',
        'description' => 'The author field cannot be empty.',
    ],
    'The author may not be greater than 255 characters.' => [
        'code' => 42213,
        'message' => 'Author name too long',
        'description' => 'The author name may not be greater than 255 characters.',
    ],
    'The publication year must be an integer.' => [
        'code' => 42214,
        'message' => 'Invalid publication year',
        'description' => 'The publication year must be a valid integer.',
    ],
    'The publication year must be between 0 and the current year.' => [
        'code' => 42215,
        'message' => 'Invalid publication year',
        'description' => 'The publication year must be between 0 and the current year.',
    ],
    'Book not found' => [
        'code' => 40401,
        'message' => 'The specified book does not exist.',
        'description' => 'No query results for the specified book.',
    ],
    'Invalid credentials' => [
        'code' => 50000,
        'message' => 'Invalid credentials',
        'description' => 'The provided credentials are incorrect.',
    ],
    'Unauthorized' => [
        'code' => 40100,
        'message' => 'Unauthorized',
        'description' => 'You are unauthorized.',
    ],
];
