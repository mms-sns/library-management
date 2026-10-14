# Library Management SaaS — Master Development Prompt

## 1. Project Overview

Build a production-ready, multi-tenant **Library / Study Center Management SaaS for the Indian market**.

This is not primarily a traditional book-library management system.

The primary business model is for:

* Reading libraries
* Study rooms
* Competitive exam preparation libraries
* Self-study centers
* Private reading rooms
* Coaching study centers

The core business functions are:

1. Library and branch management
2. Student/member management
3. Membership management
4. Seat/space management
5. Seat allocation
6. Student ID card generation
7. QR-code based attendance
8. Fee and invoice management
9. Payment tracking
10. Student portal
11. Staff management
12. Reports
13. Notifications
14. Audit/activity logs
15. Multi-tenant SaaS management

Do not focus on book inventory, ISBN, book issue/return, or traditional library cataloguing in the MVP.

Those can be added in a future phase.

---

# 2. Development Philosophy

Build this as a real SaaS product, not as a quick CRUD application.

The system must be:

* Secure
* Scalable
* Multi-tenant
* Mobile responsive
* Maintainable
* Modular
* API-ready
* Production-ready
* Easy to extend

Do not take shortcuts that would require major architectural changes later.

Before implementing a feature, consider:

* Database relationships
* Tenant isolation
* Authorization
* Validation
* Audit logging
* Error handling
* Scalability
* Mobile usability
* Future API/mobile-app requirements

Do not implement future advanced features unless explicitly requested.

---

# 3. Recommended Technology Stack

Use:

### Backend

* PHP 8.3+
* Laravel 12+
* MySQL 8+
* Laravel Eloquent ORM
* Laravel migrations
* Laravel Form Requests
* Laravel Policies/Gates
* Laravel Jobs/Queues where appropriate
* Laravel Notifications where appropriate

### Frontend

Prefer:

* Laravel Blade
* Tailwind CSS
* Alpine.js where lightweight interactivity is sufficient

Do not introduce React/Vue unless there is a clear requirement.

The first version should be a responsive web application/PWA-ready application.

### Authentication

Use Laravel authentication with:

* Email/password
* Mobile number support
* Password reset
* Email verification where appropriate
* Session management

Keep the authentication architecture compatible with a future mobile app/API.

### Database

MySQL.

Use foreign keys wherever appropriate.

Use indexes for:

* tenant IDs
* foreign keys
* student numbers
* invoice numbers
* payment references
* QR tokens
* attendance dates
* membership status
* seat numbers

---

# 4. Multi-Tenant Architecture

This is a critical requirement.

The application must support multiple libraries using the same SaaS installation.

Example:

Library A:

```
Library A
    Branch 1
    Branch 2
    Students
    Seats
    Payments
```

Library B:

```
Library B
    Branch 1
    Students
    Seats
    Payments
```

Library A must NEVER be able to access Library B's data.

Most business tables should contain:

```
library_id
```

Branch-level records should also contain:

```
branch_id
```

Do not rely only on frontend filtering for tenant isolation.

Tenant isolation must be enforced at the backend/database-query/authorization level.

Every controller, service, query, report, and API endpoint must respect tenant boundaries.

Never trust a library_id supplied by the browser.

Determine the current tenant from the authenticated user/context.

---

# 5. User Roles

Initially support:

## Super Admin

Platform owner.

Can:

* Manage all libraries
* Manage SaaS subscriptions
* Manage SaaS plans
* View system-wide statistics
* Manage system settings
* View system activity logs
* Support customers

## Library Owner

Can:

* Manage library
* Manage branches
* Manage floors
* Manage rooms
* Manage seats
* Manage students
* Manage memberships
* Manage fees
* Manage payments
* Manage attendance
* Generate ID cards
* Manage staff
* View reports
* Manage library settings

## Branch Manager

Can manage assigned branches.

## Staff

Limited permissions based on assigned permissions.

## Student

Can access only their own:

