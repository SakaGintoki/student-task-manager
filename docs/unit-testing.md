# Unit Testing

Unit testing dilakukan untuk menguji komponen terkecil dari perangkat lunak (fungsi atau class) secara terisolasi.

## Framework & Tool
- **PHPUnit**: Framework testing standar untuk PHP.
- **Mockery**: (Opsional) Untuk melakukan mocking object.

## Daftar Unit Test
Aplikasi ini memiliki 3 service utama yang diuji unit:

1.  **AuthValidationServiceTest**:
    - `test_validate_login_success`
    - `test_validate_login_empty_email`
    - `test_validate_login_invalid_email_format`
    - `test_validate_login_empty_password`
    - `test_validate_login_short_password`

2.  **TaskValidationServiceTest**:
    - `test_validate_task_success`
    - `test_validate_task_empty_title`
    - `test_validate_task_empty_deadline`
    - `test_validate_task_invalid_deadline`
    - `test_validate_task_invalid_category`

3.  **TaskPriorityServiceTest**:
    - `test_priority_empty_deadline`
    - `test_priority_overdue`
    - `test_priority_high`
    - `test_priority_medium`
    - `test_priority_low`

## Cara Menjalankan
Jalankan perintah berikut di terminal:
```bash
php artisan test --testsuite=Unit
```

## Hasil Pengujian (Contoh)
```text
PASS  Tests\Unit\AuthValidationServiceTest
✓ validate login success
✓ validate login empty email
✓ validate login invalid email format
✓ validate login empty password
✓ validate login short password

PASS  Tests\Unit\TaskPriorityServiceTest
✓ priority empty deadline
✓ priority overdue
✓ priority high
✓ priority medium
✓ priority low

...
Tests:  15 passed (25 assertions)
Time:   0.15s
```
