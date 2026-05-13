<?php

it('should welcome the user', function () {
    visit('/')
        ->assertSee('Hello, Guest!')
        ->assertGuest();
});

it('should refuse login when user is not created', function () {
    visit('/login')
        ->fill('email', 'manager@garage.com')
        ->fill('password', 'P@ssword')
        ->click('#login-btn')
        ->assertSee('We were unable to authenticate using the provided credentials. Please verify your login details and try again.');
});