* Profile
* Membership
* Seat
* Attendance
* Fees
* Receipts
* Digital ID
* Notifications

Do not hardcode permissions entirely around roles.

Implement RBAC with roles and permissions.

---

# 6. Permission System

Create:

```
roles
permissions
role_user
permission_role
```

Example permissions:

```
dashboard.view

students.view
students.create
students.edit
students.delete

admissions.view
admissions.create

memberships.view
memberships.create
memberships.renew
memberships.cancel

seats.view
seats.create
seats.edit
seats.allocate
seats.release

attendance.view
attendance.scan
attendance.edit

invoices.view
invoices.create
invoices.edit

payments.view
payments.create
payments.refund

id_cards.view
id_cards.generate
id_cards.print

reports.view

staff.view
staff.create
staff.edit

settings.view
settings.edit

activity_logs.view
```

Make authorization enforce these permissions server-side.

---

# 7. Database Design

Create the following core tables.

## users

Fields:

```
id
name
email
mobile
password
status
email_verified_at
last_login_at
remember_token
created_at
updated_at
```

---

## libraries

Fields:

```
id
name
slug
logo
email
mobile
address
city
state
pincode
status
created_at
updated_at
```

---

## library_settings

Store configurable settings such as:

* timezone
* currency
* date format
* time format
* library opening time
* library closing time
* attendance settings
* grace period
* ID card settings
* notification settings

Default timezone:

```
Asia/Kolkata
```

Default currency:

```
INR
```

---

## branches

Fields:

```
id
library_id
name
code
address
city
state
pincode
phone
status
created_at
updated_at
```

---

## floors

Fields:

```
id
branch_id
name
floor_number
sort_order
status
created_at
updated_at
```

---

## rooms

Fields:

```
id
branch_id
floor_id nullable
name
code
capacity
status
created_at
updated_at
```

---

## seat_types

Fields:

```
id
library_id
name
description
monthly_price
status
created_at
updated_at
```

Examples:

```
Normal
Premium
AC
Cabin
Window
```

---

## seats

Fields:

```
id
branch_id
floor_id nullable
room_id nullable
seat_type_id
seat_number
status
position_x nullable
position_y nullable
metadata nullable
created_at
updated_at
```

Statuses:

```
available
occupied
reserved
maintenance
inactive
```

Support both simple and advanced layouts.

Simple:

```
Branch
    Seats
```

Advanced:

```
Branch
    Floor
        Room
            Seats
```

---

# 8. Students

## students

Fields:

```
id
library_id
user_id nullable
student_number
first_name
last_name
photo
gender
date_of_birth
mobile
email
address
city
state
pincode
status
joined_at
created_at
updated_at
```

Student numbers should be human-readable:

```
LIB-000001
LIB-000002
```

The system must generate these safely and uniquely per library.

---

## student_guardians

Fields:

```
id
student_id
name
relationship
mobile
alternate_mobile
email
address
created_at
updated_at
```

---

# 9. Membership Plans

## membership_plans

Fields:

```
id
library_id
name
duration_days
price
description
status
created_at
updated_at
```

Examples:

```
Monthly
Quarterly
Half Yearly
Yearly
```

Do not hardcode pricing.

---

# 10. Memberships

## memberships

Fields:

```
id
library_id
student_id
branch_id
membership_plan_id
start_date
end_date
price
discount
final_amount
status
notes
created_at
updated_at
```

Statuses:

```
pending
active
expired
cancelled
suspended
```

Maintain membership history.

Never overwrite old membership records during renewal.

Create a new membership or renewal record according to the chosen architecture.

---

# 11. Seat Allocation

## seat_allocations

Fields:

```
id
library_id
branch_id
student_id
membership_id
seat_id
start_date
end_date nullable
status
assigned_by
released_by nullable
release_reason nullable
created_at
updated_at
```

Business rule:

A student can have only one active seat allocation for a membership/branch.

A seat cannot have two active allocations at the same time.

Use database constraints/transactions and server-side validation to prevent double allocation.

