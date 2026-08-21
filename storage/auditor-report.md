# Laravel Auditor Report

**Generated:** 2026-08-19 16:36:13

## Project

- **name:** Webshop
- **environment:** local
- **php version:** 8.4.23
- **laravel version:** v12.64.0
- **database:** sqlite
- **test framework:** pest
- **frontend:** detected, detected, 1

## Summary

**Findings:** 6

| Severity | Count |
| --- | --- |
| Critical | 0 |
| High | 0 |
| Medium | 5 |
| Low | 1 |
| Info | 0 |

| Domain | Count |
| --- | --- |
| Architecture | 1 |
| Database | 1 |
| Performance | 2 |
| Testing | 2 |

## Priority synthesis

**Final partition:** 6 unique recommendation(s). Every promoted ID appears exactly once.

- **P0 - correctness, security, or data-loss risk** (0): none
- **P1 - concrete correctness or high-leverage contract work** (4): F-2026-0002, F-2026-0005, F-2026-0001, F-2026-0006
- **P2 - material invariant improvements with narrower impact** (2): F-2026-0003, F-2026-0004
- **P3 - lower-impact telemetry, diagnostics, or maintainability** (0): none

## Domains Audited

- Security
- Performance
- Architecture
- Database
- Testing
- Laravel conventions

## Findings

### [MEDIUM] Commerce foreign-key columns have no database constraints `F-2026-0002`

**Rule:** `AUD-DB-004` — Database
**Severity:** Medium
**Confidence:** Confirmed
**Status:** Open

**Summary**

The commerce schema stores relationships as unsigned integer columns without foreign keys, so orphaned carts, cart items, variants, orders, and order items are not prevented by the database.

**Why it matters**

Application-level Eloquent relationships can return missing related records or preserve invalid references after deletes, undermining order and cart data integrity.

**Evidence**

- `file` — database/migrations/2025_06_07_163813_create_product_variants_table.php:14-19
- `file` — database/migrations/2025_06_07_163859_create_carts_table.php:14-18
- `file` — database/migrations/2025_06_07_163918_create_cart_items_table.php:14-19
- `file` — database/migrations/2025_06_28_124119_create_orders_table.php:14-25
- `file` — database/migrations/2025_06_28_124606_create_order_items_table.php:14-26
- `schema` — live SQLite schema: cart_items and carts

**Affected resources**

- `database/migrations/2025_06_07_163813_create_product_variants_table.php`
- `database/migrations/2025_06_07_163859_create_carts_table.php`
- `database/migrations/2025_06_07_163918_create_cart_items_table.php`
- `database/migrations/2025_06_28_124119_create_orders_table.php`
- `database/migrations/2025_06_28_124606_create_order_items_table.php`

**Recommendation**

Add forward-only constraints for each relationship with explicitly chosen delete behavior, then validate existing data before applying them.

**Verification notes**

Migration source and the configured SQLite schema were both inspected; no foreign keys were reported.

### [MEDIUM] Payment completion and order persistence lack integration coverage `F-2026-0005`

**Rule:** `AUD-TST-001` — Testing
**Severity:** Medium
**Confidence:** Confirmed
**Status:** Open

**Summary**

The test inventory covers checkout-session creation but has no test for Stripe webhook dispatch, checkout completion, order creation, cart cleanup, or confirmation mail.

**Why it matters**

The highest-value state transition in the shop is unprotected by an executable test, including the replay-sensitive behavior identified above.

**Evidence**

- `test` — tests/Unit/WebShop/CreateStripeCheckoutSessionTest.php:10-38
- `file` — app/Listeners/StripeEventListener.php:14-18
- `file` — app/Actions/WebShop/StripeCheckoutSessionCompleted.php:18-75
- `test` — Auditor test inventory: 22 files

**Affected resources**

- `app/Listeners/StripeEventListener.php`
- `app/Actions/WebShop/StripeCheckoutSessionCompleted.php`
- `tests/Unit/WebShop/CreateStripeCheckoutSessionTest.php`

**Recommendation**

Add integration coverage for a valid completion, duplicate completion, missing/invalid metadata, persisted order items, cart cleanup, and confirmation-mail behavior.

**Verification notes**

Test inventory and source search were cross-checked. Full execution was blocked by the environment's inability to bind a local browser-test port.

### [MEDIUM] Stripe checkout completion is not idempotent `F-2026-0001`

