# Laravel Activity Log

This is a library of activity log.

[日本語版](https://qiita.com/ikepu-tp/items/47228f97d056fe05fbd9)

## Features

- Logging activities of users.
- Show activities of users.

## How to use

1. First of all, migrate.
2. Add `\ikepu_tp\ActivityLog\app\Http\Middleware\ActivityLogMiddleware::class` to `Kernel.php`.
3. You can access `/activity-log` and see your acitivity logs. *edit `/route/activity-log.php` if you want to change routing.*

## Contributing

Thank you for your contributions. If you find bugs, let me know them with issues.

## License

Copyright (c) 2023 ikepu-tp.

This is open-sourced software licensed under the [MIT license](LICENSE).