Maintain complete history.

Example:

```
Rahul
A-15
01 Sep → 15 Sep

Rahul
A-27
15 Sep → current
```

Do not delete historical allocations.

---

# 12. ID Cards

## id_cards

Fields:

```
id
library_id
student_id
card_number
issued_at
expires_at
status
printed_at
created_at
updated_at
```

Support:

* Generate
* Re-generate
* Print
* Download PDF
* Disable
* Reissue

---

# 13. QR Tokens

## qr_tokens

Fields:

```
id
student_id
id_card_id
token
expires_at
last_scanned_at
status
created_at
updated_at
```

Never put sensitive student information inside the QR code.

Use a secure random token.

QR token must be revocable.

If an ID card is lost:

```
Old QR → disabled
New ID → new QR
```

Do not expose database IDs directly if avoidable.

---

# 14. Attendance

Use session + scan architecture.

## attendance_sessions

Fields:

```
id
library_id
branch_id
student_id
seat_id
attendance_date
check_in_at
check_out_at
duration_minutes
status
created_at
updated_at
```

Statuses may include:

```
open
completed
manually_closed
incomplete
```

---

## attendance_scans

Fields:

```
id
library_id
branch_id
student_id
qr_token_id
attendance_session_id nullable
scan_type
scanned_at
device_info nullable
ip_address nullable
created_at
```

scan_type:

```
entry
exit
```

Every scan should be logged.

---

# 15. Attendance Business Rules

Default behavior:

### Entry

Student scans QR.

System:

1. Validates QR
2. Finds student
3. Checks membership
4. Checks membership expiry
5. Checks student status
6. Checks branch
7. Finds active seat
8. Creates attendance session
9. Records entry scan

### Exit

Student scans QR.

System:

1. Finds open attendance session
2. Records exit
3. Calculates duration
4. Closes session

If there is no open session:

Do not silently create an incorrect exit record.

Return a clear message.

---

# 16. Duplicate Scan Protection

If student scans twice within a configurable short period:

Do not create duplicate attendance.

Example:

```
Scan 07:42
Scan 07:42:05
```

The second scan should be ignored or return:

```
"Attendance already recorded."
```

Make this configurable.

---

# 17. Forgotten Checkout

If student forgets to scan out:

Admin/staff can manually correct attendance.

Any manual modification must create an activity log.

Example:

```
Staff: Amit
Student: Rahul
Changed checkout:
13:00 → 13:18
Reason: Student forgot checkout
```

---

# 18. Fees

Use invoice-based architecture.

## invoices

Fields:

```
id
library_id
branch_id
student_id
membership_id nullable
invoice_number
invoice_date
due_date
subtotal
discount
tax
total
paid_amount
balance_amount
status
notes
created_at
updated_at
```

Statuses:

```
draft
issued
partially_paid
paid
overdue
cancelled
refunded
```

---

## invoice_items

Fields:

```
id
invoice_id
description
quantity
unit_price
amount
created_at
updated_at
```

Example:

```
Monthly Membership       ₹1500
Premium Seat              ₹300
Discount                 -₹100
------------------------------
Total                    ₹1700
```

---

# 19. Payments

## payments

Fields:

```
id
library_id
branch_id
student_id
invoice_id
payment_number
amount
payment_method
transaction_reference
payment_date
status
notes
received_by
created_at
updated_at
```

Payment methods:

```
cash
upi
bank_transfer
card
gateway
other
```

Support partial payments.

Example:

```
Invoice = ₹1500

Payment 1 = ₹1000
Payment 2 = ₹500

Balance = ₹0
```

---

# 20. Payment Rules

Never delete a payment transaction.

If a payment needs correction, use reversal/refund/adjustment logic and retain history.

All financial changes must be auditable.

---

# 21. Student Portal

Student navigation:

```
Home
Attendance
Fees
Digital ID
Profile
Notifications
```

Student must never be able to access another student's data.

---

# 22. Library Admin Navigation

