# System Patterns & Architecture

## Arsitektur Sistem

Sistem perpustakaan menggunakan arsitektur MVC (Model-View-Controller) dengan Laravel framework.

```mermaid
flowchart TD
    Client[Browser Client]
    Router[Web Router]
    MW[Middleware Layer]
    C[Controllers]
    M[Models]
    V[Views/Blade Templates]
    DB[(Database)]
    FS[File Storage]

    Client -->|HTTP Request| Router
    Router -->|Validate Route| MW
    MW -->|Process Request| C
    C -->|Query Data| M
    M -->|Get/Set Data| DB
    C -->|File Operations| FS
    C -->|Render| V
    V -->|HTML Response| Client
```

## Design Patterns

### 1. Repository Pattern

-   Pemisahan logika akses data dari controllers
-   Memudahkan unit testing
-   Contoh implementasi di model Book dan Peminjaman

### 2. Service Pattern

-   Business logic dipisahkan ke service classes
-   Reusable business rules
-   Contoh: PeminjamanService untuk logika peminjaman

### 3. Observer Pattern

-   Event handling untuk perubahan status peminjaman
-   Notifikasi perubahan status
-   Logging system events

### 4. Policy Pattern

-   Authorization logic untuk akses resources
-   Pemisahan logic dari controllers
-   Role-based access control

## Flow Data

### 1. Flow Peminjaman Buku

```mermaid
sequenceDiagram
    actor User
    participant Controller
    participant Service
    participant Model
    participant DB

    User->>Controller: Request Peminjaman
    Controller->>Service: Validate Request
    Service->>Model: Check Availability
    Model->>DB: Query Status
    DB-->>Model: Book Status
    Model-->>Service: Availability Status
    alt Book Available
        Service->>Model: Create Peminjaman
        Model->>DB: Save Record
        DB-->>Model: Success
        Model-->>Service: Created
        Service-->>Controller: Success Response
        Controller-->>User: Confirmation
    else Book Unavailable
        Service-->>Controller: Error Status
        Controller-->>User: Error Message
    end
```

### 2. Flow Upload Buku

```mermaid
sequenceDiagram
    actor Admin
    participant Controller
    participant Storage
    participant Model
    participant DB

    Admin->>Controller: Upload Book Files
    Controller->>Storage: Save Files
    Storage-->>Controller: File Paths
    Controller->>Model: Create Book Record
    Model->>DB: Save Book Data
    DB-->>Model: Success
    Model-->>Controller: Book Created
    Controller-->>Admin: Success Response
```

## Security Patterns

### 1. Authentication

-   Laravel built-in auth system
-   Session-based authentication
-   Remember me functionality

### 2. Authorization

```mermaid
flowchart TD
    R[Request] -->|Authenticate| MW[Middleware]
    MW -->|Check Role| P[Policy]
    P -->|Role: Admin| AA[Admin Actions]
    P -->|Role: Member| MA[Member Actions]
    P -->|Unauthorized| E[Error Response]
```

### 3. File Access Security

-   Private storage untuk file buku
-   Public storage untuk thumbnails
-   Validasi akses file melalui middleware
-   Secure file streaming

## Error Handling Pattern

### 1. Exception Handling

```mermaid
flowchart LR
    E[Exception] -->|Catch| H[Handler]
    H -->|Log| L[Logger]
    H -->|User Error| UR[User Response]
    H -->|System Error| SR[System Response]
```

### 2. Validation Pattern

-   Form request validation
-   Custom validation rules
-   Error messages dalam Bahasa Indonesia
-   Front-end validation sync

## Caching Pattern

### 1. Data Caching

-   Cache frequently accessed data
-   Cache tags untuk grouping
-   Automatic cache invalidation

### 2. Response Caching

-   Cache HTTP responses
-   Rate limiting
-   Cache headers

## Monitoring & Logging

### 1. Activity Logging

-   User actions logging
-   System events logging
-   Error logging

### 2. Performance Monitoring

-   Query performance logging
-   Cache hit/miss ratio
-   File access patterns

## Code Organization

### 1. Directory Structure

```
app/
├── Http/
│   ├── Controllers/    # Request handlers
│   ├── Middleware/     # Request filters
│   └── Requests/       # Form validation
├── Models/            # Database models
├── Services/          # Business logic
├── Policies/          # Authorization
├── Events/            # System events
└── Listeners/         # Event handlers
```

### 2. Naming Conventions

-   Controllers: PascalCase, suffix dengan Controller
-   Models: PascalCase, singular
-   Migrations: Snake_case dengan timestamp
-   Views: Kebab-case
-   Config: Snake_case

## Testing Pattern

### 1. Unit Testing

-   Model testing
-   Service testing
-   Isolated tests

### 2. Feature Testing

-   End-to-end testing
-   API testing
-   Authentication testing

### 3. Browser Testing

-   UI testing
-   User flow testing
-   JavaScript integration
