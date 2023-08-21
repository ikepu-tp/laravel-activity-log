# Documents

## Database

### Activity_logs

| id                    | activityId | user_id           | guard             | route_name       | path             | event            | activity         |
| --------------------- | ---------- | ----------------- | ----------------- | ---------------- | ---------------- | ---------------- | ---------------- |
| bigInt(autoIncrement) | uuid       | foreign(nullable) | foreign(nullable) | string(nullable) | string(nullable) | string(nullable) | string(nullable) |