Main sidebar:

```
Dashboard

Students
    All Students
    Add Student
    Active
    Expired
    Expiring Soon

Admissions
    New Admission
    Renewals
    Pending Admissions

Seats
    Seat Map
    All Seats
    Available
    Occupied
    Seat Types

Attendance
    Today's Attendance
    Attendance History
    QR Scanner
    Reports

Fees
    Fee Dashboard
    Invoices
    Payments
    Pending Fees
    Fee Plans

ID Cards
    All Cards
    Generate Cards
    Print Cards

Reports
    Student Reports
    Attendance Reports
    Fee Reports
    Seat Reports

Staff

Library
    Profile
    Branches
    Floors
    Rooms
    Settings

Activity Logs
```

---

# 23. Admission Wizard

Create a guided admission workflow.

## Step 1

Student information.

## Step 2

Select membership plan.

## Step 3

Select branch.

## Step 4

Select available seat.

## Step 5

Generate invoice.

## Step 6

Record payment.

## Step 7

Generate ID card.

## Step 8

Complete admission.

Final screen:

```
Admission Successful

Student:
Rahul Sharma

ID:
LIB-00125

Seat:
A-15

Membership:
01 Oct 2026 → 31 Oct 2026
```

Actions:

```
Print ID Card
Print Receipt
View Student
```

Use database transactions so that failed admissions do not leave corrupted partial data.

---

# 24. Seat Map

Create a visual seat map.

Statuses:

```
Available
Occupied
Reserved
Maintenance
Inactive
```

Example:

```
A01 A02 A03 A04 A05
A06 A07 A08 A09 A10
A11 A12 A13 A14 A15
```

Admin can:

* View seat
* Assign
* Release
* Change seat
* Mark maintenance
* Mark inactive

Later support drag-and-drop layout.

For MVP, simple grid layout is enough.

---

# 25. Dashboard

Library dashboard should show:

```
Total Students
Active Students
Expired Students
Expiring Soon

Total Seats
Occupied Seats
Available Seats

Today's Attendance
Currently Inside

Today's Collection
Monthly Collection
Pending Fees
Overdue Fees
```

Also show:

* Recent payments
* Expiring memberships
* Recent admissions
* Recent activity

Keep the dashboard fast.

Avoid expensive queries on every request.

Use optimized queries/caching where appropriate.

---

# 26. Reports

Implement:

## Student Reports

* Total students
* Active students
* Expired students
* New admissions
* Renewals

## Attendance Reports

* Daily
* Weekly
* Monthly
* Student-wise
* Branch-wise
* Average duration
* Currently inside

## Fee Reports

* Daily collection
* Monthly collection
* Pending fees
* Overdue invoices
* Payment methods
* Revenue by membership plan

## Seat Reports

* Total seats
* Occupied
* Available
* Maintenance
* Occupancy percentage

Reports should support:

* Date filters
* Branch filters
* Search
* Export CSV
* Print-friendly format

PDF can be added where appropriate.

---

# 27. Activity Logs

Create an audit system.

Log important actions:

* Student created
* Student edited
* Student deleted/deactivated
* Membership created
* Membership cancelled
* Seat assigned
* Seat released
* Attendance manually edited
* Invoice created
* Payment created
* Payment reversed
* ID card issued
* QR disabled
* Staff permission changed
* Settings changed

Store:

```
user_id
library_id
action
entity_type
entity_id
old_values
new_values
IP
user agent
timestamp
```

---

# 28. Notifications

Create a notification architecture but don't require external WhatsApp/SMS integration in the first MVP.

Support future channels:

```
database
email
sms
whatsapp
push
```

Initial notifications:

* Membership expiring
* Fee due
* Payment received
* Admission successful
* Seat assigned
* Seat changed

Keep notification logic modular.

---

# 29. India-Specific Requirements

The system should be designed for India.

Default:

```
Currency: INR
Timezone: Asia/Kolkata
Date: DD-MM-YYYY
Time: 12-hour format with AM/PM
```

