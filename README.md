# event-management-system
Single page web application for IT2001 course project



Event Management System

**Single Page Application (SPA)**

> Status: Milestone 1 — Static frontend SPA (SPApp) sa pripremljenom strukturom i ERD skicom baze podataka.

- **Frontend:** HTML, CSS, JavaScript  
  - [Bootstrap 5 (Lux theme)](https://bootswatch.com/lux/) — dizajn i responsive layout  
  - [SPApp jQuery Plugin](https://github.com/amiletti/spapp) — za Single Page navigaciju bez reload-a  


ERD draft

erDiagram
  USERS ||--o{ ORDERS : places
  USERS }o--o{ ROLES : has
  ROLES ||--o{ USER_ROLES : includes
  VENUES ||--o{ EVENTS : hosts
  EVENTS ||--o{ TICKETS : offers
  EVENTS ||--o{ ORDERS : purchased_for
  ORDERS ||--o{ ORDER_ITEMS : contains
  TICKETS ||--o{ ORDER_ITEMS : listed
  ...




Milestone 2

Project Overview
Event Management System (EMS) is a single-page web application designed to simplify the process of organizing and managing events.  
The system allows organizers to create events, manage venues and ticket types, and users to browse events and make bookings.

This milestone focuses on **backend functionality** — setting up the database, implementing the DAO layer, CRUD operations, and initial data seeding.

---

Features Implemented 
Relational MySQL database with 5 interconnected entities  
Database creation script (`ems.sql`)  
DAO Layer with BaseDAO and five entity-specific DAO classes  
CRUD operations for:
- Users  
- Venues  
- Events  
- Ticket Types  
- Orders  

 `config.php` – Database connection class  
 `test_connection.php` – Confirms database connection  
 `seed_demo.php` – Inserts demo records into the database  
 Structured project folders for clean organization  


Project structure:
backend/
│
├── dao/
│ ├── BaseDAO.php
│ ├── UserDAO.php
│ ├── VenueDAO.php
│ ├── EventDAO.php
│ ├── TicketTypeDAO.php
│ ├── OrderDAO.php
│ └── OrderItemDAO.php
│
├── database/
│ └── ems.sql
│
├── config.php
├── seed_demo.php
└── test_connection.php

frontend/
│
├── assets/
├── js/
├── css/
└── views/

