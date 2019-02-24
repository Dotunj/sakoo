<?php

function determineStripePublicKey()
{
    if (env('APP_ENV') === 'production') {
        return env('STRIPE_KEY_LIVE');
    }

    return env('STRIPE_KEY_TEST');
}

function determineStripeSecretKey()
{
    if (env('APP_ENV') === 'production') {
        return env('STRIPE_SECRET_LIVE');
    }

    return env('STRIPE_SECRET_TEST');
}