Support:

* Indian mobile numbers
* UPI
* Cash
* Bank transfer
* Indian states
* Pincode
* GST fields optionally

Do not force GST registration on every library.

GST should be configurable.

---

# 30. Privacy and Security

Do not store unnecessary sensitive information.

Do not require Aadhaar in the MVP.

If Aadhaar is ever supported, treat it as highly sensitive and follow applicable privacy/security requirements.

Security requirements:

* CSRF protection
* XSS protection
* SQL injection protection
* Mass assignment protection
* Authorization policies
* Tenant isolation
* Rate limiting
* Secure password hashing
* Secure QR tokens
* File upload validation
* Image validation
* Access control
* Audit logs
* Secure session handling

Never trust:

* library_id from frontend
* student_id from frontend
* branch_id from frontend
* seat_id from frontend
* payment amounts from frontend

Validate all server-side.

---

# 31. File Uploads

Student photos and library logos will be uploaded.

Validate:

* MIME type
* File size
* Image dimensions
* Extension

Do not trust filename/extensions.

Store using Laravel's filesystem abstraction.

Do not expose arbitrary uploaded files as executable content.

---

# 32. Soft Deletes

Use soft deletes where appropriate, especially:

* Students
* Libraries
* Branches
* Seats
* Rooms
* Users

Do not use deletion where historical financial/attendance records would be damaged.

Financial records should generally be retained.

---

# 33. Database Rules

Use:

* Foreign keys
* Indexes
* Unique constraints
* Composite indexes
* Proper decimal types for money

Never use floating point for currency.

Use:

```
DECIMAL(12,2)
```

for monetary amounts.

Store timestamps consistently.

Use Laravel date/time handling.

---

# 34. Money Rules

Never calculate financial totals using floating-point arithmetic.

All calculations should use decimal-safe logic.

Example:

```
subtotal
- discount
+ tax
= total
```

Validate that:

```
paid_amount <= total
```

unless handling refunds/adjustments explicitly.

---

# 35. UI/UX

The UI should look like a modern SaaS application.

Requirements:

* Clean
* Professional
* Minimal
* Responsive
* Mobile-friendly
* Fast
* Accessible

Use:

* Sidebar navigation
* Top navigation
* Cards
* Tables
* Filters
* Modals where appropriate
* Confirmation dialogs for destructive actions
* Toast notifications
* Empty states
* Loading states
* Validation messages

Avoid excessive animations.

---

# 36. Mobile Experience

Many library staff will use phones.

Make these especially mobile-friendly:

* QR scanner
* Student search
* Student profile
* Seat map
* Payment entry
* Attendance
* Digital ID

The QR scanner should work from a phone camera through the browser where supported.

---

# 37. QR Attendance Flow

Final expected flow:

```
Student arrives
    ↓
Scans QR
    ↓
System validates QR
    ↓
Validate student
    ↓
Validate membership
    ↓
Validate branch
    ↓
Check active seat
    ↓
Create attendance session
    ↓
Record entry
    ↓
Show success
```

Exit:

```
Student scans QR
    ↓
Find open session
    ↓
Record exit
    ↓
Calculate duration
    ↓
Close session
```

---

# 38. Membership Expiry Rules

Default:

If membership is expired:

```
Student cannot check in.
```

Show:

```
"Your membership has expired. Please contact the library to renew."
```

Library staff may have a configurable grace period.

Example:

```
Grace Period: 2 days
```

This should be configurable per library.

---

# 39. Seat Rules

Default rules:

1. One active allocation per seat.
2. One active seat per student/membership.
3. Expired membership should release the seat according to configured behavior.
4. Seat history must be retained.
5. Changing a seat closes the previous allocation.
6. Maintenance seats cannot be allocated.
7. Inactive seats cannot be allocated.
8. Staff cannot allocate a seat belonging to another active allocation.
9. All allocation changes should be logged.

Use transactions for allocation changes.

---

# 40. Membership Renewal

