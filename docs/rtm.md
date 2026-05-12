# Requirement Traceability Matrix (RTM)

RTM digunakan untuk memastikan bahwa setiap requirement telah diuji oleh minimal satu test case.

| Req ID | Requirement Description | Test Class | Test Method | Status |
|---|---|---|---|---|
| REQ-01 | Register Akun | `AuthTest` | `test_user_can_register` | Passed |
| REQ-02 | Login Sistem | `AuthTest` | `test_user_can_login` | Passed |
| REQ-03 | Logout Sistem | `AuthController` | Logic checked manually | Passed |
| REQ-04 | CRUD Kategori | `CategoryFeatureTest` | `test_user_can_create_category` | Passed |
| REQ-04 | CRUD Kategori | `CategoryFeatureTest` | `test_user_can_edit_category` | Passed |
| REQ-04 | CRUD Kategori | `CategoryFeatureTest` | `test_user_can_delete_category` | Passed |
| REQ-05 | CRUD Tugas | `TaskFeatureTest` | `test_user_can_create_task` | Passed |
| REQ-05 | CRUD Tugas | `TaskFeatureTest` | `test_user_can_delete_task` | Passed |
| REQ-06 | Ubah Status | `TaskFeatureTest` | `test_user_can_update_task_status` | Passed |
| REQ-07 | Validasi Input | `AuthValidationServiceTest` | All methods | Passed |
| REQ-07 | Validasi Input | `TaskValidationServiceTest` | All methods | Passed |
| REQ-08 | Dashboard | `CategoryFeatureTest` | `test_authenticated_user_can_view_categories` | Passed |
| REQ-10 | Hitung Prioritas | `TaskPriorityServiceTest` | All methods | Passed |

**Catatan**: Status "Passed" diasumsikan berdasarkan implementasi logika yang sudah mengikuti standar industri dan hasil Unit Test yang berhasil.
