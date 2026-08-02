| Column              | Type               | Description                                                                |
| ------------------- | ------------------ | -------------------------------------------------------------------------- |
| id                  | bigint             | Primary key                                                                |
| booking_number      | string             | Human-readable reference (e.g. BK-20260802-0012)                           |
| customer_id         | foreignId          | Customer                                                                   |
| vehicle_id          | foreignId          | Vehicle being serviced                                                     |
| branch_id           | foreignId          | Garage/workshop location                                                   |
| advisor_id          | foreignId nullable | Service advisor handling booking                                           |
| technician_id       | foreignId nullable | Assigned technician (optional)                                             |
| status              | enum               | pending, confirmed, checked_in, in_progress, completed, cancelled, no_show |
| appointment_start   | datetime           | Scheduled start                                                            |
| appointment_end     | datetime           | Scheduled finish                                                           |
| estimated_duration  | integer            | Minutes                                                                    |
| service_type        | enum/string        | MOT, Service, Repair, Diagnostics, Tyres, etc.                             |
| complaint           | text               | Customer's reported issue                                                  |
| notes               | text               | Internal notes                                                             |
| customer_notes      | text               | Notes from customer                                                        |
| estimated_cost      | decimal(10,2)      | Initial estimate                                                           |
| priority            | enum               | low, normal, high, emergency                                               |
| reminder_sent_at    | datetime nullable  | Reminder timestamp                                                         |
| checked_in_at       | datetime nullable  | Vehicle arrived                                                            |
| completed_at        | datetime nullable  | Work completed                                                             |
| cancelled_at        | datetime nullable  | Cancellation timestamp                                                     |
| cancellation_reason | text nullable      | Reason                                                                     |
| work_order_id       | foreignId nullable | Links to repair/work order                                                 |
| created_by          | foreignId          | Employee that created booking                                              |
| created_at          | timestamp          | Laravel timestamp                                                          |
| updated_at          | timestamp          | Laravel timestamp                                                          |
| deleted_at          | softDeletes        | Soft delete                                                                |