When renewing:

Do not destroy previous membership.

Example:

```
Membership #1
01 Sep → 30 Sep
Expired

Membership #2
01 Oct → 31 Oct
Active
```

Allow configurable renewal behavior:

### Option A

Renew from current expiry date.

### Option B

Renew from payment/current date.

Default should be:

If membership is still active, renewal starts after the existing expiry date.

If expired, renewal starts from current date.

---

# 41. Student Status

Support:

```
Active
Inactive
Suspended
Blacklisted
```

Suspended/blacklisted students cannot check in.

Do not delete historical data.

---

# 42. Initial SaaS Structure

Eventually support:

```
Super Admin
    ↓
SaaS Plans
    ↓
Library
    ↓
Branches
    ↓
Staff
    ↓
Students
```

SaaS billing can be implemented later.

Do not build the SaaS subscription payment system during the first MVP unless specifically requested.

---

# 43. Development Phases

Build in this order.

## Phase 0

Architecture and specification.

Complete:

* Database design
* Roles
* Permissions
* Business rules
* Navigation
* Tenant architecture

## Phase 1

Foundation:

* Laravel installation
* Authentication
* User management
* Roles
* Permissions
* Library
* Branches
* Settings

## Phase 2

Student management:

* Students
* Guardians
* Student profile
* Search
* Filters
* Status

## Phase 3

Physical library:

* Floors
* Rooms
* Seat types
* Seats
* Seat map

## Phase 4

Membership:

* Plans
* Memberships
* Renewals
* Expiry

## Phase 5

Fees:

* Invoices
* Invoice items
* Payments
* Receipts
* Partial payments
* Outstanding balances

## Phase 6

ID Cards:

* Card generation
* QR generation
* Printing
* PDF

## Phase 7

Attendance:

* QR scanner
* Entry
* Exit
* Sessions
* Scan history
* Manual corrections

## Phase 8

Student Portal:

* Dashboard
* Digital ID
* Attendance
* Fees
* Seat
* Profile

## Phase 9

Reports:

* Students
* Attendance
* Fees
* Seats

## Phase 10

Notifications:

* Email
* SMS architecture
* WhatsApp architecture

## Phase 11

Online admission:

* Public admission
* Plan selection
* Seat selection
* Online payment
* Automatic registration

## Phase 12

Advanced:

* Multiple branches
* PWA
* Mobile app
* Biometric
* RFID
* Face attendance
* Advanced analytics
* AI

---

# 44. Coding Rules

When implementing:

1. Do not put business logic directly into Blade templates.
2. Use Form Requests for validation.
3. Use Policies/Gates for authorization.
4. Use Services/Actions for complex business operations.
5. Use database transactions for multi-step operations.
6. Keep controllers thin.
7. Use Eloquent relationships correctly.
8. Avoid N+1 queries.
9. Use eager loading.
10. Add indexes to frequently queried columns.
11. Use enums/constants where appropriate.
12. Use Laravel conventions.
13. Keep code readable.
14. Avoid unnecessary packages.
15. Do not duplicate logic.
16. Write reusable components.
17. Add tests for important business rules.

---

# 45. Testing Requirements

Create tests for critical functionality.

At minimum:

### Authentication

* Login
* Logout
* Unauthorized access

### Tenant isolation

Library A cannot access Library B.

### Students

* Create
* Edit
* Search
* Deactivate

### Seats

* Assign
* Release
* Prevent duplicate allocation

### Membership

* Create
* Expire
* Renew

### Payments

* Full payment
* Partial payment
* Balance calculation

### Attendance

* Valid QR
* Invalid QR
* Expired membership
* Duplicate scan
* Entry
* Exit
* Missing checkout

### Authorization

Staff cannot access owner-only functions.

---

# 46. Routes

Use clean route structures.

Example:

```
/login

/dashboard

/students
/students/create
/students/{student}

/admissions/create

/memberships

/seats
/seats/map

/attendance
/attendance/scanner

/fees/invoices
/fees/payments

/id-cards

/reports

/settings
```