**Rule:** `AUD-DSA-001` — Architecture
**Severity:** Medium
**Confidence:** High
**Status:** Open

**Summary**

Every checkout.session.completed webhook reaches order creation without a prior duplicate check or a database uniqueness constraint on the Stripe session id.

**Why it matters**

A replayed or retried completion can create another order, resend confirmation mail, and repeat cart deletion for the same paid checkout.

**Evidence**

- `file` — app/Listeners/StripeEventListener.php:14-18
- `file` — app/Actions/WebShop/StripeCheckoutSessionCompleted.php:20-25
- `file` — database/migrations/2025_06_28_124119_create_orders_table.php:14-25
- `file` — app/Actions/WebShop/StripeCheckoutSessionCompleted.php:70-74

**Affected resources**

- `app/Listeners/StripeEventListener.php`
- `app/Actions/WebShop/StripeCheckoutSessionCompleted.php`
- `database/migrations/2025_06_28_124119_create_orders_table.php`

**Recommendation**

Make completion idempotent using a unique database constraint and an atomic existing-order check before creating the order; ensure duplicate deliveries do not resend mail or repeat cart cleanup.

**Verification notes**

Static trace was cross-checked against the orders migration and live SQLite schema. No runtime duplicate event was generated.

### [MEDIUM] Checkout formats cart variants without eager loading `F-2026-0003`

**Rule:** `AUD-PER-001` — Performance
**Severity:** Medium
**Confidence:** High
**Status:** Open

**Summary**

Checkout explicitly eager-loads product but accesses each cart item's variant inside the item map without eager loading the variant relation.

**Why it matters**

Checkout requests with multiple cart items can issue one additional variant query per item, increasing database round trips on a payment-start path.

**Evidence**

- `file` — app/Actions/WebShop/CreateStripeCheckoutSession.php:34-36
- `file` — app/Actions/WebShop/CreateStripeCheckoutSession.php:38-53
- `file` — app/Models/CartItem.php:29-32
- `file` — app/Actions/WebShop/CreateStripeCheckoutSession.php:16

**Affected resources**

- `app/Actions/WebShop/CreateStripeCheckoutSession.php`
- `app/Models/CartItem.php`

**Recommendation**

Eager-load variant together with product before mapping the cart items, and add a query-count regression test for a multi-item cart.

**Verification notes**

The relationship definition and formatter access were traced statically; no production query trace was available.

### [MEDIUM] Admin-panel authorization boundary is not tested `F-2026-0006`

**Rule:** `AUD-TST-003` — Testing
**Severity:** Medium
**Confidence:** High
**Status:** Open

**Summary**

The application gates Filament access by configured admin email, but the test suite does not verify that the configured administrator is accepted and another authenticated user is rejected.

**Why it matters**

A regression in the panel-access predicate could expose product and customer-order administration or lock out the only intended administrator without a failing test.

**Evidence**

- `file` — app/Models/User.php:17
- `file` — app/Models/User.php:93-96
- `file` — app/Providers/Filament/AdminPanelProvider.php:24-57
- `test` — tests/Unit/Filament/ProductResourceTest.php:8-57
- `context` — policies_authorization

**Affected resources**

- `app/Models/User.php`
- `app/Providers/Filament/AdminPanelProvider.php`
- `tests/Unit/Filament/ProductResourceTest.php`

**Recommendation**

Add authenticated allowed/denied panel-access tests and resource-level tests for the destructive product/order actions.

**Verification notes**

The access predicate, panel middleware, authorization inventory, and Filament tests were inspected. No behavior was changed or inferred beyond the missing assertions.

### [LOW] Order history loads every order item in one request `F-2026-0004`

**Rule:** `AUD-PER-006` — Performance
**Severity:** Low
**Confidence:** Confirmed
**Status:** Open

**Summary**

The authenticated orders page retrieves the user's complete order-item history with get() and has no pagination or limit.

**Why it matters**

The response and memory cost grow with a user's entire purchase history rather than with a bounded page size.

**Evidence**

- `file` — routes/web.php:18-22
- `file` — app/Livewire/Orders.php:12-15
- `test` — tests/Feature and tests/Unit

**Affected resources**

- `app/Livewire/Orders.php`
- `routes/web.php`

**Recommendation**

Use pagination or another explicit bound for order history and verify the intended display behavior with a feature test.

**Verification notes**

The route and query were inspected directly; dataset size in production was not available.

