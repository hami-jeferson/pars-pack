# Subscription Sync Service



## Description

Subscription Sync Service is a sample Laravel project created by Pars Pack Company. It serves as a subscription status synchronization service that checks users' subscriptions of apps on app markets and updates subscription status based on the results.

## Table of Contents

- [Installation](#installation)
- [Usage](#usage)
- [Expired Subscriptions Endpoint](#expired-subscriptions-endpoint)
- [Contributing](#contributing)
- [License](#license)

## Installation

1. Clone the repository:

git clone https://github.com/your-username/subscription-sync-service.git


2. Navigate to the project directory:

cd subscription-sync-service


3. Install the dependencies:

composer install


4. Configure the database information in the `.env` file.

5. Run database migrations and seeders to create sample data:

php artisan migrate --seed


## Usage

To trigger the subscription status synchronization, run the following command:

php artisan app:sync-subscriptions


By default, this command is scheduled to run every weekend. You can find the scheduling configuration in the `app/Console/Kernel.php` file:

```php
$schedule->command('app:sync-subscriptions')->weeklyOn(6, '0:00');

Expired Subscriptions Endpoint
The project provides an endpoint to retrieve expired subscriptions:

GET /api/expired-subscriptions

Responses
1. When the synchronization service has not run yet:

{
    "success": false,
    "message": "There is no data (synchronization service not run yet.)"
}

2.When the synchronization service has run and there is data:
{
    "success": true,
    "data": {
        "sync_date": "2023-07-31",
        "total_expired_count": 120,
        "details": [
            {
                "app_name": "example",
                "expired_count": 0
            },
            .
			.
			.
        ]
    }
}

Contributing
Contributions to the Subscription Sync Service project are welcome. If you encounter any issues, have feature requests, or want to contribute to the project's development, please follow the guidelines outlined in CONTRIBUTING.md.

License
The Subscription Sync Service project is open-source and licensed under the MIT License.