Student:

```
/student/dashboard
/student/id-card
/student/attendance
/student/fees
/student/profile
```

Admin routes should use appropriate middleware and policies.

---

# 47. API Readiness

Even though the first application uses Blade, design the domain so that APIs can be added later.

Do not couple business logic to Blade controllers.

For example:

```
AdmissionService
SeatAllocationService
AttendanceService
PaymentService
MembershipService
```

These services can later be called by:

```
Web
API
Mobile App
```

---

# 48. Important Services

Create service/action classes where appropriate:

```
StudentService
AdmissionService
MembershipService
SeatAllocationService
AttendanceService
InvoiceService
PaymentService
IDCardService
QRTokenService
NotificationService
ReportService
```

Don't create services just for the sake of abstraction. Use them where business logic is meaningful.

---

# 49. Error Handling

Use user-friendly errors.

Example:

Instead of:

```
SQLSTATE[23000] ...
```

show:

```
"This seat is already assigned to another student."
```

For QR:

```
"This QR code is no longer active."
```

For expired membership:

```
"This membership expired on 30 September 2026."
```

For duplicate attendance:

```
"Entry has already been recorded."
```

Log technical details server-side.

Never expose sensitive exceptions to users.

---

# 50. Seed Data

Create development seeders for:

* Super Admin
* Demo Library
* Demo Branch
* Demo Floor
* Demo Room
* Seat Types
* 20–50 demo seats
* Membership Plans
* Demo Staff
* Demo Students
* Sample memberships
* Sample invoices
* Sample payments
* Sample attendance

Create a convenient demo environment.

---

# 51. Dashboard Demo Data

The development environment should make the dashboard look realistic.

Example:

```
486 students
421 active
500 seats
421 occupied
287 attendance
₹3,82,000 monthly collection
```

But do not hardcode these values.

They must be generated from actual database records.

---

# 52. Deliverables

Build incrementally.

For every development phase provide:

1. Files created
2. Files modified
3. Database migrations
4. Models
5. Controllers
6. Services
7. Requests
8. Policies
9. Routes
10. Blade views
11. Components
12. Tests
13. Seeder changes
14. Commands to run
15. Manual testing steps

Do not dump the entire future application into one response.

Implement one phase at a time.

---

# 53. Critical Rule for AI Coding Agent

Before writing code for a phase:

1. Inspect the existing project.
2. Understand the current architecture.
3. Do not overwrite working code unnecessarily.
4. Check existing dependencies.
5. Reuse existing components where appropriate.
6. Confirm database state.
7. Implement the smallest complete version of the requested phase.
8. Run migrations.
9. Run tests.
10. Fix errors.
11. Explain what changed.

Do not silently change architecture.

If an architectural decision must change, explain why before implementing it.

---

# 54. Current Task

We are starting from Phase 0.

Do NOT immediately implement all phases.

First produce:

### A. Final ER/database relationship design

Show:

* Every table
* Important columns
* Primary keys
* Foreign keys
* Unique constraints
* Important indexes
* Relationships

### B. Final role/permission matrix

Show exactly what:

* Super Admin
* Library Owner
* Branch Manager
* Staff
* Student

can access.

### C. Final business rules

Document:

* Membership
* Seat allocation
* Attendance
* QR
* Fees
* Payments
* Renewal
* Expiry
* Student status
* Branch access

### D. Final application navigation

Show the menu for every role.

### E. Identify any missing requirements

Before generating Laravel migrations, identify architectural gaps or conflicts.

Do not start coding until the above Phase 0 specification is internally consistent.

After Phase 0 is approved, proceed to:

**Phase 1 — Laravel Foundation**

Start with:

* Project setup
* Environment configuration
* Authentication
* Users
* Roles
* Permissions
* Libraries
* Library settings
* Branches
* Seeders
* Policies
* Basic admin dashboard

Build the project incrementally and keep each phase production-quality.
